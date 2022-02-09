<?php


namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        Log::info(__METHOD__);

        $request->validate([
            'user_id' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::attempt($request->only('user_id', 'password'))) {

            Log::info(2);
            Log::info(\auth()->id());

            return response()->json(Auth::user(), 200);
//            return response()->json(['foo'], 200, [], JSON_PRETTY_PRINT);
        }
//        throw ValidationException::withMessages([
//            'user_id' => ['The provided credentials are incorect.']
//        ]);
    }

    public function logout()
    {
        Auth::logout();
    }
}
