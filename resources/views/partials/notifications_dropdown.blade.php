@php
    $user = auth()->user();
    $unreadCount = $user ? $user->unreadNotificationsCount() : 0;
    $notifications = \App\Models\Notification::notExpired()
        ->where(function($q) use ($user) {
            $q->whereNull('destination_user_id')->orWhere('destination_user_id', $user->id ?? 0);
        })->orderBy('created_at','desc')->take(5)->get();
@endphp

<div class="notification-dropdown">
  @if(auth()->check() && auth()->user()->notification_switch)
    <a href="#" class="notif-trigger" onclick="event.preventDefault(); document.getElementById('notif-drop').classList.toggle('show')">
      🔔
      @if($unreadCount)
        <span class="notif-badge">{{ $unreadCount }}</span>
      @endif
    </a>
    @else
    <span class="notif-disabled" title="Notifications disabled">🔕</span>
  @endif

  <div id="notif-drop" class="notif-menu">
    <div class="notif-header">Notifications</div>

    @forelse($notifications as $n)
        @php
          $pivot = $user ? $user->notificationsRelation()->where('notification_id', $n->id)->first()?->pivot : null;
          $isRead = $pivot && $pivot->read_at;
        @endphp

        <div class="notif-item {{ $isRead ? 'read' : '' }}">
          <div class="notif-content">
              <strong>{{ $n->short_text }}</strong>
              <div class="notif-meta">{{ $n->type }} • {{ $n->created_at->diffForHumans() }}</div>
          </div>

          @if(!$isRead)
            <form class="inline" method="GET" action="{{ route('notifications.show', $n) }}">
              <button class="btn btn-sm btn-primary">Open</button>
            </form>
          @else
            <span class="notif-read">Read</span>
          @endif
        </div>
    @empty
        <div class="notif-empty">No notifications</div>
    @endforelse

    <div class="notif-footer">
      <a href="{{ route('notifications.index') }}">View all</a>
    </div>
  </div>
</div>

