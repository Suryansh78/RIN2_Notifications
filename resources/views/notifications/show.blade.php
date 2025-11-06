@extends('layouts.app')

@section('content')
<h2>{{ $notification->short_text }}</h2>
<p class="muted">{{ $notification->type }} • {{ $notification->created_at->toDateTimeString() }}</p>
<div style="margin-top:12px">
  {!! nl2br(e($notification->body)) !!}
</div>
@endsection
