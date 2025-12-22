<?php

namespace App\Http\Controllers;

use App\Models\MobileCarouselImage;
use App\Http\Requests\StoreMobileCarouselImageRequest;
use App\Http\Requests\UpdateMobileCarouselImageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MobileCarouselImageController extends Controller
{
    public function index(Request $request)
    {
        $query = MobileCarouselImage::query();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where('title', 'like', "%{$q}%")
                ->orWhere('description', 'like', "%{$q}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $carouselImages = $query->orderBy('sort_order')->latest()->paginate(15);

        return view('pages.mobile-carousel-images.index', compact('carouselImages'));
    }

    public function create()
    {
        return view('pages.mobile-carousel-images.create');
    }

    public function store(StoreMobileCarouselImageRequest $request)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('carousel-images', 'public');
        }

        MobileCarouselImage::create($data);

        return redirect()->route('mobile-carousel-images.index')->with('success', 'Carousel image created successfully.');
    }

    public function show(MobileCarouselImage $mobileCarouselImage)
    {
        return view('pages.mobile-carousel-images.show', compact('mobileCarouselImage'));
    }

    public function edit(MobileCarouselImage $mobileCarouselImage)
    {
        return view('pages.mobile-carousel-images.edit', compact('mobileCarouselImage'));
    }

    public function update(UpdateMobileCarouselImageRequest $request, MobileCarouselImage $mobileCarouselImage)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($mobileCarouselImage->image_url) {
                Storage::disk('public')->delete($mobileCarouselImage->image_url);
            }
            $data['image_url'] = $request->file('image')->store('carousel-images', 'public');
        }

        $mobileCarouselImage->update($data);

        return redirect()->route('mobile-carousel-images.index')->with('success', 'Carousel image updated successfully.');
    }

    public function destroy(MobileCarouselImage $mobileCarouselImage)
    {
        // Delete image if exists
        if ($mobileCarouselImage->image_url) {
            Storage::disk('public')->delete($mobileCarouselImage->image_url);
        }

        $mobileCarouselImage->delete();

        return redirect()->route('mobile-carousel-images.index')->with('success', 'Carousel image deleted successfully.');
    }
}

