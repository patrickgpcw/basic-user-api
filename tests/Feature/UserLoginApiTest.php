<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Mockery\MockInterface;
use Tests\TestCase;

class UserLoginApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_login()
    {
        $user = User::factory()->create();

        $now = Carbon::now();

        $this->mock(Carbon::class, function (MockInterface $mock) use ($now) {
            $mock->shouldReceive('now')->andReturn($now);
        });

        $key = env('JWT_PRIVATE_KEY');
        $payload = [
            "iss" => url('/'),
            "aud" => url('/'),
            "sub" => $user->id,
            "iat" => $now->timestamp,
            "exp" => $now->addHour()->timestamp,
        ];
        $jwt = JWT::encode($payload, $key);

        $response = $this->json('POST', 'api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $user->delete();

        $response->assertStatus(200)
            ->assertExactJson([
                'jwt' => $jwt,
            ]);
    }

    public function test_should_return_422_when_passing_invalid_credentials()
    {
        $response = $this->json('POST', 'api/login', [
            'email' => 'abcdef',
            'password' => '123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password']);
    }
}
