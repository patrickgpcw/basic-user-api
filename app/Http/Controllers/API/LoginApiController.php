<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginApiLoginRequest;
use App\Models\User;
use App\Repositories\LoginApiRepository;

class LoginApiController extends Controller
{
    private $repository;

    public function __construct(LoginApiRepository $repository)
    {
        $this->repository = $repository;
    }

    public function login(LoginApiLoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        $user = User::where('email', $credentials['email'])->firstOrFail();

        if (!$this->repository->validateLogin($user, $credentials['password'])) {
            abort(419, trans('auth.failed'));
        }

        $jwt = $this->repository->generateJWT($user->id);

        return response()->json([
            'jwt' => $jwt,
        ]);
    }
}
