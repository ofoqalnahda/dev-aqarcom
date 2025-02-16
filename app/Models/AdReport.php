<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdReport extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function ad()
    {
        return $this->belongsTo(Ad::class , 'ad_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function reportReason()
    {
        return $this->belongsTo(ReportReason::class , 'report_reason_id');
    }
}
