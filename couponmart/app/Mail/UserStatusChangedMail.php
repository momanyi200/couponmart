<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserStatusChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(UserProfile $profile, $isBlacklisting, $reason)
    {
        $this->profile = $profile;
        $this->isBlacklisting = $isBlacklisting;
        $this->reason = $reason;
    }

    public function build()
    {
        return $this->subject('Your Account Status Has Changed')
            ->view('emails.user-status-changed');
    }

}
