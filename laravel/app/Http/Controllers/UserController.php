<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Login Function
     * Takes the user's input from $request and
     * logs the user in.
    */
    public function login(LoginUserRequest $request){
        // request validation
        $validated = $request->validated();


        return response()->json($validated, 200);
    }

    public function register(){
        return response()->json('Registering User', 200);
    }

    public function messages(){
        return [
            'email.required' => 'The email field is required'
        ];
    }
}
