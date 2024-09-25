<?php

namespace App\Http\Controllers\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {


        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        if (!$validateData) {
            return response()->json([
                'message' => 'not fields',
            ]);
        }

        $user = User::find($validateData['email'], 'email');

        if (!$user) {
            $create = new User();
            $create->name = $validateData['name'];
            $create->email = $validateData['email'];
            $create->password =  Hash::make($validateData['password']);

            if ($create->save()) {
                return response()->json([
                    'message' => 'create with success'
                ]);
            } else {

                return response()->json([
                    'message' => 'password or login in correct'
                ], 401);
            }
        }
    }

    public function login(Request $request)
    {
        $validateData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        if (!$validateData) {
            return response()->json([
                'message' => 'Campos obrigatórios não preenchidos.',
            ], 400);
        }

        if (!Auth::attempt($validateData)) {
            return response()->json([
                'message' => 'Email ou senha inválidos.',
            ], 401);
        }

        $user = $request->user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'type_token' => 'Bearer'
        ]);
    }

    public function logout(Request $request)
    {
        // Revoke the current user's token
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
