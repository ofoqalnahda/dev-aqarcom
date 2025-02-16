<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankCalc extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'national_id',
        'birth_date',
        'salary',
        'contact_number',
        'email',
        'job',
        'job_name',
        'financial_obligations',
        'bank_name',
        'gov_supported',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }


    static function jobTypes(): array
    {
        return [
            'مدني',
            'قطاع خاص',
            'عسكري',
            'متقاعد',
        ];
    }

    static function militaryJobTypes(): array
    {
         return[
            'عريف',
            'رقيب وكيل',
            'اول رقيب',
            'رقباء رئيس',
            'مالزم',
            'نقيب',
            'رائد',
            'مقدم',
            'عقيد',
            'عميد',
            'لواء',
        ];
    }


}
