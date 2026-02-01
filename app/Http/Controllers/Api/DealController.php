<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DealController extends Controller
{
    /**
     * Get all active deals for mobile app home screen
     * 
     * Supports filtering, sorting, and pagination
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            // Validate query parameters
            $validated = $request->validate([
                'sort_by' => ['nullable', 'string', 'in:price,name,position'],
                'order' => ['nullable', 'string', 'in:asc,desc'],
                'min_price' => ['nullable', 'numeric', 'min:0'],
                'max_price' => ['nullable', 'numeric', 'min:0'],
                'category_id' => ['nullable', 'integer', 'exists:categories,id'],
                'merchant_id' => ['nullable', 'integer', 'exists:merchants,id'],
                'featured' => ['nullable', 'boolean'],
                'search' => ['nullable', 'string', 'max:255'],
                'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
                'page' => ['nullable', 'integer', 'min:1'],
            ]);

            // Start query with active deals only
            $query = Deal::with(['merchant:id,business_name', 'category:id,name_en,name_ar'])
                ->where('status', 'active')
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now());

            // Price range filtering
            if ($request->has('min_price')) {
                $query->where('discounted_price', '>=', $validated['min_price']);
            }

            if ($request->has('max_price')) {
                $query->where('discounted_price', '<=', $validated['max_price']);
            }

            // Category filter
            if ($request->has('category_id')) {
                $query->where('category_id', $validated['category_id']);
            }

            // Merchant filter
            if ($request->has('merchant_id')) {
                $query->where('merchant_id', $validated['merchant_id']);
            }

            // Featured filter
            if ($request->has('featured')) {
                $query->where('featured', $validated['featured']);
            }

            // Search by title (English or Arabic)
            if ($request->has('search')) {
                $search = $validated['search'];
                $query->where(function($q) use ($search) {
                    $q->where('title_en', 'like', "%{$search}%")
                      ->orWhere('title_ar', 'like', "%{$search}%");
                });
            }

            // Sorting with validation
            $sortBy = $request->get('sort_by', 'position');
            $order = $request->get('order', 'asc');

            // Map sort_by values to actual database columns
            $sortMapping = [
                'price' => 'discounted_price',
                'name' => 'title_en',
                'position' => 'sort_order',
            ];

            $sortColumn = $sortMapping[$sortBy] ?? 'sort_order';
            
            // Apply sorting
            $query->orderBy($sortColumn, $order);
            
            // Secondary sort by created_at for consistency
            if ($sortColumn !== 'created_at') {
                $query->orderBy('created_at', 'desc');
            }

            // Pagination (default 20 items per page)
            $perPage = $request->get('per_page', 20);
            $deals = $query->paginate($perPage);

            // Transform the data
            $transformedDeals = $deals->getCollection()->map(function ($deal) {
                return $this->transformDeal($deal);
            });

            return response()->json([
                'success' => true,
                'message' => 'Deals retrieved successfully',
                'data' => $transformedDeals,
                'pagination' => [
                    'total' => $deals->total(),
                    'per_page' => $deals->perPage(),
                    'current_page' => $deals->currentPage(),
                    'last_page' => $deals->lastPage(),
                    'from' => $deals->firstItem(),
                    'to' => $deals->lastItem(),
                    'next_page_url' => $deals->nextPageUrl(),
                    'prev_page_url' => $deals->previousPageUrl(),
                ],
                'filters_applied' => [
                    'sort_by' => $sortBy,
                    'order' => $order,
                    'min_price' => $request->get('min_price'),
                    'max_price' => $request->get('max_price'),
                    'category_id' => $request->get('category_id'),
                    'merchant_id' => $request->get('merchant_id'),
                    'featured' => $request->get('featured'),
                    'search' => $request->get('search'),
                ],
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve deals',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get a single deal by ID
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $deal = Deal::with(['merchant:id,business_name,phone,email', 'category:id,name_en,name_ar', 'images'])
                ->findOrFail($id);

            // Check if deal is active and within date range
            $isAvailable = $deal->status === 'active' 
                && $deal->start_date <= now() 
                && $deal->end_date >= now();

            return response()->json([
                'success' => true,
                'message' => 'Deal retrieved successfully',
                'data' => $this->transformDealDetail($deal, $isAvailable),
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Deal not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve deal',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get featured deals
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function featured(Request $request)
    {
        try {
            $limit = $request->get('limit', 10);
            
            $deals = Deal::with(['merchant:id,business_name', 'category:id,name_en,name_ar'])
                ->where('status', 'active')
                ->where('featured', true)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->orderBy('sort_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();

            $transformedDeals = $deals->map(function ($deal) {
                return $this->transformDeal($deal);
            });

            return response()->json([
                'success' => true,
                'message' => 'Featured deals retrieved successfully',
                'data' => $transformedDeals,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve featured deals',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get deals by category
     * 
     * @param int $categoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function byCategory($categoryId, Request $request)
    {
        try {
            $perPage = $request->get('per_page', 20);
            
            $deals = Deal::with(['merchant:id,business_name', 'category:id,name_en,name_ar'])
                ->where('category_id', $categoryId)
                ->where('status', 'active')
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->orderBy('sort_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);

            $transformedDeals = $deals->getCollection()->map(function ($deal) {
                return $this->transformDeal($deal);
            });

            return response()->json([
                'success' => true,
                'message' => 'Deals retrieved successfully',
                'data' => $transformedDeals,
                'pagination' => [
                    'total' => $deals->total(),
                    'per_page' => $deals->perPage(),
                    'current_page' => $deals->currentPage(),
                    'last_page' => $deals->lastPage(),
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve deals',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Transform deal data for list view (home screen)
     * 
     * @param Deal $deal
     * @return array
     */
    private function transformDeal($deal)
    {
        // Get primary image or first image
        $primaryImage = $deal->images()->where('is_primary', true)->first();
        if (!$primaryImage) {
            $primaryImage = $deal->images()->first();
        }

        // Calculate if deal is available
        $now = Carbon::now();
        $isAvailable = $deal->status === 'active' 
            && $deal->start_date <= $now 
            && $deal->end_date >= $now;

        // Calculate time remaining
        $timeRemaining = null;
        if ($isAvailable && $deal->end_date) {
            $endDate = Carbon::parse($deal->end_date);
            $diff = $now->diff($endDate);
            $timeRemaining = [
                'days' => $diff->days,
                'hours' => $diff->h,
                'minutes' => $diff->i,
                'seconds' => $diff->s,
                'total_seconds' => $now->diffInSeconds($endDate),
            ];
        }

        return [
            'id' => $deal->id,
            'title' => [
                'en' => $deal->title_en,
                'ar' => $deal->title_ar,
            ],
            'merchant' => [
                'id' => $deal->merchant_id,
                'name' => $deal->merchant ? $deal->merchant->business_name : null,
            ],
            'category' => [
                'id' => $deal->category_id,
                'name_en' => $deal->category ? $deal->category->name_en : null,
                'name_ar' => $deal->category ? $deal->category->name_ar : null,
            ],
            'prices' => [
                'original' => (float) $deal->original_price,
                'discounted' => (float) $deal->discounted_price,
                'discount_percentage' => (float) $deal->discount_percentage,
                'savings' => (float) ($deal->original_price - $deal->discounted_price),
            ],
            'buyer_counter' => [
                'count' => (int) $deal->buyer_counter,
                'show' => (bool) $deal->show_buyer_counter,
            ],
            'image' => $primaryImage ? asset('storage/' . $primaryImage->image_url) : null,
            'availability' => [
                'is_available' => $isAvailable,
                'status' => $deal->status,
                'start_date' => $deal->start_date ? $deal->start_date->toIso8601String() : null,
                'end_date' => $deal->end_date ? $deal->end_date->toIso8601String() : null,
                'time_remaining' => $timeRemaining,
            ],
            'featured' => (bool) $deal->featured,
            'quantity' => (int) $deal->quantity,
            'show_savings_percentage' => (bool) $deal->show_savings_percentage,
        ];
    }

    /**
     * Transform deal data for detail view
     * 
     * @param Deal $deal
     * @param bool $isAvailable
     * @return array
     */
    private function transformDealDetail($deal, $isAvailable)
    {
        // Get all images
        $images = $deal->images->map(function ($image) {
            return [
                'id' => $image->id,
                'url' => asset('storage/' . $image->image_url),
                'is_primary' => (bool) $image->is_primary,
            ];
        });

        // Calculate time remaining
        $now = Carbon::now();
        $timeRemaining = null;
        if ($isAvailable && $deal->end_date) {
            $endDate = Carbon::parse($deal->end_date);
            $diff = $now->diff($endDate);
            $timeRemaining = [
                'days' => $diff->days,
                'hours' => $diff->h,
                'minutes' => $diff->i,
                'seconds' => $diff->s,
                'total_seconds' => $now->diffInSeconds($endDate),
            ];
        }

        return [
            'id' => $deal->id,
            'title' => [
                'en' => $deal->title_en,
                'ar' => $deal->title_ar,
            ],
            'sku' => $deal->sku,
            'merchant' => [
                'id' => $deal->merchant_id,
                'name' => $deal->merchant ? $deal->merchant->business_name : null,
                'phone' => $deal->merchant ? $deal->merchant->phone : null,
                'email' => $deal->merchant ? $deal->merchant->email : null,
            ],
            'category' => [
                'id' => $deal->category_id,
                'name_en' => $deal->category ? $deal->category->name_en : null,
                'name_ar' => $deal->category ? $deal->category->name_ar : null,
            ],
            'prices' => [
                'original' => (float) $deal->original_price,
                'discounted' => (float) $deal->discounted_price,
                'discount_percentage' => (float) $deal->discount_percentage,
                'savings' => (float) ($deal->original_price - $deal->discounted_price),
            ],
            'buyer_counter' => [
                'count' => (int) $deal->buyer_counter,
                'show' => (bool) $deal->show_buyer_counter,
            ],
            'quantity' => (int) $deal->quantity,
            'description' => $deal->description,
            'deal_information' => $deal->deal_information,
            'video_url' => $deal->video_url,
            'location' => [
                'city' => $deal->city,
                'area' => $deal->area,
                'location_name' => $deal->location_name,
                'latitude' => $deal->latitude ? (float) $deal->latitude : null,
                'longitude' => $deal->longitude ? (float) $deal->longitude : null,
            ],
            'images' => $images,
            'availability' => [
                'is_available' => $isAvailable,
                'status' => $deal->status,
                'start_date' => $deal->start_date ? $deal->start_date->toIso8601String() : null,
                'end_date' => $deal->end_date ? $deal->end_date->toIso8601String() : null,
                'time_remaining' => $timeRemaining,
            ],
            'featured' => (bool) $deal->featured,
            'show_savings_percentage' => (bool) $deal->show_savings_percentage,
            'created_at' => $deal->created_at->toIso8601String(),
            'updated_at' => $deal->updated_at->toIso8601String(),
        ];
    }
}
