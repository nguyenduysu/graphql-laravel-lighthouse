<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function getLogin()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {
        $credentials = array(
            'email' => $request->email,
            'password' => $request->password
        );

        $token = auth()->attempt($credentials);
        if(!$token) {
            throw new \Exception("Unauthorized");
        }

        $authPayload = new \stdClass();
        $authPayload->token = $token;
        $authPayload->type = "Bearer";
        $authPayload->expired = auth()->factory()->getTTL()*60;

        $data = array(
            'user' => Auth::user(),
            'authPayload' => $authPayload
        );
        return view('welcome', $data);
    }

    public function logout(Request $request)
    {
        auth()->logout(true);
        return redirect('login');
    }
}
