<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Contact;

class ContactMe extends Mailable
{
    use Queueable, SerializesModels;
    public $contacts;
    /**
     * Create a new contact instance.
     *
     * @return void
     */
    public function __construct(Contact $contacts)
    {
        $this->contacts = $contacts;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        // Get admin emails from ..env file
        $to = explode(',', env('SCHOOL_EMAIL'));
        $bcc = explode(',', env('ADMIN_EMAIL'));

        return $this->from($this->contacts->email, $this->contacts->name)
                    ->to($to)
                    ->bcc($bcc)
                    ->subject($this->contacts->subject)
                    ->markdown('emails.contact-me');
    }
}
