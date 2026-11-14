<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login', ['redirect' => route('notifications')])
                ->with('warning', 'Please sign in to view your notifications.');
        }

        if (! Schema::hasTable('notifications')) {
            return view('frontend.pages.notifications', [
                'notifications' => collect(),
                'counts' => ['all' => 0, 'unread' => 0, 'announcement' => 0, 'system' => 0, 'course' => 0, 'result' => 0],
                'activeFilter' => 'all',
            ]);
        }

        $query = Notification::where('user_id', $user->id)->orderByDesc('created_at');
        $filter = (string) $request->query('filter', 'all');

        if ($filter === 'unread') {
            $query->whereNull('read_at');
        } elseif (in_array($filter, Notification::TYPES, true)) {
            $query->where('type', $filter);
        } else {
            $filter = 'all';
        }

        $notifications = $query->paginate(15)->withQueryString();

        $activeFilter = $filter;

        $base = Notification::where('user_id', $user->id);
        $counts = ['all' => (clone $base)->count(), 'unread' => (clone $base)->whereNull('read_at')->count()];
        foreach (Notification::TYPES as $type) {
            $counts[$type] = (clone $base)->where('type', $type)->count();
        }

        return view('frontend.pages.notifications', compact('notifications', 'counts', 'activeFilter'));
    }

    public function markRead(Notification $notification)
    {
        $user = Auth::user();
        if (! $user || (int) $notification->user_id !== (int) $user->id) {
            abort(403);
        }

        if (! $notification->read_at) {
            $notification->read_at = now();
            $notification->save();
        }

        if ($notification->url) {
            return redirect()->to($notification->url);
        }

        return redirect()->route('notifications');
    }

    public function markAllRead()
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        Notification::where('user_id', $user->id)->whereNull('read_at')->update(['read_at' => now()]);

        return redirect()->route('notifications')->with('success', 'All notifications marked as read.');
    }

    public function destroy(Notification $notification)
    {
        $user = Auth::user();
        if (! $user || (int) $notification->user_id !== (int) $user->id) {
            abort(403);
        }

        $notification->delete();

        return redirect()->route('notifications')->with('success', 'Notification dismissed.');
    }
}
