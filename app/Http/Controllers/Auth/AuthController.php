<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){

        Log::info('1');

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|min:6|max:15|string',
            'password' => 'required|min:8|max:20',
        ]);


        Log::info('3');

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        Log::info('1');

        try{
            $user = User::where('user_id', $request->user_id)
                ->where('password', bcrypt($request->password))
                ->first();

        }catch(\Exception $e){
            Log::info($e->getMessage());
        }

        if(!$user){
            Log::info('fail');
        }

        Log::info('4');

        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        // validator에서 422에러가 나면 validator에 관한 에러
        // 401에 대한 에러가 나면 토큰에러?
        return $this->createNewToken($token);

        //todo 로그인 정보확인 및 validation
    }

    public function loginCheck()
    {
        Log::info('1');

        $u = \auth()->user();
        Log::info($u);

        return json_encode($u);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
