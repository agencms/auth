<?php

namespace Agencms\Auth\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function login(Request $request)
    {
        if (Auth::guard('web')->attempt($request->only(['email', 'password']))) {
            return Auth::user()->api_token;
        }

        return response()->json(['error' => 'Authorization failed.'], 401);
    }

    public function required()
    {
        return response()->json(['error' => 'Authentication required.'], 401);
    }

    public function __construct()
    {
        //
    }
}
