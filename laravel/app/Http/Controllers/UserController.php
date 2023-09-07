<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Login Function
     * Takes the user's input from request
     * logs the user in.
    */
    public function login(LoginUserRequest $request, UserService $userService){
        // get input data
        $validated = $request->validated();
        // authenticate
        $token = $userService->loginUser($validated);
        // respond
        return response()->json([
            'message' => 'Login Successfull',
            'token' => $token,
        ], 200);
    }

    /**
     * Register Function
     * Takes the user's input 
     * registers the user
     */
    public function register(RegisterUserRequest $request, UserService $userService){
        $validated = $request->validated();
        $user = $userService->registerUser($validated);
        return response()->json([
            'message' => 'Registeration Successfull',
            'user' => $user,
        ], 200);
    }

    /**
     * Logout the user
     */
    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Logout Successfull'],200);
    }
}
