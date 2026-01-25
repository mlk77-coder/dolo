<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Get all categories with deal counts.
     * This is a public endpoint - no authentication required.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $categories = Category::withCount('deals')
                ->orderBy('name_en', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Categories retrieved successfully',
                'data' => CategoryResource::collection($categories)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a specific category by ID with deal count.
     * This is a public endpoint - no authentication required.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $category = Category::withCount('deals')->find($id);

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Category retrieved successfully',
                'data' => new CategoryResource($category)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve category',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
