<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    private function validateRequestData(Request $request)
    {
        return $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
    }

    private function validateRequestDataUser(Request $request)
    {
        return $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);
    }


    // connexion administrateur
    public function login_admin(Request $request)
    {
        $credentials = $this->validateRequestData($request);

        $is_exist = Admin::where('username', $credentials['username'])->first();

        if (!$is_exist) return response()->json(["message" => "cet utilisateur n'existe pas !", "status" => 404]);

        if ($is_exist && !Hash::check( $credentials['password'], $is_exist->password)) return response()->json(["message" => "Mot de passe incorrect !", "status" => 500]);

        $token = $is_exist->createToken('auth_token')->plainTextToken;

        return response()->json(["message" => "Vous êtes maintenant connecté", "access_token" => $token, "status" => 200])->cookie('jwt', 60 * 24);
    }


    // déconnexion
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
    }


    // register user
    public function store_user(Request $request)
    {
        $request->validate(['name' => 'required']);

        $credentials = $this->validateRequestDataUser($request);

        $credentials['name'] = $request->input('name');

        $is_exist = User::where('email', $credentials['email'])->first();

        if ($is_exist) return response()->json(["message" => "cet utilisateur existe déjà !", "user_id" => $is_exist->id, "status" => 409]);

        $create = User::create($credentials);

        if (!$create) return response()->json(["message" => "Une erreur est survenue !", "status" => 500]);

        return response()->json(["message" => "Inscription effectuée avec succès !", "user_id" => $create->id, "status" => 200]);
    }

    // delete user
    public function delete_user(Request $request)
    {
        $request->validate(["user_id" => "required"]);
        $user = User::findOrFail($request->input('user_id'));
        $user->delete();

        return response()->json(["message" => "Utilisateur enregistré !", "status" => 200]);
    }
}
