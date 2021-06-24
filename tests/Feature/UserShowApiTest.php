<?php

namespace Tests\Feature;

use App\Http\Middleware\ValidJWTMiddleware;
use App\Http\Resources\UserResource;
use App\Models\User;
use Tests\TestCase;

class UserShowApiTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_show()
    {
        $this->withoutMiddleware(ValidJWTMiddleware::class);

        $user = User::first();

        $userResource = new UserResource($user);

        $response = $this->json('GET', "api/usuario/$user->id");
        $response->assertStatus(200)
            ->assertExactJson(json_decode($userResource->toJson(), true));
    }

    public function test_should_return_404_when_invalid_user_id()
    {
        $this->withoutMiddleware(ValidJWTMiddleware::class);

        $response = $this->json('GET', "api/usuario/-3");

        $response->assertStatus(404);
    }
}
