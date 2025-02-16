<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Model;

class Reason extends Model  implements TranslatableContract
{
    use HasFactory, Translatable;
    
    public array $translatedAttributes = ['title'];

    protected $guarded = [];
}
