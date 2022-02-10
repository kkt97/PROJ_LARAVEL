<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info(__METHOD__);

        Log::info($request);

        $request->validate([
            'user_id' => 'required|min:6|max:15|unique:users|string',
            'email' => 'required|email|max:30|unique:users',
            'phone' => 'required|regex:/(01)[0-9]{9}/',
            'password' => 'required|min:8|max:20|confirmed',
            'address' => 'required'
        ]);


        $outs = User::create([
            'name' => $request->input('name'),
            'user_id' => $request->input('user_id'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => bcrypt($request->input('password')),
            'address' => $request->input('address'),
            'code' => $request->input('code'),
            'user_level' => config('ext.user.user_level.default'),
        ]);

        Log::info($outs);

        return json_encode($outs);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
