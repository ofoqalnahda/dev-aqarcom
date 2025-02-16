<?php

namespace App\Models;

use App\Http\Resources\SupportServiceAdResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportServiceAd extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = ['user', 'supportService', 'city', 'area', 'attachments'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function supportService()
    {
        return $this->belongsTo(SupportService::class, 'support_service_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function scopeFilter(Builder $query)
    {
        $query->where('active', true);

        $query->when(request('support_service_id'), fn($query, $support_service_id) => $query->where('support_service_id', $support_service_id));

        $query->when(request('city_id'), fn($query, $city_id) => $query->where('city_id', $city_id));

        $query->when(request('area_id'), fn($query, $area_id) => $query->where('area_id', $area_id));

        $query->when(request('user_id'), fn($query, $user_id) => $query->where('user_id', $user_id));

    }

    public function toArray()
    {
        return SupportServiceAdResource::make($this);
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
