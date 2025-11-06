<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Notification - App</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/modern-normalize/modern-normalize.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>
  <div class="container">
    <header>
      <div>
        <h1 style="margin:0;font-size:1.05rem">RIN2 - Notifications</h1>
        <div class="muted">Simple notification system</div>
      </div>

      <div class="topbar">
        <a href="{{ route('admin.users.index') }}">Users</a>
        <a href="{{ route('notifications.index') }}">Notifications</a>
        <a href="{{ route('notifications.create') }}">Post Notification</a>
        <a href="{{ route('settings.edit') }}">My Settings</a>

        @auth
          @include('partials.notifications_dropdown')
        @endauth
      </div>
    </header>

    @if(session('success'))
      <div style="padding:8px;background:#e6ffed;border:1px solid #b6f5c4;border-radius:6px;margin-bottom:10px;">{{ session('success') }}</div>
    @endif

    @yield('content')
  </div>
</body>
</html>
