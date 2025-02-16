<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Section extends Model
{

    use HasFactory  ;
    protected $guarded = [];
    public $translatedAttributes = ['description'];

//    protected $with = ['translations'];
    public function images()
    {
        return $this->hasMany(SectionImage::class , 'section_id');
    }

}
