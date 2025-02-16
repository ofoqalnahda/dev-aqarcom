<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class BankAccount extends Model
{
    use HasFactory , Translatable;
    protected $guarded = [];
    public $translatedAttributes = ['name'];

    protected $with = ['translations'];
}
