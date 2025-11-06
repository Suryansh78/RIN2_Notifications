<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Impersonate
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->has('impersonate_user_id')) {
            $id = $request->session()->get('impersonate_user_id');
            $impersonated = User::find($id);
            if ($impersonated) {
                // set the currently authenticated user as impersonated for the request
                // Keep original admin guard if you need it later - for PoC we just override Auth
                Auth::setUser($impersonated);
            } else {
                $request->session()->forget('impersonate_user_id');
            }
        }

        return $next($request);
    }
}
