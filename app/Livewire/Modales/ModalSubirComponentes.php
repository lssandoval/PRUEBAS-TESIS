<?php

namespace App\Livewire\Modales;

use Livewire\Component;

class ModalSubirComponentes extends Component
{
    public $isOpen = false;

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.modales.modal-subir-componentes');
    }
}
