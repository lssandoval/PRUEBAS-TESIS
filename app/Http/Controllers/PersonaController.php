<?php

namespace App\Http\Controllers;


use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    public function index()
    {
        // Obtén todas las personas con sus áreas asociadas
        $personas = Persona::with('areas')->get();

        // Pasa los datos a la vista
        return view('personas.index', compact('personas'));
    }
}
