<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Nuevat;
use App\Models\Mantenimiento;

class RegistrarMantenimiento extends Component
{
    public $codigo_bien;
    public $tipo_mantenimiento;
    public $detalle_preventivo;
    public $observacion_mantenimiento;
    public $recomendacion_mantenimiento;
    public $fecha_mantenimiento;
    public $tecnico_mantenimiento;

    protected $listeners = ['setCodigoBien'];

    public function setCodigoBien($codigoBien)
    {
        $this->codigo_bien = $codigoBien;
    }

    public function guardarMantenimiento()
    {
        $this->validate([
            'codigo_bien' => 'required',
            'tipo_mantenimiento' => 'required',
            'observacion_mantenimiento' => 'required',
            'recomendacion_mantenimiento' => 'required',
            'fecha_mantenimiento' => 'required|date',
            'tecnico_mantenimiento' => 'required',
        ]);

        $id_nuevat = Nuevat::where('codigo_bien', $this->codigo_bien)->value('id');

        if (!$id_nuevat) {
            $this->addError('codigo_bien', 'El código de bien no existe.');
            return;
        }

        $ultimoMantenimiento = Mantenimiento::where('id_nuevat', $id_nuevat)->max('id_mantenimiento');
        $nuevoMantenimiento = $ultimoMantenimiento + 1;
        $numeroMantenimientoFormateado = sprintf("%03d", $nuevoMantenimiento);

        Mantenimiento::create([
            'id_mantenimiento' => $numeroMantenimientoFormateado,
            'id_nuevat' => $id_nuevat,
            'tipo_mantenimiento' => $this->tipo_mantenimiento,
            'observacion_mantenimiento' => $this->observacion_mantenimiento,
            'recomendacion_mantenimiento' => $this->recomendacion_mantenimiento,
            'fecha_mantenimiento' => $this->fecha_mantenimiento,
            'tecnico_mantenimiento' => $this->tecnico_mantenimiento,
        ]);

        $this->reset();
        $this->emit('mantenimientoGuardado');
        session()->flash('success', 'Mantenimiento registrado correctamente.');
    }

    public function render()
    {
        return view('livewire.registrar-mantenimiento');
    }
}
