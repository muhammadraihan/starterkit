<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use Carbon\Carbon;

use Auth;
use Config;
use JWTAuth;
use Validator;

class AuthController extends Controller
{
    /**
     * setup auth provider instance
     * for default we use default larave User Table
     * change table if you need custom auth
     *
     * @return  void
     */
    public function __construct()
    {
        Config::set('jwt.user', User::class);
        Config::set('auth.providers', [
            'users' => [
                'driver' => 'eloquent',
                'model' => User::class,
            ]]);
    }

    public function Login(Request $request)
    {
        // Get credentials
        $credentials = $request->only('email', 'password');
        // Validation rules
        $rules = [
            'email' => 'required',
            'password' => 'required',
        ];
        // validation
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->messages(),
            ]);
        }
        // attempt login process
        try {
            // Check Email if exists
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email not registered',
                ], 401);
            }
        } catch (JWTException $e) {
            // Check if Email or Password match
            return response()->json([
                'success' => false,
                'message' => 'Login failed, please try again',
            ], 500);
        }

        // get last login for tracking purpose
        $loggedInUser = Auth::user();
        $user = User::find($loggedInUser->id);
        $user->last_login_at = Carbon::now()->toDateTimeString();
        $user->last_login_ip = $request->getClientIp();
        $user->save();

        // All good give 'em token
        return response()->json([
            'success' => true,
            'data' => [
                'token' => $token,
            ]]);
    }

    public function Logout(Request $request)
    {
        // Get JWT Token from the request header key "Authorization"
        $token = $request->header('Authorization');
        // Invalidate the token
        try {
            JWTAuth::invalidate($token);
            return response()->json([
                'success' => true,
                'message' => "Logged out.",
            ], 200);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                'success' => false,
                'message' => 'Failed to logout, please try again.',
            ], 500);
        }
    }
}
