<?php

namespace App\Models;

use App\Services\UserService;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Service extends Model implements TranslatableContract
{
    use HasFactory ,Translatable ;
    protected $guarded = [];
    public $translatedAttributes = ['name'];
    protected $with = ['translations','users'];

    protected $casts = [
        'is_val_required' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class , 'user_service' , 'service_id' , 'user_id')->withPivot(['city_id'])->with("accountType");
    }

    public function userServices()
    {
        return $this->hasMany(UserService::class , 'service_id');
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
