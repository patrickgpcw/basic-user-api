<?php

namespace App\Contracts;

interface SaltGeneratorContract
{
    public function generate(): string;
}
