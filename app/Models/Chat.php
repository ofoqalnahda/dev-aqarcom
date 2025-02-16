<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $with = ['receiver','sender','lastMessage'];

    public function receiver()
    {
        return $this->belongsTo(User::class , 'receiver_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class , 'chat_id')->latest();
    }

    public function lastMessage()
    {
        return $this->hasOne(ChatMessage::class , 'chat_id')->latest();
    }

    public function getDateAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }
}
