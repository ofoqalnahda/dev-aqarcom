<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class AccountType extends Model
{
    use HasFactory ,Translatable ;
    protected $guarded = [];
    public array $translatedAttributes = ['name'];

    protected $with = ['translation'];

}
