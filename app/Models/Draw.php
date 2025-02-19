<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Draw extends Model
{
    use HasFactory;

    protected $table = 'draws';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function scopeShow($query)
    {
        return $query->wherein('status', ['pending','completed']);
    }

    public function marketer()
    {
        return $this->belongsTo(Marketer::class);
    }
}
