<?php

namespace App\Contracts;

interface JWTValidatorContract
{
    public function validate($jwt): bool;
}
