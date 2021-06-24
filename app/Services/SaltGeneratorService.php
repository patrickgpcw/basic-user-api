<?php

namespace App\Services;

use App\Contracts\SaltGeneratorContract;
use Illuminate\Support\Str;

class SaltGeneratorService implements SaltGeneratorContract
{
    public function generate(): string
    {
        $preffix = config('salt.preffix', '_');
        $suffix = config('salt.suffix', '$');
        $length = config('salt.length', 22);

        $salt = Str::random($length);

        return $preffix . $salt . $suffix;
    }
}
