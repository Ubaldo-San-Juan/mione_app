<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'data.attributes.name' => ['required', 'string', 'min:4'],
            // 'data.attributes.email' => ['required', 'email', 'exists:users, email'],
            'data.attributes.email' => ['required', 'email', 'lowercase','unique:users,email'],
            'data.attributes.password' => ['required', 'confirmed'],

            // 'data.attributes.password' =>[
            //     'required',
            //     'string',
            //     'min:8', // Minimo 8 caracteres
            //     'regex:/[a-z]/', // Al menos una letra minúscula
            //     'regex:/[A-Z/', // Al menos una letra mayuscula
            //     'regex:/[0-9]/', // Al menos un numero
            //     'regex:/[@$!%*#?&]/' // Al menos un caracter especial
            // ],

        ]);

        //Almacenar los datos
        $user = User::create([
            'name' => $request->input('data.attributes.name'),
            'email' => $request->input('data.attributes.email'),
            'password' => $request->input(('data.attributes.password')), //Doble parentesis: Cateo de datos (Cambiar a un tipo de datoa a otro)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'data.attributes.email' => ['required', 'email', 'exists:users,email'],
            'data.attributes.password' => ['required'],
        ]);

        //Extraer los datos de email y password directamente del request
        $credentials = [
            'email' => $request->input('data.attributes.email'),
            'password' => $request->input('data.attributes.password'),
        ];

        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            $cookie = cookie('cookie_token', $token, 60 * 24); //Expira en 1 dia
            return response(["token" => $token], Response::HTTP_OK)->withCookie($cookie);
        }else{
            return response(["message" => "Credenciales inválidas"], Response::HTTP_UNAUTHORIZED);
        }
    }
}
