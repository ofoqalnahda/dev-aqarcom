<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertiserOrientationTranslation extends Model
{
    use HasFactory;
    protected $table = 'adv_orientation_translations';
    protected $guarded = [];
    public $timestamps = false;
}
