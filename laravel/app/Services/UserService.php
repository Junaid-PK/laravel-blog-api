<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
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

        if(! $user){
            return response()->json([
                'message' => 'Something went wrong',
            ], 500);    
        }
        return response()->json([
            'message' => 'Registeration Successfull',
            'user' => $user,
        ], 200);
    }




    public function loginUser(array $data)
    {
        $email = $data['email'];
        $password = $data['password'];

        // Authenticate
        $user = User::where('email', $email)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Please Enter Valid Credentials'], 401);
        }

        $token = $user->createToken('token')->plainTextToken;
        return response()->json([
            'message' => 'Login Successfull',
            'token' => $token,
        ], 200);    
    }

    public function deleteUser(Request $request)
    {
        $id = $request->user_id;
        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => 'User Does Not Exist']);
        }
        if(User::where('id', $id)->delete()){
            return response()->json([
                'message' => 'User deleted successfully'
            ], 200);
        }
        return response()->json(['message' => 'Something went wrong'],500);
    }

    public function updateUser(Request $request)
    {
        $user = User::find(auth()->id());
        $role = $request->role;

        if($user->update(['role'=>$role])){
            return response()->json(['message' => 'User Role Updated']);
        }
        return response()->json(['message' => 'Something Went Wrong']);
    }


    public function logoutUser()
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Logout Successfull'],200);
    }

}

?>