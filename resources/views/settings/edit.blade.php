@extends('layouts.app')

@section('content')

<div class="container mt-4 settings-form">
    <h2 class="mb-4">My Settings</h2>

    <form method="POST" action="{{ route('settings.update') }}" class="card p-4 shadow-sm">
        @csrf

        <div class="form-check form-switch mb-3">
            <input type="hidden" name="notification_switch" value="0">
            <input
                type="checkbox"
                class="form-check-input"
                name="notification_switch"
                value="1"
                id="notificationsSwitch"
                {{ $user?->notification_switch ? 'checked' : '' }}
            >
            <label class="form-check-label" for="notificationsSwitch">Notifications Enabled</label>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email', $user->email ?? '') }}">
            @error('email')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">Phone (with country code)</label>
            <input type="text" name="phone" class="form-control"
                   value="{{ old('phone', $user->phone ?? '') }}">
            @error('phone')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">Save Settings</button>
    </form>
</div>
@endsection
