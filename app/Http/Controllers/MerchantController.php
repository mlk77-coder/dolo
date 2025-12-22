<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Http\Requests\StoreMerchantRequest;
use App\Http\Requests\UpdateMerchantRequest;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    public function index(Request $request)
    {
        $query = Merchant::query();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($builder) use ($q) {
                $builder->where('business_name', 'like', "%{$q}%")
                    ->orWhere('owner_name', 'like', "%{$q}%")
                    ->orWhere('city', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $merchants = $query->latest()->paginate(15);

        return view('pages.merchants.index', compact('merchants'));
    }

    public function create()
    {
        return view('pages.merchants.create');
    }

    public function store(StoreMerchantRequest $request)
    {
        $data = $request->validated();
        if (isset($data['documents'])) {
            // Handle textarea input: if it's an array with a single string, split by newlines
            if (is_array($data['documents']) && count($data['documents']) === 1 && is_string($data['documents'][0])) {
                $data['documents'] = array_values(array_filter(
                    array_map('trim', explode("\n", $data['documents'][0]))
                ));
            } else {
                $data['documents'] = array_values(array_filter($data['documents']));
            }
            // Set to null if empty array
            if (empty($data['documents'])) {
                $data['documents'] = null;
            }
        }
        Merchant::create($data);

        return redirect()->route('merchants.index')->with('success', 'Merchant created successfully.');
    }

    public function show(Merchant $merchant)
    {
        return view('pages.merchants.show', compact('merchant'));
    }

    public function edit(Merchant $merchant)
    {
        return view('pages.merchants.edit', compact('merchant'));
    }

    public function update(UpdateMerchantRequest $request, Merchant $merchant)
    {
        $data = $request->validated();
        if (isset($data['documents'])) {
            // Handle textarea input: if it's an array with a single string, split by newlines
            if (is_array($data['documents']) && count($data['documents']) === 1 && is_string($data['documents'][0])) {
                $data['documents'] = array_values(array_filter(
                    array_map('trim', explode("\n", $data['documents'][0]))
                ));
            } else {
                $data['documents'] = array_values(array_filter($data['documents']));
            }
            // Set to null if empty array
            if (empty($data['documents'])) {
                $data['documents'] = null;
            }
        }
        $merchant->update($data);

        return redirect()->route('merchants.index')->with('success', 'Merchant updated successfully.');
    }

    public function destroy(Merchant $merchant)
    {
        $merchant->delete();

        return redirect()->route('merchants.index')->with('success', 'Merchant deleted successfully.');
    }

    public function exportCsv(Request $request)
    {
        $query = Merchant::query();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($builder) use ($q) {
                $builder->where('business_name', 'like', "%{$q}%")
                    ->orWhere('owner_name', 'like', "%{$q}%")
                    ->orWhere('city', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $merchants = $query->latest()->get();

        $filename = 'merchants_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($merchants) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, ['ID', 'Business Name', 'Owner Name', 'Email', 'Phone', 'City', 'Status', 'Created At']);
            
            foreach ($merchants as $merchant) {
                fputcsv($file, [
                    $merchant->id,
                    $merchant->business_name ?? '',
                    $merchant->owner_name ?? '',
                    $merchant->email ?? '',
                    $merchant->phone ?? '',
                    $merchant->city ?? '',
                    $merchant->status ?? '',
                    $merchant->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

