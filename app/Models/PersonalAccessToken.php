<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    public static function booted()
    {
        static::updating(function (self $accessToken) {
            $dirty = $accessToken->getDirty();

            if (count($dirty) === 1 && isset($dirty['last_used_at'])) {
                return false;
            }

            return true;
        });
    }

}
