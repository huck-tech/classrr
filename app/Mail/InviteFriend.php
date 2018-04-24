<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteFriend extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $sender;

    /**
     * Create a new message instance.
     * @param User $sender
     */
    public function __construct(User $sender)
    {
        $this->sender = $sender;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Create subject
        $subject = $this->sender->pretty_name() .' has invited you to join Classrr';

        // User view to send mail
        return $this->subject($subject)
            ->view('emails.invite-friend');
    }
}
