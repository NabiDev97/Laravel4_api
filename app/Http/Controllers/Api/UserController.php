<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LogUserRequest; // Assurez-vous que la requête est correctement importée
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterUser;

class UserController extends Controller
{
    public function register(RegisterUser $request)
    {
        try {
            // Code d'enregistrement de l'utilisateur
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Erreur lors de l\'enregistrement de l\'utilisateur',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function login(LogUserRequest $request)
    {
        if (Auth::attempt($request->only(['email', 'password']))) {
            $user = Auth::user();
            $token = $user->createToken('MA_CLE_SECRETE_VISIBLE_UNIQUEMENT_AU_BACKEND')->plainTextTok;

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Connexion réussie',
                'user' => $user,
                'token' => $token
            ]);
        } else {
            // Informations ne correspondant à aucun utilisateur
            return response()->json([
                'status_code' => 401,
                'status_message' => 'Informations non valides',
                'error' => 'Adresse e-mail ou mot de passe incorrect'
            ]);
        }
    }
}
