<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Login User
    */
    public function login(LoginUserRequest $request, UserService $userService){
        $validated = $request->validated();
        $token = $userService->loginUser($validated);
        return $token;
    }

    /**
     * Register User
     */
    public function register(RegisterUserRequest $request, UserService $userService){
        $validated = $request->validated();
        $response = $userService->registerUser($validated);
        return $response;
    }

    /**
     * Logout the user
     */
    public function logout(UserService $userService){
        $response = $userService->logoutUser();
        return $response;
    }

    /**
     * Delete user
     */
    public function remove(Request $request, UserService $userService){
        $response = $userService->deleteUser($request);
        return $response;
    }

    /**
     * Update User
     */
    public function update(Request $request, UserService $userService){
        $response = $userService->updateUser($request);
        return $response;
    }


    /**
     * Get All Users
     */
    public function getUsers(){
        return response()->json(['users' =>  User::all()]);
    }

    /**
     * Get All Users alongwith their Posts
     */
    public function getUserPosts(){
        return response()->json(['userPosts' => User::with('posts')->get()]);
    }
}
