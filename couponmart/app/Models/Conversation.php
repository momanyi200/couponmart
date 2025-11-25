<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['order_id', 'is_admin_chat'];

    public function participants()
    {
        //return $this->hasMany(ConversationParticipant::class);
        // or if you used pivot table:
        // return $this->belongsToMany(User::class, 'conversation_participants', 'conversation_id', 'user_id');
        return $this->belongsToMany(User::class, 'conversation_participants', 'conversation_id', 'user_id')->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function unreadMessagesFor($userId)
    {
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


}
