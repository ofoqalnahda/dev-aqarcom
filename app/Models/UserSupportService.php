<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserSupportService extends Pivot
{
    use HasFactory;

    protected $guarded = ['id'];

//    protected $with = ['supportService','area','city','user'];

    protected $casts = [
        'keywords' => 'array',
        'cities_ids' => 'array',
    ];
    function user()
    {
        return $this->belongsTo(User::class);
    }

    function supportService()
    {
        return $this->belongsTo(SupportService::class,'service_id');
    }


    protected static function boot()
    {
        parent::boot();

        $model_name = class_basename(self::class);

        static::created(function ()use ($model_name) {
            cache()->forget($model_name);
        });

        static::updated(function ()use ($model_name) {
            cache()->forget($model_name);
        });

        static::deleted(function ()use ($model_name) {
            cache()->forget($model_name);
        });
    }

}
