<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserSchedulingEmail extends Mailable
{
    use Queueable, SerializesModels;

    
    public $booked;

    public function __construct($booked)
    {
        $this->data = $booked;
    }

    public function build()
    {
        return $this->view('mail.user_email')
                    ->subject('Farmacie Stilo Milano')
                    ->with([
                        'data' => $this->data,
                    ]);
    }
}