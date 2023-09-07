<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Post;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Nette\Utils\Random;

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
        return $token;
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
     * Register User as Guest
     */
    public function registerAsGuest(Request $request){
        $name= Random::generate(10,'a-z');
        $email = Random::generate(10,'a-z');
        $password = Random::generate(10,'0-9');
        $role = 'guest';
        $user = User::create([
            'name' => 'Guest'.$name,
            'email' => $email.'@gmail.com',
            'password' => $password,
            'role' => $role
        ]);
        if(!$user){
            return response()->json(['message' => 'Something went wrong']);
        }
        return response()->json(['message' => 'User Registered Successfully']);
    }

    /**
     * Logout the user
     */
    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Logout Successfull'],200);
    }

    /**
     * Delete user
     */
    public function remove(Request $request){
        $id = $request->user_id;
        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => 'User Does Not Exist']);
        }
        $request = User::where('id', $id)->delete();
        if(!$request){
            return response()->json(['message' => 'Something went wrong'],500);
        }
        return response()->json([
            'message' => 'User deleted successfully'
        ], 200);
    }

    /**
     * Update User
     */
    public function update(Request $request){
        $id = $request->user_id;
        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => 'User Does Not Exist']);
        }

        $role = $request->role;
        if($user->update(['role'=>$role])){
            return response()->json(['message' => 'User Role Updated']);
        }
        
        return response()->json(['message' => 'Something Went Wrong']);
    }
}
