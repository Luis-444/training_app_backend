<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' =>'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
               'message' => 'Credenciales incorrectas',
               'error' => true,
            ], 401);
        }

        $token = $user->createToken('AccessToken')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Usuario creado correctamente'
        ], 201);
    }

    public function register(Request $request){
        $request->validate([
            'name' =>'required|string',
            'email' =>'required|email|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->save();
        $token = $user->createToken('AccessToken')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Usuario creado correctamente'
        ], 201);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
           'message' => 'Sesión cerrada correctamente'
        ], 200);
    }
}
