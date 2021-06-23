<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserApiController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'max:30', 'string'],
            'last_name' => ['required', 'max:30', 'string'],
            'email' => ['required', 'max:30', 'email', Rule::unique('users')],
            'telephone' => ['required', 'regex:/^\+55[0-9]{10,11}$/', 'string'],
            'password' => ['required', 'string', 'confirmed'],
            'password_confirmation' => ['required', 'string'],
        ]);

        $userData = $request->only(['first_name', 'last_name', 'email', 'password', 'telephone']);
        $userData['password'] = Hash::make($userData['password']);
        $userData['avatar'] = "https://ui-avatars.com/api/?background=0D8ABC&color=fff&name={$userData['first_name']}+{$userData['last_name']}";

        $user = User::create($userData);

        return response()->json([
            'success' => true,
        ]);

    }
}
