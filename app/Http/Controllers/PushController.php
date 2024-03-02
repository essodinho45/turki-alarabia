<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\OrderCreated;
use App\Notifications\OfferCreated;
use App\Notifications\ApprovedByManager;
use App\Notifications\ApprovedByBank;
use App\Notifications\OrderWaitingTurki;
use App\Notifications\ApprovedByTurki;
use App\Notifications\MessageSent;
use App\Notifications\ApprovedByClient;
use App\Notifications\TransactionDone;
use Auth;

class PushController extends Controller
{
    /**
     * Store the PushSubscription.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'endpoint' => 'required',
            'keys.auth' => 'required',
            'keys.p256dh' => 'required'
        ]);

        $endpoint = $request->endpoint;
        $token = $request->keys['auth'];
        $key = $request->keys['p256dh'];
        $user = Auth::user();
        $user->updatePushSubscription($endpoint, $key, $token);

        return response()->json(['success' => true], 200);
    }
    public function dashboard()
    {
        $user_notifications = auth()->user()->unreadNotifications;
        $notifications = [];
        $notifications['to_approve'] = $user_notifications->whereIn('type', [OrderCreated::class, OfferCreated::class, ApprovedByManager::class])->count();
        $notifications['in_progress'] = $user_notifications->whereIn('type', [ApprovedByBank::class, OrderWaitingTurki::class, ApprovedByTurki::class])->count();
        $notifications['to_approve_by_agent'] = $user_notifications->whereIn('type', [MessageSent::class])->count();
        $notifications['completed'] = $user_notifications->whereIn('type', [ApprovedByClient::class, TransactionDone::class])->count();
        // dd($notifications);
        return view('dashboard', compact('notifications'));
    }
}
