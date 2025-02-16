<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdPlatform extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    
   public function ad()
    {
        return $this->belongsTo(Ad::class, 'ad_id');
    }
    
    
    
    // Display Ad	عرض الإعلان	DisplayAd
    // Cancel Ad	إلغاء الإعلان	CancelAd
    // Update Ad	تحديث الإعلان	UpdateAd
    
    
    
    
//      SoldProperty	The property has been sold	تم بيع العقار	إلغاء الإعلان
// RentedProperty	The property has been rented	تم تأجير العقار	إلغاء الإعلان
// TransferredProperty	Ownership of the property has been transferred	تم نقل ملكية العقار 	إلغاء الإعلان
// IncorrectAdvertising	The real estate advertising license data is incorrect	بيانات ترخيص الإعلان العقاري غير صحيحة 	إلغاء الإعلان


}
