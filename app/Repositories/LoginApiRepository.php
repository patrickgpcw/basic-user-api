<?php

namespace App\Repositories;

use App\Support\Facades\Salt;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginApiRepository
{
    public function validateLogin($user, $password)
    {
        $credentials['email'] = $user->email;
        $credentials['password'] = $password . $user->salt;

        if (!Auth::attempt($credentials)) {
            return false;
        }

        if (config('salt.update_on_login', false)) {
            $this->updateSaltOnLogin($user, $password);
        }

        return true;
    }

    public function updateSaltOnLogin($user, $password)
    {
        $salt = Salt::generate();
        $user->update([
            'salt' => $salt,
            'password' => Hash::make($password . $salt),
        ]);
    }

    public function generateJWT($userId)
    {
        $now = Carbon::now();

        $key = env('JWT_PRIVATE_KEY');
        $payload = [
            "iss" => url('/'),
            "aud" => url('/'),
            "sub" => $userId,
            "iat" => $now->timestamp,
            "exp" => $now->addHour()->timestamp,
        ];

        return JWT::encode($payload, $key);
    }
}
