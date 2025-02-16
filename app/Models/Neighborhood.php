<?php

namespace App\Models;

use App\Http\Resources\NeighborhoodResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\Cache;

class Neighborhood extends Model implements TranslatableContract
{
    use HasFactory ,Translatable ;
    protected $guarded = [];
    public $translatedAttributes = ['name'];

    protected $with = ['translation'];

    public function city()
    {
        return $this->belongsTo(City::class , 'city_id');
    }

    protected static function boot(): void
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
