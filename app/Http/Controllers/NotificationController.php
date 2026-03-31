<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    public function send(string $message, string $type)
    {
        $premiumUsers = User::where('premiun_status', 1)->get();

        foreach ($premiumUsers as $user) {
            Notification::create([
                'user_id' => $user->id,
                'type' => $type,
                'message' => $message,
                'status' => 'delivered'
            ]);
        }
    }

    public function myNotifications(\Illuminate\Http\Request $request)
    {
        if (!$request->ajax()) {
            return redirect()->back();
        }

        $userId = Auth::id();

        $unseenCount = Notification::where('user_id', $userId)->where('status', '!=', 'seen')->count();

        $notifications = Notification::where('user_id', $userId)->orderBy('created_at', 'desc')->get();

        return response()->json([
            'count' => $unseenCount,
            'notifications' => $notifications
        ]);
    }

    public function markAllSeen()
    {
        $userId = Auth::id();
        Notification::where('user_id', $userId)->where('status', '!=', 'seen')->update(['status' => 'seen']);
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $notification = Notification::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $notification->delete();
        return response()->json(['success' => true]);
    }

}
