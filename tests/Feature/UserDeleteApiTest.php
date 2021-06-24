<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserDeleteApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_delete()
    {
        $user = User::first();

        $response = $this->json('DELETE', "/api/usuario/$user->id");

        $response->assertStatus(200)
            ->assertExactJson([
                'success' => true,
            ]);

        $this->assertDeleted('users', $user->toArray());
    }

    public function test_should_return_404_when_id_invalid()
    {
        $response = $this->json('DELETE', "api/usuario/-99");

        $response->assertStatus(404);
    }
}
