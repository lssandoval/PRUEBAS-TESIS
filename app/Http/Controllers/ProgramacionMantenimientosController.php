<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use Illuminate\Http\Request;
use Livewire\Attributes\On;

class ProgramacionMantenimientosController extends Controller
{
    public function index()
    {
        // Aquí puedes obtener datos de la base de datos si es necesario
        // $mantenimientos = Mantenimiento::all();
        $mantenimientos = Mantenimiento::all();
        return view('programacion_mantenimientos', compact('mantenimientos'));
    }

    #[On("openModalMantenimientos")]
    public function openModal($date)
    {
        dump("entro");
        // Puedes usar $date para mostrar la fecha en el modal si es necesario
    }

}
