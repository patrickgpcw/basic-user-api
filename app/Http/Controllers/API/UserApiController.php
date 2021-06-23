<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserApiCreateRequest;
use App\Http\Requests\UserApiReadRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    public function create(UserApiCreateRequest $request)
    {
        $userData = $request->only(['first_name', 'last_name', 'email', 'password', 'telephone']);
        $userData['password'] = Hash::make($userData['password']);
        $userData['avatar'] = "https://ui-avatars.com/api/?background=0D8ABC&color=fff&name={$userData['first_name']}+{$userData['last_name']}";

        User::create($userData);

        return response()->json([
            'success' => true,
        ]);

    }

    public function read(UserApiReadRequest $request)
    {
        $name = $request->input('nome');

        $page = $request->input('pagina', config('api.page'));
        $quantity = $request->input('exibir', config('api.quantity'));

        $users = User::name($name)
            ->page($page, $quantity)
            ->get();

        return response()->json(new UserCollection($users));
    }

    public function show(User $user)
    {
        return response()->json(new UserResource($user));
    }
}
