<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbandonedCartController extends Controller
{
    public function index(Request $request)
    {
        // Get customers who have sessions with cart data but no completed orders
        // This is a simplified version - in a real app, you'd track cart sessions
        
        // Find customers who registered but never completed an order
        // Exclude admin users
        $query = Customer::where('is_admin', false)
            ->whereDoesntHave('orders', function($q) {
                $q->where('status', 'completed');
            })->withCount('orders');

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $customers = $query->latest()->paginate(15);

        return view('pages.orders.abandoned-carts', compact('customers'));
    }
}

