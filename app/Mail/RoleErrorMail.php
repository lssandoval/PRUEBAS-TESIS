<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RoleErrorMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $roles;
    public $date;

    public function __construct($userName)
    {
        $this->userName = $userName;
    }

    public function build()
    {
        return $this->view('emails.role_error')
            ->with([
                'userName' => $this->userName,
            ]);
    }
}
