<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RoleAsignadoMailAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $roles;
    public $date;

    public function __construct($userName, $roles, $date)
    {
        $this->userName = $userName;
        // Asegúrate de que roles sea un array
        $this->roles = is_array($roles) ? $roles : explode(',', $roles);
        $this->date = $date;
    }

    public function build()
    {
        return $this->view('emails.role_asignado_admin')
            ->subject('SGBT - Asignación Perfil')
            ->with([
                'userName' => $this->userName,
                'roles' => $this->roles,
                'date' => $this->date,
            ]);
    }
}
