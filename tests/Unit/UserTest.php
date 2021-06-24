<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function test_users_can_be_instantiated()
    {
        $users = User::factory()->count(3)->make();
        $this->assertContainsOnlyInstancesOf(User::class, $users);
    }
}
