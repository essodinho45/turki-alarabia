<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FirebasePushController extends Controller
{
    public function setToken(Request $request)
    {
        $token = $request->input('fcm_token');
        $old_user = User::where('fcm_token', $token)->first();
        if ($old_user) {
            $user->update([
                'fcm_token' => null
            ]);
        }
        auth()->user()->update([
            'fcm_token' => $token
        ]); //Get the currrently logged in user and set their token
        return response()->json([
            'message' => 'Successfully Updated FCM Token'
        ]);
    }
}
