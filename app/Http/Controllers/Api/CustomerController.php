<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Http\Resources\Api\CustomerProfileResource;
use App\Http\Resources\Api\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Get authenticated customer profile with order history.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function profile(Request $request): JsonResponse
    {
        try {
            $customer = $request->user();
            
            // Load orders with their relationships
            $customer->load(['orders' => function($query) {
                $query->with(['deal', 'merchant'])
                      ->orderBy('created_at', 'desc');
            }]);

            return response()->json([
                'success' => true,
                'message' => 'Customer profile retrieved successfully',
                'data' => new CustomerProfileResource($customer)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get customer order history.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function orderHistory(Request $request): JsonResponse
    {
        try {
            $customer = $request->user();
            
            $perPage = $request->input('per_page', 15);
            
            $orders = $customer->orders()
                ->with(['deal', 'merchant'])
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Order history retrieved successfully',
                'data' => [
                    'orders' => $orders->items(),
                    'pagination' => [
                        'total' => $orders->total(),
                        'per_page' => $orders->perPage(),
                        'current_page' => $orders->currentPage(),
                        'last_page' => $orders->lastPage(),
                        'from' => $orders->firstItem(),
                        'to' => $orders->lastItem(),
                    ]
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve order history',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update customer profile.
     * 
     * Note: Phone number cannot be updated as it's unique identifier.
     *
     * @param UpdateProfileRequest $request
     * @return JsonResponse
     */
    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        try {
            $customer = $request->user();
            $data = [];

            // Update name and surname
            if ($request->has('name')) {
                $data['name'] = $request->name;
            }
            if ($request->has('surname')) {
                $data['surname'] = $request->surname;
            }

            // Update email (with uniqueness check)
            if ($request->has('email')) {
                $data['email'] = $request->email;
            }

            // Update username
            if ($request->has('username')) {
                $data['username'] = $request->username;
            }

            // Update date of birth
            if ($request->has('date_of_birth')) {
                $data['date_of_birth'] = $request->date_of_birth;
            }

            // Update gender
            if ($request->has('gender')) {
                $data['gender'] = $request->gender;
            }

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($customer->avatar && Storage::disk('public')->exists($customer->avatar)) {
                    Storage::disk('public')->delete($customer->avatar);
                }
                
                // Store new avatar
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $data['avatar'] = $avatarPath;
            }

            // Handle password update
            if ($request->has('password')) {
                // Verify current password
                if (!Hash::check($request->current_password, $customer->password)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Current password is incorrect',
                        'errors' => [
                            'current_password' => ['The current password is incorrect']
                        ]
                    ], 422);
                }

                // Update password
                $data['password'] = Hash::make($request->password);
            }

            // Update customer
            $customer->update($data);

            // Reload customer with fresh data
            $customer->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => new UserResource($customer)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
