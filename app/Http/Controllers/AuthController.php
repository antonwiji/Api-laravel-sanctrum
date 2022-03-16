<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request){
        
        $fileds = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required'
        ]);

        $user = User::create([
            'name' => $fileds['name'],
            'email' => $fileds['email'],
            'password' => bcrypt($fileds['password'])
        ]);

        $token = $user->createToken('mytoken')->plainTextToken;

        $respons = [
            'message' => 'create akun',
            'user' => $user,
            'token' => $token
        ];

        return response($respons, Response::HTTP_OK);

    }

    public function login(Request $request){
        $fileds = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        #check email
        $user = User::where('email', $fileds['email'])->first();

        if(!$user || !Hash::check($fileds['password'], $user->password)){
            return response(['message' => 'not match'], 401);
        }

        $token = $user->createToken('mytoken')->plainTextToken;

        $respon = [
            'user' => $user,
            'token' => $token
        ];

        return response($respon, 200);

    }



    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'log-out'
        ];
    }
}
