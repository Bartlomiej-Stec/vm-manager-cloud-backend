<?php

namespace App\Services;

use App\Contracts\UserGetter;
use App\ValueObjects\UserObj;
use Illuminate\Support\Facades\Auth;

class UserGetterService implements UserGetter
{
    public function get(): UserObj
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return UserObj::fromModel($user);
    }

}
