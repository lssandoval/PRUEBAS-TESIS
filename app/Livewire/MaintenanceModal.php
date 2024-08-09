<?php

namespace App\Livewire;

use App\Models\Mantenimiento;
use App\Models\Nuevat;
use Livewire\Attributes\On;
use Livewire\Component;

class MaintenanceModal extends Component
{
    public $isOpen = false;
    public $codigoBien, $tipoBien, $usoBien, $custodioBien, $horaInicio, $horaFin, $tecnicoAsignado, $selectedDate;
    public $tecnicos = ['Leonardo', 'Dalton'];
    public $nuevat; // Lista de Nuevats
    public $selectedNuevatId; // ID del Nuevat seleccionado

    public function mount($date = null)
    {
        $this->selectedDate = $date;
        $this->nuevat = Nuevat::all(); // Obtén todos los registros de Nuevat
    }

    #[On("openModal")]
    public function openModal($date, $nuevatId = null)
    {
        $this->selectedDate = $date;
        $this->isOpen = true;
        $this->dispatch('openModalMantenimientos', date: $date);
        // Puedes usar $date para mostrar la fecha en el modal si es necesario
        if ($nuevatId) {
            $this->loadNuevatData($nuevatId);
        }
    }
    #[On("closeModal")]
    public function closeModal()
    {
        $this->isOpen = false;
        $this->dispatch('close-modal');
    }

    public function dateSelected($date)
    {
        // Manejar la fecha seleccionada si es necesario
    }

    #[On("save")]
    public function save()
    {
        $this->validate([
            'codigoBien' => 'required|string|max:255',
            'tipoBien' => 'required|string|max:255',
            'usoBien' => 'required|string|max:255',
            'custodioBien' => 'required|string|max:255',
            'horaInicio' => 'required',
            'horaFin' => 'required',
            'tecnicoAsignado' => 'required|string|max:255',
            'selectedNuevatId' => 'required|exists:nuevat,id', // Validación del ID de Nuevat
            'selectedDate' => 'required|date' // Validación de la fecha
        ]);

        Mantenimiento::create([
            'codigo_bien' => $this->codigoBien,
            'tipo_bien' => $this->tipoBien,
            'uso_bien' => $this->usoBien,
            'custodio_bien' => $this->custodioBien,
            'fecha_mantenimiento' => $this->selectedDate, // Utiliza la fecha seleccionada
            'hora_inicio' => $this->horaInicio,
            'hora_fin' => $this->horaFin,
            'tecnico_asignado' => $this->tecnicoAsignado,
            'id_nuevat' => $this->selectedNuevatId, // Usa el ID seleccionado
        ]);

        $this->resetInputFields();
        $this->closeModal();
    }

    private function resetInputFields()
    {
        $this->codigoBien = '';
        $this->tipoBien = '';
        $this->usoBien = '';
        $this->custodioBien = '';
        $this->horaInicio = '';
        $this->horaFin = '';
        $this->tecnicoAsignado = '';
        $this->selectedNuevatId = null;
    }

    public function updatedSelectedNuevatId($value)
    {
        if ($value) {
            $this->loadNuevatData($value);
        } else {
            $this->resetInputFields();
        }
    }

    private function loadNuevatData($id)
    {
        $nuevat = Nuevat::find($id);
        if ($nuevat) {
            $this->codigoBien = $nuevat->codigo_bien;
            $this->tipoBien = $nuevat->tipo;
            $this->usoBien = $nuevat->en_uso;
            $this->custodioBien = $nuevat->custodio_identificado;
        }
    }


    public function render()
    {
        return view('livewire.maintenance-modal');
    }
}
