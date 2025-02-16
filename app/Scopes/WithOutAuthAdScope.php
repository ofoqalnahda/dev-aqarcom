<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class WithOutAuthAdScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->when(auth('api')->check() , function ($query){
            return $query->where('ads.user_id' , '<>', auth()->id());
        });
    }
}
