<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Http\Requests\StoreAdvertisementRequest;
use App\Http\Requests\UpdateAdvertisementRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    public function index(Request $request)
    {
        $query = Advertisement::query();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where('title', 'like', "%{$q}%")
                ->orWhere('description', 'like', "%{$q}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('position')) {
            $query->where('position', $request->position);
        }

        $advertisements = $query->orderBy('sort_order')->latest()->paginate(15);

        return view('pages.advertisements.index', compact('advertisements'));
    }

    public function create()
    {
        return view('pages.advertisements.create');
    }

    public function store(StoreAdvertisementRequest $request)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('advertisements', 'public');
        }

        Advertisement::create($data);

        return redirect()->route('advertisements.index')->with('success', 'Advertisement created successfully.');
    }

    public function show(Advertisement $advertisement)
    {
        return view('pages.advertisements.show', compact('advertisement'));
    }

    public function edit(Advertisement $advertisement)
    {
        return view('pages.advertisements.edit', compact('advertisement'));
    }

    public function update(UpdateAdvertisementRequest $request, Advertisement $advertisement)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($advertisement->image_url) {
                Storage::disk('public')->delete($advertisement->image_url);
            }
            $data['image_url'] = $request->file('image')->store('advertisements', 'public');
        }

        $advertisement->update($data);

        return redirect()->route('advertisements.index')->with('success', 'Advertisement updated successfully.');
    }

    public function destroy(Advertisement $advertisement)
    {
        // Delete image if exists
        if ($advertisement->image_url) {
            Storage::disk('public')->delete($advertisement->image_url);
        }

        $advertisement->delete();

        return redirect()->route('advertisements.index')->with('success', 'Advertisement deleted successfully.');
    }
}

