@extends('layouts.app')

@section('content')
<h2 style="margin-bottom:16px; font-size:1.25rem; font-weight:600;">Users</h2>
<form method="GET" class="filter-form">
  <div class="filter-row">
    <input type="text" name="search" placeholder="Search name, email, phone"
           value="{{ request('search') }}">

    <select name="notifications">
      <option value="">Notification Status</option>
      <option value="1" {{ request('notifications')==='1' ? 'selected' : '' }}>Enabled</option>
      <option value="0" {{ request('notifications')==='0' ? 'selected' : '' }}>Disabled</option>
    </select>

    <button type="submit" class="btn-primary">Filter</button>

    @if(request()->anyFilled(['search','notifications']))
      <a href="{{ route('admin.users.index') }}" class="btn-secondary">Reset</a>
    @endif
  </div>
</form>
<table class="users-table">
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Unread</th>
      <th>Actions</th>
    </tr>
  </thead>

  <tbody>
    @forelse($users as $u)
      <tr>
        <td>{{ $u->name }}</td>
        <td>{{ $u->email }}</td>
        <td>{{ $u->phone ?: '—' }}</td>

        <td>
          @if($u->unreadNotificationsCount() > 0)
            <span class="badge-unread">{{ $u->unreadNotificationsCount() }}</span>
          @else
            <span style="color:#888;">0</span>
          @endif
        </td>

        <td>
          <form method="POST" action="{{ route('admin.impersonate', $u) }}">
            @csrf
            <button type="submit" class="btn-small">Impersonate</button>
          </form>
        </td>
      </tr>
      @empty
        <tr>
          <td colspan="5" class="no-data">No records found</td>
      </tr>
    @endforelse
  </tbody>
</table>

<div style="margin-top:16px;">
  {{ $users->links('pagination::bootstrap-5') }}
</div>

@endsection
