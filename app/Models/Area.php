<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\Cache;

class Area extends Model implements TranslatableContract
{
    use HasFactory ,Translatable ;
    protected $guarded = [];
    public $translatedAttributes = ['name'];

    protected $with = ['translation'];


    public function cities()
    {
        return $this->hasMany(City::class , 'area_id');
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
