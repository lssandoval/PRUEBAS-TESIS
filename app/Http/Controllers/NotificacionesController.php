<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificacionesController extends Controller
{
    /**
     * Muestra la vista de notificaciones.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('notificaciones');
    }
}
