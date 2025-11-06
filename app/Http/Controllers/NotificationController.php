<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NotificationController extends Controller
{
    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('notifications.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:marketing,invoices,system',
            'short_text' => 'required|string|max:255',
            'body' => 'nullable|string',
            'expires_at' => 'nullable|date',
            'destination_user_id' => 'nullable|exists:users,id'
        ]);

        if (!empty($data['expires_at'])) {
            $data['expires_at'] = Carbon::parse($data['expires_at']);
        }

        Notification::create($data);

        return redirect()->route('notifications.index')->with('success', 'Notification created.');
    }

    public function index(Request $request)
    {
        $query = \App\Models\Notification::query();

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->destination_user_id !== null && $request->destination_user_id !== '') {
            $query->where('destination_user_id', $request->destination_user_id);
        }

        if ($request->search) {
            $query->where('short_text', 'like', '%' . $request->search . '%');
        }

        $notifications = $query->orderBy('created_at', 'desc')->paginate(10);
        $users = \App\Models\User::orderBy('name')->get();

        return view('notifications.index', compact('notifications', 'users'));
    }


    public function show(Request $request, Notification $notification)
    {
        $user = $request->user();

        // mark as read (create/update pivot)
        if ($user) {
            $user->notificationsRelation()->syncWithoutDetaching([
                $notification->id => ['read_at' => now()]
            ]);
        }

        return view('notifications.show', compact('notification'));
    }
}
