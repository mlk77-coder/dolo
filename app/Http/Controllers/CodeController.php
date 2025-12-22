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
        $query = Code::with('customer');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function($builder) use ($q) {
                $builder->where('subject', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('code', 'like', "%{$q}%")
                    ->orWhereHas('customer', function ($builder) use ($q) {
                        $builder->where('name', 'like', "%{$q}%")
                            ->orWhere('email', 'like', "%{$q}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $codes = $query->latest()->paginate(15);

        return view('pages.codes.index', compact('codes'));
    }

    public function create()
    {
        $customers = Customer::where('is_admin', false)->get();
        return view('pages.codes.create', compact('customers'));
    }

    public function store(StoreCodeRequest $request)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('codes', 'public');
        }

        Code::create($data);

        return redirect()->route('codes.index')->with('success', 'Code created successfully.');
    }

    public function show(Code $code)
    {
        $code->load('customer');
        return view('pages.codes.show', compact('code'));
    }

    public function edit(Code $code)
    {
        $customers = Customer::where('is_admin', false)->get();
        return view('pages.codes.edit', compact('code', 'customers'));
    }

    public function update(UpdateCodeRequest $request, Code $code)
    {
        $data = $request->validated();

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

