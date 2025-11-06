<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by search (name, email, phone)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%");
            });
        }
        // Filter by notification switch
        if ($request->filled('notifications')) {
            $query->where('notification_switch', $request->notifications);
        }

        $users = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function impersonate(Request $request, User $user)
    {
        // store in session
        $request->session()->put('impersonate_user_id', $user->id);
        return redirect()->route('home')->with('impersonated', true);
    }

    public function stopImpersonate(Request $request)
    {
        $request->session()->forget('impersonate_user_id');
        return redirect()->route('admin.users.index')->with('impersonation_stopped', true);
    }
}
