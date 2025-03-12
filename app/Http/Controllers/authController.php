<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class authController extends Controller
{

public function login(Request $request){
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            $userData["token"] = $request
                ->user()
                ->createToken('auth_token',['*'],now()->addDay(), $request->user()->uuid )->plainTextToken;
            $userData["name"] = $request->user()->name;
            return response()->json(['status' => true, "data" => $userData], 200);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
