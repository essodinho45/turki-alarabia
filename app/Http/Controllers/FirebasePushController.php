<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FirebasePushController extends Controller
{
    public function setToken(Request $request)
    {
        $token = $request->input('fcm_token');
        auth()->user()->update([
            'fcm_token' => $token
        ]); //Get the currrently logged in user and set their token
        return response()->json([
            'message' => 'Successfully Updated FCM Token'
        ]);
    }
}
