@extends('layouts.app')

@section('content')
<h2>Home</h2>
<p>Welcome, {{ auth()->user()->name ?? 'Guest' }}.</p>
@if(session('impersonated'))
  <div style="padding:8px;background:#fff3cd;border:1px solid #ffeeba;border-radius:6px;margin-bottom:10px;">
    You are impersonating user <strong>{{ auth()->user()->name }}</strong>.
    <form method="POST" action="{{ route('admin.stop.impersonate') }}" style="display:inline">
      @csrf
      <button type="submit">Stop impersonation</button>
    </form>
  </div>
@endif
@endsection
