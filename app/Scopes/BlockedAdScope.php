<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BlockedAdScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->when(auth('api')->check() , function ($query){
            $ids = auth('api')->user()->blockedUsers->pluck('id')->toArray();
            return $query->whereNotIn('ads.user_id' ,$ids);
        });
    }
}
