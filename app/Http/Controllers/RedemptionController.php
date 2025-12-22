<?php

namespace App\Http\Controllers;

use App\Models\Redemption;
use App\Models\Order;
use App\Http\Requests\StoreRedemptionRequest;
use App\Http\Requests\UpdateRedemptionRequest;
use Illuminate\Http\Request;

class RedemptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Redemption::with(['order', 'user', 'merchant']);

        if ($request->filled('search')) {
            $q = $request->search;
            $query->whereHas('order', function ($builder) use ($q) {
                $builder->where('order_number', 'like', "%{$q}%");
            })->orWhereHas('user', function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $redemptions = $query->latest()->paginate(15);

        return view('pages.redemptions.index', compact('redemptions'));
    }

    public function create()
    {
        $orders = Order::where('status', 'completed')->with('user', 'deal')->get();
        $customers = \App\Models\Customer::where('is_admin', false)->get();
        return view('pages.redemptions.create', compact('orders', 'customers'));
    }

    public function store(StoreRedemptionRequest $request)
    {
        Redemption::create($request->validated());

        return redirect()->route('redemptions.index')->with('success', 'Redemption created successfully.');
    }

    public function show(Redemption $redemption)
    {
        $redemption->load('order.deal', 'user', 'merchant');
        return view('pages.redemptions.show', compact('redemption'));
    }

    public function edit(Redemption $redemption)
    {
        $orders = Order::where('status', 'completed')->with('user', 'deal')->get();
        $customers = \App\Models\Customer::where('is_admin', false)->get();
        return view('pages.redemptions.edit', compact('redemption', 'orders', 'customers'));
    }

    public function update(UpdateRedemptionRequest $request, Redemption $redemption)
    {
        $redemption->update($request->validated());

        return redirect()->route('redemptions.index')->with('success', 'Redemption updated successfully.');
    }

    public function destroy(Redemption $redemption)
    {
        $redemption->delete();

        return redirect()->route('redemptions.index')->with('success', 'Redemption deleted successfully.');
    }
}

