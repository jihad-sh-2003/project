<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\GenericNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    
    public function index(Request $request)
    {
        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->paginate(20);

        return response()->json([
            'message' => 'Notifications retrieved successfully',
            'data'    => $notifications,
        ]);
    }

    public function unreadCount(Request $request)
    {
        return response()->json([
            'unread' => $request->user()->unreadNotifications()->count(),
        ]);
    }

    public function markAsRead(Request $request, string $id)
    {
        $notification = $request->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        return response()->json(['message' => 'Notification marked as read']);
    }

    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications()->update(['read_at' => now()]);
        return response()->json(['message' => 'All notifications marked as read']);
    }

    public function destroy(Request $request, string $id)
    {
        $deleted = $request->user()
            ->notifications()
            ->where('id', $id)
            ->delete();

        return $deleted
            ? response()->json(['message' => 'Notification deleted'])
            : response()->json(['message' => 'Notification not found'], 404);
    }



    //Admin
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_ids'   => 'required|array|min:1',
            'user_ids.*' => 'integer|exists:users,id',
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'action_url' => 'nullable|url',
        ]);

        $users = User::whereIn('id', $data['user_ids'])->get();
        foreach ($users as $user) {
            $user->notify(new GenericNotification(
                $data['title'],
                $data['content'],
                $data['action_url'] ?? null
            ));
        }

        return response()->json(['message' => 'Notifications queued'], 201);
    }

}
