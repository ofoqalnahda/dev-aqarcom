<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
class SupportService extends Model
{
    use HasFactory , Translatable;
    protected $guarded = [];
    public $translatedAttributes = ['title'];

    protected $with = ['translations','users'];

    public function users()
    {
        return $this->belongsToMany(User::class , 'user_support_service' , 'support_service_id' , 'user_id')->withPivot(['cities_ids'])->with("accountType");
    }

    public function userServices()
    {
        return $this->hasMany(UserSupportService::class , 'service_id');
    }

    public function getTranslationRelationKey(): string
    {
        return 'service_id';
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
