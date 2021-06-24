<?php

namespace Tests\Unit;

use App\Http\Middleware\ValidJWTMiddleware;
use App\Models\User;
use App\Services\JWTValidatorService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ValidJWTMiddlewareTest extends TestCase
{
    use WithFaker;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_valid_jwt_middleware()
    {
        $user = User::factory()->create();

        $response = $this->json('POST', 'api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $jwt = $response->json('jwt');

        $request = new Request;
        $request->headers->set('Authorization', "Bearer $jwt");

        $middleware = new ValidJWTMiddleware(new JWTValidatorService());

        $middleware->handle($request, function () use ($user) {
            $this->assertEquals(Auth::id(), $user->id);
        });
    }
}
