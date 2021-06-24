<?php

namespace App\Services;

use App\Contracts\JWTValidatorContract;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;

class JWTValidatorService implements JWTValidatorContract
{
    public function validate($jwt): bool
    {
        $key = env('JWT_PRIVATE_KEY');

        try {
            $decoded = JWT::decode($jwt, $key, ['HS256']);
            Auth::loginUsingId($decoded->sub);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
