<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserService
{


    public function registerUser(array $data)
    {
        $name = $data['name'];
        $email = $data['email'];
        $password = $data['password'];
        $role = 'user';

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role,
        ]);        

        return $user;
    }




    public function loginUser(array $data)
    {
        $email = $data['email'];
        $password = $data['password'];

        // Authenticate
        $user = User::where('email', $email)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Please Enter Valid Credentials'],401);
        }

        $token = $user->createToken('token')->plainTextToken;
        return $token;        
    }

}

?>