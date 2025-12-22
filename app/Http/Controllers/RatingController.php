<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Deal;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Requests\UpdateRatingRequest;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index(Request $request)
    {
        $query = Rating::with(['user', 'deal']);

        if ($request->filled('search')) {
            $q = $request->search;
            $query->whereHas('user', function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            })->orWhereHas('deal', function ($builder) use ($q) {
                $builder->where('title_en', 'like', "%{$q}%")
                    ->orWhere('title_ar', 'like', "%{$q}%");
            });
        }

        if ($request->filled('approved')) {
            $query->where('approved', $request->approved === '1');
        }

        if ($request->filled('stars')) {
            $query->where('stars', $request->stars);
        }

        $ratings = $query->latest()->paginate(15);

        return view('pages.ratings.index', compact('ratings'));
    }

    public function create()
    {
        $deals = Deal::where('status', 'active')->get();
        return view('pages.ratings.create', compact('deals'));
    }

    public function store(StoreRatingRequest $request)
    {
        Rating::create($request->validated());

        return redirect()->route('ratings.index')->with('success', 'Rating created successfully.');
    }

    public function show(Rating $rating)
    {
        $rating->load('user', 'deal');
        return view('pages.ratings.show', compact('rating'));
    }

    public function edit(Rating $rating)
    {
        $deals = Deal::where('status', 'active')->get();
        return view('pages.ratings.edit', compact('rating', 'deals'));
    }

    public function update(UpdateRatingRequest $request, Rating $rating)
    {
        $rating->update($request->validated());

        return redirect()->route('ratings.index')->with('success', 'Rating updated successfully.');
    }

    public function destroy(Rating $rating)
    {
        $rating->delete();

        return redirect()->route('ratings.index')->with('success', 'Rating deleted successfully.');
    }
}

