<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function register(array $data): User
    {
        // Créez l'utilisateur en utilisant le modèle User
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function login(array $data): ?string
    {
        // Recherchez l'utilisateur par email
        $user = User::where('email', $data['email'])->first();

        // Vérifiez si l'utilisateur existe et si le mot de passe est correct
        if ($user && password_verify($data['password'], $user->password)) {
            // Générez un token d'authentification pour l'utilisateur
            return $user->createToken('auth_token')->plainTextToken;
        }

        return null;
    }

    public function logout(User $user): void
    {
        // Révoquez tous les tokens de l'utilisateur
        $user->tokens()->delete();
    }
}
