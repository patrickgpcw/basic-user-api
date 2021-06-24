<?php

namespace Tests\Feature;

use App\Http\Middleware\ValidJWTMiddleware;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserUpdateApiTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_update()
    {
        $this->withoutMiddleware(ValidJWTMiddleware::class);

        $user = User::first();

        $response = $this->json('PUT', "api/usuario/$user->id", [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'telephone' => '+55' . $this->faker->phoneNumberCleared(),
        ]);

        $userValidate = User::first();

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertNotEquals($userValidate, $user);
    }

    public function test_user_update_password()
    {
        $this->withoutMiddleware(ValidJWTMiddleware::class);

        $user = User::first();

        $response = $this->json('PUT', "api/usuario/$user->id", [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'telephone' => $user->telephone,
            'password' => '123trocarsenha',
            'password_confirmation' => '123trocarsenha',
        ]);

        $userValidate = User::first();

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertNotEquals($userValidate, $user);
    }

    public function test_should_return_422_when_wrong_params()
    {
        $this->withoutMiddleware(ValidJWTMiddleware::class);

        $user = User::first();

        $response = $this->json('PUT', "api/usuario/$user->id", [
            'last_name' => 123,
            'email' => 'email@e@mail.com',
            'telephone' => 'oitudobem',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['first_name', 'last_name', 'email', 'telephone']);
    }

    public function test_should_return_422_when_wrong_params_with_password()
    {
        $this->withoutMiddleware(ValidJWTMiddleware::class);

        $user = User::first();

        $response = $this->json('PUT', "api/usuario/$user->id", [
            'last_name' => 123,
            'email' => 'email@e@mail.com',
            'telephone' => 'oitudobem',
            'password' => '123trocarsenha',
            'password_confirmation' => '12334',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['first_name', 'last_name', 'email', 'telephone', 'password', 'password_confirmation']);
    }

    public function test_should_return_404_when_id_invalid()
    {
        $this->withoutMiddleware(ValidJWTMiddleware::class);

        $response = $this->json('PUT', "api/usuario/9999999999", [
            'last_name' => 123,
            'email' => 'email@e@mail.com',
            'telephone' => 'oitudobem',
            'password' => '123trocarsenha',
            'password_confirmation' => '12334',
        ]);

        $response->assertStatus(404);
    }
}
