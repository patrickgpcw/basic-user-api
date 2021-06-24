<?php

namespace App\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Salt extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'salt';
    }
}
