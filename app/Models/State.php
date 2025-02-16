<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class State extends Model
{
    use HasFactory;
    protected $guarded = [];


    protected $appends = ['name'];

    public function getNameAttribute()
    {
        return $this->{'name_'. app()->getLocale()};
    }


    public function cities()
    {
        return $this->hasMany(City::class , 'state_id');
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
