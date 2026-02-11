<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Mail\MarketingEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailMarketingController extends Controller
{
    public function index()
    {
        // Get email statistics
        $stats = [
            'total_customers' => Customer::whereNotNull('email')->count(),
            'verified_emails' => Customer::whereNotNull('email_verified_at')->count(),
        ];

        return view('pages.email-marketing.index', compact('stats'));
    }

    public function create()
    {
        // Get all customers with emails
        $customers = Customer::whereNotNull('email')
            ->select('id', 'name', 'email', 'created_at')
            ->orderBy('name')
            ->get();

        return view('pages.email-marketing.create', compact('customers'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'recipients' => 'required|string|in:all,selected',
            'selected_customers' => 'required_if:recipients,selected|array',
            'selected_customers.*' => 'exists:customers,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Get recipients
        if ($request->recipients === 'all') {
            $customers = Customer::whereNotNull('email')->get();
        } else {
            $customers = Customer::whereIn('id', $request->selected_customers)
                ->whereNotNull('email')
                ->get();
        }

        if ($customers->isEmpty()) {
            return back()->with('error', 'No customers with valid emails found.');
        }

        $successCount = 0;
        $failCount = 0;

        foreach ($customers as $customer) {
            try {
                Mail::to($customer->email)->send(
                    new MarketingEmail(
                        $request->subject,
                        $request->message,
                        $customer->name
                    )
                );
                $successCount++;
            } catch (\Exception $e) {
                Log::error('Failed to send email to ' . $customer->email . ': ' . $e->getMessage());
                $failCount++;
            }
        }

        $message = "Email sent successfully to {$successCount} customer(s).";
        if ($failCount > 0) {
            $message .= " Failed to send to {$failCount} customer(s).";
        }

        return redirect()->route('email-marketing.index')->with('success', $message);
    }

    public function preview(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        return view('pages.email-marketing.preview', [
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
    }
}
