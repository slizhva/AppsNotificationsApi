<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

use App\Models\Notification;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function notifications():Renderable
    {
        $user = Auth::user();
        $notifications = Notification::where('user', $user->id)
            ->orderBy('id', 'desc')->get(['id', 'name', 'data', 'type'])
            ->toArray();

        return view('pages.notifications', [
            'token' => $user->api_token,
            'dangerous_actions_key' => $user->dangerous_actions_key,
            'notifications' => $notifications,
            'notificationTypes' => Notification::NOTIFICATION_TYPES,
        ]);
    }

    public function add(Request $request):RedirectResponse
    {
        $data = new Notification;
        $data->name = $request->get('name');
        $data->type = $request->get('type');
        $data->data = $request->get('data');
        $data->user = Auth::id();
        $data->save();

        return redirect()->route('notifications');
    }

    public function delete(Request $request):RedirectResponse
    {
        $user = Auth::user();
        if ($user['dangerous_actions_key'] !== $request->get('dangerous_actions_key')) {
            return redirect()->route('sets')->with('error', 'Error: Wrong dangerous action key.');
        }

        $notification = Notification
            ::where('id', $request->route('notification_id'))
            ->where('user', Auth::id())
            ->limit(1);

        if ($notification->count() === 0) {
            return redirect()->route('sets')->with('error', 'Error: Data item not found.');
        }

        $notification->delete();
        return redirect()->route('sets')->with('status', 'Success: The data item was deleted.');
    }

}
