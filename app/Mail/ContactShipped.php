<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactShipped extends Mailable
{
    use Queueable, SerializesModels;

    // ▼ ここにプロパティを追加
    public $contactData;

    /**
     * Create a new message instance.
     */
    public function __construct($contactData)
    {
        // ▼ データをプロパティに格納する
        $this->contactData = $contactData;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.contact');
    }
}