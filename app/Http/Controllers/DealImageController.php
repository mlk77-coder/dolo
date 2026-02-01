<?php

namespace App\Http\Controllers;

use App\Models\DealImage;
use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DealImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'deal_id' => ['required', 'exists:deals,id'],
            'image' => ['required', 'image', 'max:2048'],
            'is_primary' => ['boolean'],
        ]);

        $imagePath = $request->file('image')->store('deal-images', 'public');

        // If this is set as primary, unset other primary images
        if ($request->boolean('is_primary')) {
            DealImage::where('deal_id', $request->deal_id)
                ->update(['is_primary' => false]);
        }

        DealImage::create([
            'deal_id' => $request->deal_id,
            'image_url' => $imagePath,
            'is_primary' => $request->boolean('is_primary', false),
        ]);

        return redirect()->back()->with('success', 'Image uploaded successfully.');
    }

    public function destroy(DealImage $dealImage)
    {
        // Delete the image file
        if ($dealImage->image_url) {
            Storage::disk('public')->delete($dealImage->image_url);
        }

        $dealImage->delete();

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }

    public function setPrimary(DealImage $dealImage)
    {
        // Set all images for this deal to non-primary
        DealImage::where('deal_id', $dealImage->deal_id)
            ->update(['is_primary' => false]);

        // Set this image as primary
        $dealImage->update(['is_primary' => true]);

        return redirect()->back()->with('success', 'Primary image updated successfully.');
    }
}

