<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
       $validator =  Validator::make($request->all(),[
              'email'=>'required',
              'password'=>'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->messages()
            ]);
        }
        $data = $validator->validated();
        $user = User::where('email', $data['email'])->first();
        
        if(!$user || !Hash::check($data['password'], $user->password)){
           return response()->json([
            'message' => 'Invalid user credentials'
        ], 401);
        }
        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;

        return response()->json([
        'message' => 'Login successful',
        'user' => $user,
        'access_token' => $token
    ], 200);
    }
}
