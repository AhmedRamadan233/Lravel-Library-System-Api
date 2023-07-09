<?php

namespace App\Traits;

use Auth;
use Illuminate\Auth\Access\AuthorizationException;

trait AuthorizeChecked
{
    public function authorizeChecked($permission)
    {
        if (!Auth::user()->can($permission)) {
            throw new AuthorizationException();
        }
    }
}
