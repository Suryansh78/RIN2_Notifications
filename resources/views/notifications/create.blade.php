@extends('layouts.app')

@section('content')

<h2 style="margin-bottom:16px; font-size:1.25rem; font-weight:600;">Post New Notification</h2>

<div class="form-card">

  <form method="POST" action="{{ route('notifications.store') }}">
    @csrf

    <div class="form-group">
      <label>Type</label>
      <select name="type" required>
        <option value="system">System</option>
        <option value="marketing">Marketing</option>
        <option value="invoices">Invoices</option>
      </select>
    </div>

    <div class="form-group">
      <label>Short text</label>
      <input name="short_text" maxlength="255" required>
    </div>

    <div class="form-group">
      <label>Body (optional)</label>
      <textarea name="body"></textarea>
    </div>

    <div class="form-group">
      <label>Expires at (optional)</label>
      <input type="datetime-local" name="expires_at">
    </div>

    <div class="form-group">
      <label>Destination</label>
      <select name="destination_user_id">
        <option value="">All users</option>
        @foreach($users as $u)
          <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn-primary">Post Notification</button>
  </form>

</div>

@endsection
