@extends('layouts.app')

@section('content')

<h2 style="margin-bottom:16px; font-size:1.25rem; font-weight:600;">All Notifications</h2>

<form method="GET" action="" class="filter-form">
  <div class="filter-row">

    <div>
      <label>Type</label>
      <select name="type">
        <option value="">All</option>
        <option value="system" {{ request('type')=='system' ? 'selected' : '' }}>System</option>
        <option value="marketing" {{ request('type')=='marketing' ? 'selected' : '' }}>Marketing</option>
        <option value="invoices" {{ request('type')=='invoices' ? 'selected' : '' }}>Invoices</option>
      </select>
    </div>

    <div>
      <label>Destination User</label>
      <select name="destination_user_id">
        <option value="">All</option>
        @foreach($users as $u)
          <option value="{{ $u->id }}" {{ request('destination_user_id') == $u->id ? 'selected' : '' }}>
            {{ $u->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label>Search Text</label>
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Search...">
    </div>

    <div class="filter-btn">
      <button type="submit" class="btn btn-primary btn-sm">Filter</button>
    </div>
    @if(request('type') || request('destination_user_id') || request('search'))
      <a href="{{ route('notifications.index') }}" class="btn-secondary">Reset</a>
    @endif


  </div>
</form>

<table class="notif-table">
  <thead>
    <tr>
      <th>Type</th>
      <th>Text</th>
      <th>Destination</th>
      <th>Expires</th>
      <th>Created</th>
    </tr>
  </thead>

  <tbody>
    @forelse($notifications as $n)
      <tr>
        <td class="notif-type-{{ $n->type }}">{{ ucfirst($n->type) }}</td>
        <td><a href="{{ route('notifications.show', $n) }}">{{ $n->short_text }}</a></td>
        <td>{{ $n->destinationUser ? $n->destinationUser->name : 'All' }}</td>
        <td>{{ $n->expires_at ? $n->expires_at->format('Y-m-d H:i') : '—' }}</td>
        <td>{{ $n->created_at->format('Y-m-d H:i') }}</td>
      </tr>
    @empty
      <tr>
        <td colspan="5" style="text-align:center; padding:12px;">No records found</td>
      </tr>
    @endforelse
  </tbody>
</table>

<div style="margin-top:16px;">
  {{ $notifications->links('pagination::bootstrap-5') }}
</div>

@endsection
