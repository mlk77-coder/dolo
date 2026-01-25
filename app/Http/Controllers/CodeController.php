<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Customer;
use App\Http\Requests\StoreCodeRequest;
use App\Http\Requests\UpdateCodeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CodeController extends Controller
{
    public function index(Request $request)
    {
        $query = Code::query();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function($builder) use ($q) {
                $builder->where('subject', 'like', "%{$q}%")
                    ->orWhere('code', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $codes = $query->latest()->paginate(15);

        return view('pages.codes.index', compact('codes'));
    }

    public function create()
    {
        return view('pages.codes.create');
    }

    public function store(StoreCodeRequest $request)
    {
        $data = $request->validated();

        // Handle checkbox for is_active
        $data['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('codes', 'public');
        }

        Code::create($data);

        return redirect()->route('codes.index')->with('success', 'Code created successfully.');
    }

    public function show(Code $code)
    {
        return view('pages.codes.show', compact('code'));
    }

    public function edit(Code $code)
    {
        return view('pages.codes.edit', compact('code'));
    }

    public function update(UpdateCodeRequest $request, Code $code)
    {
        $data = $request->validated();

        // Handle checkbox for is_active
        $data['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($code->image && Storage::disk('public')->exists($code->image)) {
                Storage::disk('public')->delete($code->image);
            }
            $data['image'] = $request->file('image')->store('codes', 'public');
        }

        $code->update($data);

        return redirect()->route('codes.index')->with('success', 'Code updated successfully.');
    }

    public function destroy(Code $code)
    {
        // Delete image if exists
        if ($code->image && Storage::disk('public')->exists($code->image)) {
            Storage::disk('public')->delete($code->image);
        }

        $code->delete();

        return redirect()->route('codes.index')->with('success', 'Code deleted successfully.');
    }
}

