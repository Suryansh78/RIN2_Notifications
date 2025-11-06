<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index1()
    {
        echo 1;die;
        // eager load unread count (we'll use simple loop for PoC)
        $users = User::orderBy('name')->paginate(20);

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
