<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginApiLoginRequest;
use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;

class LoginApiController extends Controller
{
    public function login(LoginApiLoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            abort(419, trans('auth.failed'));
        }

        $user = User::where('email', $credentials['email'])->first();
        $now = Carbon::now();

        $key = env('JWT_PRIVATE_KEY');
        $payload = [
            "iss" => url('/'),
            "aud" => url('/'),
            "sub" => $user->id,
            "iat" => $now->timestamp,
            "exp" => $now->addHour()->timestamp,
        ];

        $jwt = JWT::encode($payload, $key);

        return response()->json([
            'jwt' => $jwt,
        ]);
    }
}
