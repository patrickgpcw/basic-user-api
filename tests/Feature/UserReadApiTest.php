<?php

namespace Tests\Feature;

use App\Http\Resources\UserCollection;
use App\Models\User;
use Tests\TestCase;

class UserReadApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_read_all()
    {
        $page = 2;
        $quantity = 5;

        $users = new UserCollection(User::query()->skip($quantity * ($page - 1))->take($quantity)->get());

        $response = $this->json('GET', 'api/usuario', [
            'pagina' => $page,
            'exibir' => $quantity,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(json_decode($users->toJson(), true));
    }

    public function test_user_read_with_search()
    {
        $page = config('api.page');
        $quantity = config('api.quantity');

        $name = 'Pess';

        $users = new UserCollection(
            User::where('first_name', 'like', "%$name%")
                ->orWhere('last_name', 'like', "%$name%")
                ->skip($quantity * ($page - 1))
                ->take($quantity)
                ->get()
        );

        $response = $this->json('GET', 'api/usuario', [
            'nome' => $name,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(json_decode($users->toJson(), true));
    }

    public function test_should_return_422_when_wrong_paraments()
    {
        $response = $this->json('GET', 'api/usuario', [
            'nome' => 56,
            'pagina' => -2,
            'exibir' => -10,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'nome',
                'pagina',
                'exibir',
            ]);
    }

    public function test_should_return_422_when_page_is_biggest_then_limit()
    {
        $response = $this->json('GET', 'api/usuario', [
            'pagina' => 10000,
            'exibir' => 100,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'pagina',
            ]);
    }
}
