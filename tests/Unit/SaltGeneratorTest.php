<?php

namespace Tests\Unit;

use App\Support\Facades\Salt;
use Tests\TestCase;

class SaltGeneratorTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_should_return_every_salt_random()
    {
        $salts = [];
        $generateLength = 100;

        for ($i = 0; $i < $generateLength; ++$i) {
            $salts[] = Salt::generate();
        }

        $this->assertEquals($generateLength, count(array_unique($salts)));
    }
}
