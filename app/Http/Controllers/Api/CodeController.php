<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CodeResource;
use App\Models\Code;
use Illuminate\Http\JsonResponse;

class CodeController extends Controller
{
    /**
     * Get all active and valid codes.
     * This is a public endpoint - no authentication required.
     * Returns only active codes that haven't expired.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $codes = Code::where('is_active', true)
                ->where(function($query) {
                    $query->whereNull('valid_to')
                          ->orWhere('valid_to', '>=', now()->toDateString());
                })
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Codes retrieved successfully',
                'data' => CodeResource::collection($codes)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve codes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a specific code by code string.
     * This is a public endpoint - no authentication required.
     *
     * @param string $code
     * @return JsonResponse
     */
    public function show(string $code): JsonResponse
    {
        try {
            $codeModel = Code::where('code', strtoupper($code))
                ->where('is_active', true)
                ->where(function($query) {
                    $query->whereNull('valid_to')
                          ->orWhere('valid_to', '>=', now()->toDateString());
                })
                ->first();

            if (!$codeModel) {
                return response()->json([
                    'success' => false,
                    'message' => 'Code not found or expired',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Code retrieved successfully',
                'data' => new CodeResource($codeModel)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve code',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
