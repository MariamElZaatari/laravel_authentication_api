<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller
{

    // auth:api middleware that obligates auth to access methods inside controller
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    // -------- Log in Section --------
    public function login(Request $request)
    {
        // Validate Request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // If validator fails, json encode error with status
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Generate token and check if authenticated

        // if authentication failed, json encode error with status
        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // if authenticated, assign new token to user
        return $this->createNewToken($token);
    }

    // Returns user with token
    protected function createNewToken($token)
    {
        return response()->json([
            // Assign Token to currently authenticated user
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 6000,
            'user' => auth()->user(),
        ]);
    }
    // --------------------------------

    // --------- Register Section -----------
    public function register(Request $request)
    {

        // Validate Request
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'first_name' => 'required|string|alpha|between:2,100',
            'last_name' => 'required|string|alpha|between:2,100',
            'phone' => 'required|string|size:8|regex:/^[0-9]+$/',
            'gender' => 'required|string|between:0,1',
            'age' => 'required|numeric|integer|min:12|max:99',
        ]);

        // If validator fails, json encode error with status
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        // Insert User by encrypting password and merging it into user info
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        // Return user along with success message and status
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
        ], 201);

    }
    // --------------------------------------
}
