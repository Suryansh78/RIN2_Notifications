<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Propaganistas\LaravelPhone\PhoneNumber; // optional, only if using package
use App\Models\User;

class SettingsController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();
        return view('settings.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'notification_switch' => 'required|boolean',
            'email' => ['required','email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|phone:IN,mobile',
         ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered, please use another one.',
            'phone.phone' => 'Please enter a valid mobile number including country code. Example: +91 9876543210',
        ]);
        $user->update($data);

        return back()->with('success','Settings updated.');
    }
}
