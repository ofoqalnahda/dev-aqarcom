<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model implements TranslatableContract
{
    use HasFactory , Translatable;
    public $timestamps = false;
    public array $translatedAttributes = ['about_us' , 'terms' , 'privacy' , 'description' , 'agreement' , 'ad_conditions','app_commission','idea_policy','our_vision' , 'our_message'];
//    protected $with = ['translation'];
    protected $guarded = [];


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
