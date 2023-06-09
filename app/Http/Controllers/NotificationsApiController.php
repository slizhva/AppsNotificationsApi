<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

use App\Models\User;
use App\Models\Notification as NotificationModel;
use App\Notifications\StatusNotification;

class NotificationsApiController extends Controller
{

    public function run(Request $request):JsonResponse
    {
        $user = User
            ::where('api_token', $request->route('token'))
            ->first();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'wrong api token',
            ]);
        }

        $notification = NotificationModel::where('user', $user->id)
            ->where('id', $request->route('notification_id'))
            ->get(['id', 'name', 'data', 'type'])
            ->toArray()[0];

        $statusNotifications = new StatusNotification([
            'content' =>
                (env('APP_ENV') === 'local' ? "*----- DEV TEST -----*\n" : '') .
                '*----- NOTIFICATION NAME -----*' . "\n" .
                $notification['name'] . "\n" .
                '*----- NOTIFICATION DATA -----*' . "\n" .
                $request->getContent()
        ]);

        Notification::route(NotificationModel::NOTIFICATION_TYPES[$notification['type']], $notification['data'])
            ->notify($statusNotifications);

        return response()->json([
            'status' => true,
            'message' => 'Notification ' . $notification['name'] . ' run successfully',
        ]);
    }
}
