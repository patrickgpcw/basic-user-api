<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCreateApiTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_creation()
    {
        $email = 'test_' . $this->faker->email();

        $response = $this->json('POST', 'api/usuario', [
            'first_name' => 'Patrick',
            'last_name' => 'Pessanha',
            'email' => $email,
            'telephone' => '+5521979886657',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $user = User::where('email', $email)->first();

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertInstanceOf(User::class, $user);

        if ($user) {
            $user->delete();
        }

    }

    public function test_should_return_422_when_wrong_params()
    {

        $response = $this->json('POST', 'api/usuario', [
            'first_name' => 'PatrickPatrickPatrickPatrickPatrickPatrickPatrick',
            'last_name' => 'PessanhaPessanhaPessanhaPessanhaPessanhaPessanha',
            'email' => 'email@email@email@dominio.com',
            'telephone' => '+556874092021979886657',
            'password' => 'password',
            'password_confirmation' => 'passwod',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'first_name', 'last_name', 'email', 'telephone', 'password',
            ]);
    }

}
