<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function sender()
    {
        return $this->belongsTo(User::class , 'sender_id');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class , 'chat_id');
    }
    public function getDateAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }
}
