<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy
{
    use HandlesAuthorization;

    public function access(User $user, Conversation $conversation)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        // if using pivot table
        return $conversation->participants()->where('user_id', $user->id)->exists();
    }
}
