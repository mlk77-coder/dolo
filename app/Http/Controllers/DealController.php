<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Category;
use App\Models\Merchant;
use App\Http\Requests\StoreDealRequest;
use App\Http\Requests\UpdateDealRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DealController extends Controller
{
    public function index(Request $request)
    {
        $query = Deal::with(['category', 'merchant']);

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($builder) use ($q) {
                $builder->where('title_en', 'like', "%{$q}%")
                    ->orWhere('title_ar', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%")
                    ->orWhere('city', 'like', "%{$q}%")
                    ->orWhereHas('merchant', function($merchantQuery) use ($q) {
                        $merchantQuery->where('business_name', 'like', "%{$q}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('merchant_id')) {
            $query->where('merchant_id', $request->merchant_id);
        }

        $deals = $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc')->paginate(15);
        $categories = Category::all();
        $merchants = Merchant::all();

        return view('pages.deals.index', compact('deals', 'categories', 'merchants'));
    }

    public function create()
    {
        $categories = Category::all();
        $merchants = Merchant::all();
        return view('pages.deals.create', compact('categories', 'merchants'));
    }

    public function store(StoreDealRequest $request)
    {
        $data = $request->validated();

        // Handle video upload
        if ($request->hasFile('video')) {
            $data['video_url'] = $request->file('video')->store('deal-videos', 'public');
        }

        // Set default values for boolean fields
        $data['show_buyer_counter'] = $request->has('show_buyer_counter') ? true : false;
        $data['show_savings_percentage'] = $request->has('show_savings_percentage') ? true : false;
        $data['buyer_counter'] = $data['buyer_counter'] ?? 0;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $deal = Deal::create($data);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('deal-images', 'public');
                $deal->images()->create([
                    'image_url' => $imagePath,
                    'is_primary' => $index === 0, // First image is primary by default
                ]);
            }
        }

        return redirect()->route('deals.index')->with('success', 'Deal created successfully.');
    }

    public function show(Deal $deal)
    {
        $deal->load(['category', 'merchant', 'images']);
        return view('pages.deals.show', compact('deal'));
    }

    public function edit(Deal $deal)
    {
        $deal->load('images');
        $categories = Category::all();
        $merchants = Merchant::all();
        return view('pages.deals.edit', compact('deal', 'categories', 'merchants'));
    }

    public function update(UpdateDealRequest $request, Deal $deal)
    {
        $data = $request->validated();

        // Handle video upload
        if ($request->hasFile('video')) {
            // Delete old video file if exists (only if it's a stored file, not a URL)
            if ($deal->video_url && !str_starts_with($deal->video_url, 'http') && Storage::disk('public')->exists($deal->video_url)) {
                Storage::disk('public')->delete($deal->video_url);
            }
            $data['video_url'] = $request->file('video')->store('deal-videos', 'public');
        } else {
            // Handle video URL - if provided, use it; if empty string, clear it
            if (array_key_exists('video_url', $data)) {
                if (empty($data['video_url'])) {
                    // If video_url is empty, clear it and delete old file if exists
                    if ($deal->video_url && !str_starts_with($deal->video_url, 'http') && Storage::disk('public')->exists($deal->video_url)) {
                        Storage::disk('public')->delete($deal->video_url);
                    }
                    $data['video_url'] = null;
                } elseif ($data['video_url'] !== $deal->video_url) {
                    // If video_url changed from file to URL, delete old file
                    if ($deal->video_url && !str_starts_with($deal->video_url, 'http') && Storage::disk('public')->exists($deal->video_url)) {
                        Storage::disk('public')->delete($deal->video_url);
                    }
                }
            }
        }

        // Set default values for boolean fields
        $data['show_buyer_counter'] = $request->has('show_buyer_counter') ? true : false;
        $data['show_savings_percentage'] = $request->has('show_savings_percentage') ? true : false;
        $data['featured'] = $request->has('featured') ? true : false;

        // Ensure sort_order is included if provided
        if ($request->filled('sort_order')) {
            $data['sort_order'] = $request->sort_order;
        }

        $deal->update($data);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('deal-images', 'public');
                $deal->images()->create([
                    'image_url' => $imagePath,
                    'is_primary' => false,
                ]);
            }
        }

        return redirect()->route('deals.index')->with('success', 'Deal updated successfully.');
    }

    public function destroy(Deal $deal)
    {
        // Delete video if exists
        if ($deal->video_url && Storage::disk('public')->exists($deal->video_url)) {
            Storage::disk('public')->delete($deal->video_url);
        }

        $deal->delete();

        return redirect()->route('deals.index')->with('success', 'Deal deleted successfully.');
    }

    public function updateSortOrder(Request $request)
    {
        $request->validate([
            'deals' => ['required', 'array'],
            'deals.*.id' => ['required', 'exists:deals,id'],
            'deals.*.sort_order' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($request->deals as $dealData) {
            Deal::where('id', $dealData['id'])->update(['sort_order' => $dealData['sort_order']]);
        }

        return response()->json(['success' => true, 'message' => 'Sort order updated successfully.']);
    }

    public function exportCsv(Request $request)
    {
        $query = Deal::with(['category', 'merchant']);

        // Apply same filters as index
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($builder) use ($q) {
                $builder->where('title_en', 'like', "%{$q}%")
                    ->orWhere('title_ar', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%")
                    ->orWhere('city', 'like', "%{$q}%")
                    ->orWhereHas('merchant', function($merchantQuery) use ($q) {
                        $merchantQuery->where('business_name', 'like', "%{$q}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('merchant_id')) {
            $query->where('merchant_id', $request->merchant_id);
        }

        $deals = $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc')->get();

        $filename = 'deals_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($deals) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            
            fputcsv($file, ['ID', 'Title (EN)', 'Title (AR)', 'SKU', 'Merchant', 'Category', 'City', 'Area', 'Location Name', 'Latitude', 'Longitude', 'Original Price', 'Discounted Price', 'Discount %', 'Buyer Counter', 'Status', 'Featured', 'Start Date', 'End Date', 'Created At']);
            
            foreach ($deals as $deal) {
                fputcsv($file, [
                    $deal->id,
                    $deal->title_en,
                    $deal->title_ar,
                    $deal->sku ?? '',
                    $deal->merchant->business_name ?? '',
                    $deal->category->name ?? '',
                    $deal->city ?? '',
                    $deal->area ?? '',
                    $deal->location_name ?? '',
                    $deal->latitude ?? '',
                    $deal->longitude ?? '',
                    $deal->original_price,
                    $deal->discounted_price,
                    $deal->discount_percentage ?? '',
                    $deal->buyer_counter ?? 0,
                    $deal->status,
                    $deal->featured ? 'Yes' : 'No',
                    $deal->start_date ? $deal->start_date->format('Y-m-d H:i:s') : '',
                    $deal->end_date ? $deal->end_date->format('Y-m-d H:i:s') : '',
                    $deal->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

