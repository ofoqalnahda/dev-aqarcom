<?php

namespace App\Models;

use App\Scopes\ActiveAdScope;
use App\Scopes\BlockedAdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ad extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['attachments', 'adType', 'city', 'estateType', 'options', 'user', 'favourite'];

    protected $withCount = ['visits', 'storyViews', 'storyLikes'];



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    
    public function reason_cancelled()
    {
        return $this->belongsTo(Reason::class, 'reason_id');
    }
    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class, 'neighborhood_id');
    }

    public function estateType()
    {
        return $this->belongsTo(EstateType::class, 'estate_type_id');
    }

    public function estateArea()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function usageType()
    {
        return $this->belongsTo(UsageType::class, 'usage_type_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function adType()
    {
        return $this->belongsTo(AdType::class, 'ad_type_id');
    }

    public function advertiserOrientation()
    {
        return $this->belongsTo(AdvertiserOrientation::class, 'advertiser_orientation_id');
    }

    public function attachments()
    {
        return $this->hasMany(AdAttachment::class, 'ad_id');
    }
    
    
     public function platform()
    {
        return $this->hasMany(AdPlatform::class, 'ad_id');
    }
    public function videos()
    {
        return $this->hasMany(AdAttachment::class, 'ad_id')->where('extension_file','mp4');
    }

    public function visits()
    {
        return $this->hasMany(Visits::class, 'ad_id');
    }

    public function reports()
    {
        return $this->hasMany(AdReport::class, 'ad_id');
    }

    public function options()
    {
        return $this->belongsToMany(Property::class, 'ad_options', 'ad_id')->withPivot('values');
    }

    public function favourite()
    {
        return $this->belongsToMany(User::class, 'user_favourite_ads');
    }

    public function scopeWithAll($query)
    {
        $query->with(['attachments', 'adType', 'city', 'estateType']);
    }

    // storiess

    public function scopeNearest($query)
    {
        $lat = request()->lat;
        $lng = request()->lng;
        return $query->when($lat && $lng, function ($q) use ($lat, $lng) {
            return $q->select("*", DB::raw("6371 * acos(cos(radians(" . $lat . "))
            * cos(radians(lat)) * cos(radians(lng) - radians(" . $lng . "))
            + sin(radians(" . $lat . ")) * sin(radians(lat))) AS distance"))
                ->orderBy('distance', 'asc');
            //->having("distance", "<", $radius)
        });
    }

    public function scopeSell($query)
    {
        return $query->where('main_type', 'sell');
    }

    public function scopeStory($query)
    {
        return $query->where('is_story', true)->where('created_at', '>=', now()->subDays(10));
    }

    public function storyLikes()
    {
        return $this->hasMany(StoryView::class, 'ad_id')->where('liked', true);
    }

    public function toggleLike($userId)
    {
        $row = $this->storyViews()->where('user_id', $userId)->first();
        return $row->update(['liked' => !$row->liked]);
    }

    public function storyViews()
    {
        return $this->hasMany(StoryView::class, 'ad_id');
    }

    public function isLikedBy($userId)
    {
        return $this->storyViews()->where('user_id', $userId)->where('liked', true)->count();
    }

    public function scopeBuy($query)
    {
        return $query->where('main_type', 'buy');
    }

    public function scopeLimitWhen($query, $limit)
    {
        return $query->when($limit, function ($q) use ($limit) {
            $q->limit($limit);
        });
    }

    public function scopeOrderBySpecial($query)
    {
        return $query->orderBy('special', 'desc')->orderBy('refresh_date', 'desc');
    }

    public function scopeFilterAds($query, array $filters)
    {
        $keys = ['ad_type_id', 'estate_type_id', 'search', 'city_id', 'state_id', 'main_type',
            'usage_type_id', 'price', 'min_price', 'max_price', 'area', 'area_id', 'min_area', 'max_area', 'neighborhood_id'];

        $filters = array_filter($filters);
        foreach ($filters as $filterKey => $filterValue) {
            if (!in_array($filterKey, $keys) || !$filterValue) {
                continue;
            }

            if ($filterKey == 'search') {
                if (is_numeric($filterValue)) {
                    $query->where('id', (int)$filterValue);
                } else {
                    $query->where('description', 'like', '%' . $filterValue . '%');
                    $estateTypes = EstateType::whereTranslation('name', 'like', '%' . $filterValue . '%')->pluck('id');
                    $adTypes = AdType::whereTranslation('name', 'like', '%' . $filterValue . '%')->pluck('id');
                    $query->orWhereIn('estate_type_id', $estateTypes);
                    $query->orWhereIn('ad_type_id', $adTypes);
                }
            } elseif (str_contains($filterValue, ',')) {
                $filterValue = explode(',', $filterValue);
                $query->whereBetween($filterKey, $filterValue);
            } elseif ($filterKey == 'state_id') {
                $state = State::where('id',$filterValue)->first();
               
                if($state){
                    $area = Area::whereTranslationLike('name', '%' . $state->name . '%')->first();
                    if($area){
                        $query->where('area_id', $area->id);
                    }
                }
                
                // $state_cities = City::where('state_id',$filterValue)->pluck('id');
                // $query->whereIn('city_id', $state_cities??[]);
            }elseif($filterKey == 'min_price'){
                 $query->where('price', '>=', $filterValue);
                
            }elseif($filterKey == 'max_price'){
                 $query->where('price', '<=', $filterValue);
            } else {
                $query->where($filterKey, $filterValue);
            }
        }

        return $query;
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ActiveAdScope());
        static::addGlobalScope(new BlockedAdScope());

        static::created(fn() => static::clear_cache());
        static::updated(fn() => static::clear_cache());
        static::deleted(fn() => static::clear_cache());
    }

    public static function clear_cache(): void
    {
        cache()->forget('nearest_ads');
        cache()->forget('latest_ads');
        cache()->forget('index_buy_ads');
        cache()->forget('sell_ads');
        cache()->forget('buy_ads');
        cache()->forget('map_ads');

    }
}
