<?php

namespace App\Contracts;

use App\ValueObjects\UserObj;


interface UserGetter
{
    public function get(): UserObj;
}
