<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Property extends Model implements TranslatableContract
{
    use HasFactory ,Translatable ;
    protected $guarded = [];
    public $translatedAttributes = ['name'];

    protected $with = ['translations'];

    public function adType()
    {
        return $this->belongsTo(AdType::class , 'ad_type_id');
    }

    public function estateType()
    {
        return $this->belongsTo(EstateType::class , 'estate_type_id');
    }
}
