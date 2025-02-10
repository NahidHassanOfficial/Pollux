<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected function isAuthUser()
    {
        $user = Auth::guard('sanctum')->user();
        if ($user) {
            return $user;
        }
        return false;
    }

    public function getNotfications()
    {
        $user = $this->isAuthUser();
        if ($user) {
            $notifications = $user->unreadNotifications->select('data');
            return $notifications;
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    public function markAsRead()
    {
        $user = $this->isAuthUser();
        if ($user) {
            $user->unreadNotifications->markAsRead();
            return response()->json(['message' => 'Notifications marked as read'], 200);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

}
