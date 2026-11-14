@extends('frontend.layouts.main')
@section('title', 'Notifications | DoctorsInnElite')
@section('meta_description', 'Stay updated with your latest notifications on DoctorsInnElite — course updates, new resources, announcements and more.')
@section('meta_keywords', 'DoctorsInnElite notifications, course updates, student alerts')
@section('content')

    <div class="breadcumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title">Notifications</h1>
                        <ul class="breadcumb-menu">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>Notifications</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $typeMeta = [
            'announcement' => ['icon' => 'fa-regular fa-bullhorn', 'wrap' => 'icon-announcement'],
            'course' => ['icon' => 'fa-regular fa-book', 'wrap' => 'icon-course'],
            'system' => ['icon' => 'fa-regular fa-triangle-exclamation', 'wrap' => 'icon-alert'],
            'result' => ['icon' => 'fa-regular fa-circle-check', 'wrap' => 'icon-success'],
        ];
        $filters = [
            'all' => ['label' => 'All Notifications', 'icon' => 'fal fa-list-ul'],
            'unread' => ['label' => 'Unread', 'icon' => 'fal fa-envelope'],
            'announcement' => ['label' => 'Announcements', 'icon' => 'fal fa-bullhorn'],
            'system' => ['label' => 'System Alerts', 'icon' => 'fal fa-exclamation-triangle'],
            'course' => ['label' => 'Course Updates', 'icon' => 'fal fa-book'],
            'result' => ['label' => 'Test Results', 'icon' => 'fal fa-clipboard-check'],
        ];
    @endphp

    <!-- Notifications Area -->
    <section class="space-top space-bottom overflow-hidden bg-color" id="notification-section">
        <div class="container">
            <div class="row gy-40">
                <!-- Left Navigation Column -->
                <div class="col-lg-4">
                    <div class="notification-sidebar-menu">
                        @foreach ($filters as $key => $meta)
                            <a href="{{ route('notifications', $key === 'all' ? [] : ['filter' => $key]) }}"
                                class="notification-nav-link {{ $activeFilter === $key ? 'active' : '' }}">
                                <span><i class="{{ $meta['icon'] }}"></i>{{ $meta['label'] }}</span>
                                <span class="notification-count">{{ $counts[$key] ?? 0 }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Right Content Column -->
                <div class="col-lg-8">
                    <div class="notification-card">
                        <div class="notification-header">
                            <h3>{{ $filters[$activeFilter]['label'] ?? 'All Notifications' }}</h3>
                            @if (($counts['unread'] ?? 0) > 0)
                                <form action="{{ route('notifications.readAll') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="mark-read-btn">Mark all as read</button>
                                </form>
                            @endif
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success py-2 px-3 mt-3 mb-0" style="font-size: 13px; border-radius: 8px;">
                                <i class="fal fa-circle-check me-1"></i>{{ session('success') }}
                            </div>
                        @endif

                        <div class="notification-list">
                            @forelse ($notifications as $notification)
                                @php
                                    $meta = $typeMeta[$notification->type] ?? $typeMeta['system'];
                                    $isUnread = ! $notification->read_at;
                                @endphp
                                <div class="notification-item {{ $isUnread ? 'unread' : '' }} {{ str_replace('_', '-', $notification->type) }}-item" data-id="{{ $notification->id }}">
                                    <div class="notification-icon-wrap {{ $meta['wrap'] }}">
                                        <i class="{{ $meta['icon'] }}"></i>
                                    </div>
                                    <div class="notification-body">
                                        <h4 class="notification-title">
                                            @if ($notification->url)
                                                <form action="{{ route('notifications.read', $notification) }}" method="POST" class="d-inline m-0">
                                                    @csrf
                                                    <button type="submit"
                                                        style="background: none; border: 0; padding: 0; color: inherit; font: inherit; text-align: left; cursor: pointer;">
                                                        {{ $notification->title }}
                                                    </button>
                                                </form>
                                            @else
                                                <span>{{ $notification->title }}</span>
                                            @endif
                                            @if ($isUnread)
                                                <span class="unread-indicator"></span>
                                            @endif
                                        </h4>
                                        @if ($notification->message)
                                            <p class="notification-text">{{ $notification->message }}</p>
                                        @endif
                                        <p class="notification-time">
                                            <i class="fal fa-clock"></i>{{ $notification->created_at?->diffForHumans() }}
                                        </p>
                                    </div>
                                    <form action="{{ route('notifications.destroy', $notification) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dismiss-notification-btn" title="Dismiss">
                                            <i class="fal fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <div class="empty-notifications-state" style="display: block;">
                                    <i class="fal fa-bell-slash"></i>
                                    <h4>No notifications found</h4>
                                    <p>You have cleared all alerts in this folder.</p>
                                </div>
                            @endforelse
                        </div>

                        @if (method_exists($notifications, 'hasPages') && $notifications->hasPages())
                            <div class="d-flex align-items-center justify-content-between mt-3 pt-3 border-top" style="font-size: 13px;">
                                @if ($notifications->onFirstPage())
                                    <span class="text-muted">Newer</span>
                                @else
                                    <a href="{{ $notifications->previousPageUrl() }}" class="text-theme fw-semibold">Newer</a>
                                @endif
                                <span class="text-muted">Page {{ $notifications->currentPage() }} of {{ $notifications->lastPage() }}</span>
                                @if ($notifications->hasMorePages())
                                    <a href="{{ $notifications->nextPageUrl() }}" class="text-theme fw-semibold">Older</a>
                                @else
                                    <span class="text-muted">Older</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
