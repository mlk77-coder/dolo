<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CarouselImageResource;
use App\Models\MobileCarouselImage;
use Illuminate\Http\JsonResponse;

class CarouselController extends Controller
{
    /**
     * Get all active carousel images sorted by sort_order.
     * This is a public endpoint - no authentication required.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $carouselImages = MobileCarouselImage::where('status', 'active')
                ->orderBy('sort_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Carousel images retrieved successfully',
                'data' => CarouselImageResource::collection($carouselImages)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve carousel images',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
