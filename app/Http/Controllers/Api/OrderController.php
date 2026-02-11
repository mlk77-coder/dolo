<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Create a new order
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validation
            $validator = Validator::make($request->all(), [
                'deal_id' => ['required', 'integer', 'exists:deals,id'],
                'quantity' => ['required', 'integer', 'min:1', 'max:10'],
                'payment_method' => ['required', 'in:cash_on_delivery,credit_card,wallet'],
                'notes' => ['nullable', 'string', 'max:500'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'فشل التحقق من البيانات',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $validated = $validator->validated();
            $user = $request->user();

            // Get the deal
            $deal = Deal::with(['merchant', 'category'])->findOrFail($validated['deal_id']);

            // Check deal availability
            $now = Carbon::now();
            $isAvailable = $deal->status === 'active' 
                && $deal->start_date <= $now 
                && $deal->end_date >= $now;

            if (!$isAvailable) {
                return response()->json([
                    'success' => false,
                    'message' => 'فشل إنشاء الطلب',
                    'errors' => [
                        'deal_id' => ['العرض غير متوفر']
                    ],
                ], 409);
            }

            // Check stock availability
            if ($deal->quantity < $validated['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => 'فشل إنشاء الطلب',
                    'errors' => [
                        'quantity' => ['الكمية المطلوبة غير متوفرة في المخزون']
                    ],
                ], 409);
            }

            // Start database transaction
            DB::beginTransaction();

            try {
                // Calculate prices
                $unitPrice = $deal->discounted_price;
                $totalPrice = $unitPrice * $validated['quantity'];
                $discountAmount = ($deal->original_price - $deal->discounted_price) * $validated['quantity'];
                $finalPrice = $totalPrice;

                // Generate order number
                $orderNumber = Order::generateOrderNumber();

                // Create order
                $order = Order::create([
                    'user_id' => $user->id,
                    'deal_id' => $deal->id,
                    'merchant_id' => $deal->merchant_id,
                    'order_number' => $orderNumber,
                    'quantity' => $validated['quantity'],
                    'unit_price' => $unitPrice,
                    'total' => $totalPrice,
                    'total_price' => $totalPrice,
                    'discount_amount' => $discountAmount,
                    'final_price' => $finalPrice,
                    'payment_method' => $validated['payment_method'],
                    'payment_status' => 'pending',
                    'order_status' => 'pending',
                    'notes' => $validated['notes'] ?? null,
                    'estimated_delivery' => now()->addDays(3), // 3 days delivery estimate
                ]);

                // Add status history
                $order->addStatusHistory('pending', 'تم إنشاء الطلب');

                // Update deal inventory
                $deal->decrement('quantity', $validated['quantity']);
                $deal->increment('buyer_counter', $validated['quantity']);

                DB::commit();

                // Load relationships for response
                $order->load(['deal', 'merchant', 'user']);

                return response()->json([
                    'success' => true,
                    'message' => 'تم إنشاء الطلب بنجاح',
                    'data' => [
                        'order' => $this->transformOrder($order)
                    ],
                ], 201);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'العرض غير موجود',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في الخادم',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get user's orders
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'page' => ['nullable', 'integer', 'min:1'],
                'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
                'status' => ['nullable', 'in:all,pending,confirmed,preparing,ready,delivered,cancelled'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'فشل التحقق من البيانات',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $user = $request->user();
            $perPage = $request->get('per_page', 10);
            $status = $request->get('status', 'all');

            $query = Order::with(['deal.images', 'deal.merchant'])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc');

            // Filter by status
            if ($status !== 'all') {
                $query->where('order_status', $status);
            }

            $orders = $query->paginate($perPage);

            $transformedOrders = $orders->getCollection()->map(function ($order) {
                return $this->transformOrderList($order);
            });

            return response()->json([
                'success' => true,
                'message' => 'تم جلب الطلبات بنجاح',
                'data' => $transformedOrders,
                'pagination' => [
                    'total' => $orders->total(),
                    'per_page' => $orders->perPage(),
                    'current_page' => $orders->currentPage(),
                    'last_page' => $orders->lastPage(),
                    'from' => $orders->firstItem(),
                    'to' => $orders->lastItem(),
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في الخادم',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get order details
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        try {
            $user = $request->user();
            
            $order = Order::with([
                'deal.images',
                'deal.merchant',
                'deal.category',
                'user',
                'statusHistory'
            ])->findOrFail($id);

            // Check authorization - user can only view their own orders
            if ($order->user_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'غير مسموح',
                ], 403);
            }

            return response()->json([
                'success' => true,
                'message' => 'تم جلب تفاصيل الطلب بنجاح',
                'data' => $this->transformOrderDetail($order),
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'الطلب غير موجود',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في الخادم',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Cancel an order
     * 
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'reason' => ['nullable', 'string', 'max:500'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'فشل التحقق من البيانات',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $user = $request->user();
            $order = Order::with('deal')->findOrFail($id);

            // Check authorization
            if ($order->user_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'غير مسموح',
                ], 403);
            }

            // Check if order can be cancelled
            if (!in_array($order->order_status, ['pending', 'confirmed'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'لا يمكن إلغاء هذا الطلب',
                    'errors' => [
                        'order_status' => ['يمكن إلغاء الطلبات في حالة "قيد الانتظار" أو "مؤكد" فقط']
                    ],
                ], 400);
            }

            DB::beginTransaction();

            try {
                // Update order status
                $order->update([
                    'order_status' => 'cancelled',
                    'cancelled_at' => now(),
                    'cancellation_reason' => $request->input('reason'),
                ]);

                // Add status history
                $order->addStatusHistory('cancelled', $request->input('reason', 'تم إلغاء الطلب من قبل العميل'));

                // Restore inventory
                if ($order->deal) {
                    $order->deal->increment('quantity', $order->quantity);
                    $order->deal->decrement('buyer_counter', $order->quantity);
                }

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'تم إلغاء الطلب بنجاح',
                    'data' => [
                        'order_id' => $order->id,
                        'order_status' => $order->order_status,
                        'cancelled_at' => $order->cancelled_at->toIso8601String(),
                    ],
                ], 200);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'الطلب غير موجود',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في الخادم',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Transform order for creation response
     */
    private function transformOrder($order)
    {
        return [
            'id' => $order->id,
            'order_number' => $order->order_number,
            'user_id' => $order->user_id,
            'deal_id' => $order->deal_id,
            'deal_title' => $order->deal ? $order->deal->title_en : null,
            'merchant_name' => $order->merchant ? $order->merchant->business_name : null,
            'quantity' => $order->quantity,
            'unit_price' => (float) $order->unit_price,
            'total_price' => (float) $order->total_price,
            'discount_amount' => (float) $order->discount_amount,
            'final_price' => (float) $order->final_price,
            'payment_method' => $order->payment_method,
            'payment_status' => $order->payment_status,
            'order_status' => $order->order_status,
            'notes' => $order->notes,
            'created_at' => $order->created_at->toIso8601String(),
            'estimated_delivery' => $order->estimated_delivery ? $order->estimated_delivery->toIso8601String() : null,
        ];
    }

    /**
     * Transform order for list view
     */
    private function transformOrderList($order)
    {
        // Get primary image
        $primaryImage = null;
        if ($order->deal && $order->deal->images) {
            $primary = $order->deal->images->where('is_primary', true)->first();
            if (!$primary) {
                $primary = $order->deal->images->first();
            }
            if ($primary) {
                $primaryImage = asset('storage/' . $primary->image_url);
            }
        }

        return [
            'id' => $order->id,
            'order_number' => $order->order_number,
            'deal' => [
                'id' => $order->deal_id,
                'title' => $order->deal ? $order->deal->title_en : null,
                'image' => $primaryImage,
                'merchant_name' => $order->deal && $order->deal->merchant ? $order->deal->merchant->business_name : null,
            ],
            'quantity' => $order->quantity,
            'final_price' => (float) $order->final_price,
            'payment_method' => $order->payment_method,
            'payment_status' => $order->payment_status,
            'order_status' => $order->order_status,
            'created_at' => $order->created_at->toIso8601String(),
            'estimated_delivery' => $order->estimated_delivery ? $order->estimated_delivery->toIso8601String() : null,
        ];
    }

    /**
     * Transform order for detail view
     */
    private function transformOrderDetail($order)
    {
        // Get all images
        $images = [];
        if ($order->deal && $order->deal->images) {
            $images = $order->deal->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'url' => asset('storage/' . $image->image_url),
                    'is_primary' => (bool) $image->is_primary,
                ];
            })->toArray();
        }

        // Get status history
        $statusHistory = $order->statusHistory->map(function ($history) {
            return [
                'status' => $history->status,
                'timestamp' => $history->created_at->toIso8601String(),
                'note' => $history->note,
            ];
        })->toArray();

        return [
            'id' => $order->id,
            'order_number' => $order->order_number,
            'user' => [
                'id' => $order->user->id,
                'name' => $order->user->name ?? $order->user->username,
                'phone' => $order->user->phone,
                'email' => $order->user->email,
            ],
            'deal' => [
                'id' => $order->deal->id,
                'title' => $order->deal->title_en,
                'description' => $order->deal->description,
                'image' => $images[0]['url'] ?? null,
                'merchant' => [
                    'id' => $order->deal->merchant_id,
                    'name' => $order->deal->merchant ? $order->deal->merchant->business_name : null,
                    'phone' => $order->deal->merchant ? $order->deal->merchant->phone : null,
                    'email' => $order->deal->merchant ? $order->deal->merchant->email : null,
                ],
                'location' => [
                    'city' => $order->deal->city,
                    'area' => $order->deal->area,
                    'location_name' => $order->deal->location_name,
                    'latitude' => $order->deal->latitude ? (float) $order->deal->latitude : null,
                    'longitude' => $order->deal->longitude ? (float) $order->deal->longitude : null,
                ],
            ],
            'quantity' => $order->quantity,
            'unit_price' => (float) $order->unit_price,
            'total_price' => (float) $order->total_price,
            'discount_amount' => (float) $order->discount_amount,
            'final_price' => (float) $order->final_price,
            'payment_method' => $order->payment_method,
            'payment_status' => $order->payment_status,
            'order_status' => $order->order_status,
            'notes' => $order->notes,
            'created_at' => $order->created_at->toIso8601String(),
            'updated_at' => $order->updated_at->toIso8601String(),
            'estimated_delivery' => $order->estimated_delivery ? $order->estimated_delivery->toIso8601String() : null,
            'status_history' => $statusHistory,
        ];
    }
}
