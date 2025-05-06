<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Auth\Events\Registered;
class UserController extends Controller
{


    public function Register(Request $request){
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:instructor,student,admin',
             
        ]);
    
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'active'=>false
           ]);
    

        $token = JWTAuth::fromUser($user);
    
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }
    

    public function Login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'message' => 'Email or password incorrect',
            ], 401);
        }
    
        return response()->json([
            'user' => auth()->user(),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
    
    public function GetUsers(Request $request)
    {
        $users = User::all();
        return response()->json([
            'message' => 'Users retrieved successfully',
            'users' => $users,
        ]);
    }

    public function getUser($id) {
        $user = User::find($id);
    
        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
    
        return response()->json($user);
    }

    public function updateUser(Request $request, $id)
    {
     $user = User::find($id);

     if (!$user) {
        return response()->json([
            'message' => 'User not found'
        ], 404);
    }

      $request->validate([
        'name' => 'string|max:255',
        'email' => 'email|unique:users,email,' . $id,
        'phone' => 'nullable|string|max:20',
     ]);

    // Update fields
    $user->update($request->all());

    return response()->json([
        'message' => 'User updated successfully',
        'user' => $user
    ]);
   }

   
    
}