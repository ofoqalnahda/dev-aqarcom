<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class EstateDeveloperService extends Model
{
    use HasFactory , Translatable;
    protected $guarded = [];
    public $translatedAttributes = ['title'];

    protected $with = ['translations'];
    public function getTranslationRelationKey(): string
    {
        return 'service_id';
    }
}
