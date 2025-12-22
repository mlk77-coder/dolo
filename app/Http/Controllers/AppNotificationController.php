<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Http\Requests\StoreAppNotificationRequest;
use App\Http\Requests\UpdateAppNotificationRequest;
use Illuminate\Http\Request;

class AppNotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = AppNotification::with('user');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where('title', 'like', "%{$q}%")
                ->orWhere('message', 'like', "%{$q}%")
                ->orWhereHas('user', function ($builder) use ($q) {
                    $builder->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $notifications = $query->latest()->paginate(15);

        return view('pages.notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('pages.notifications.create');
    }

    public function store(StoreAppNotificationRequest $request)
    {
        AppNotification::create($request->validated());

        return redirect()->route('notifications.index')->with('success', 'Notification created successfully.');
    }

    public function show(AppNotification $notification)
    {
        $notification->load('user');
        return view('pages.notifications.show', compact('notification'));
    }

    public function edit(AppNotification $notification)
    {
        return view('pages.notifications.edit', compact('notification'));
    }

    public function update(UpdateAppNotificationRequest $request, AppNotification $notification)
    {
        $notification->update($request->validated());

        return redirect()->route('notifications.index')->with('success', 'Notification updated successfully.');
    }

    public function destroy(AppNotification $notification)
    {
        $notification->delete();

        return redirect()->route('notifications.index')->with('success', 'Notification deleted successfully.');
    }
}

