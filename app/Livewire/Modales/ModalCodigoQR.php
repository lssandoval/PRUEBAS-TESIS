<?php

namespace App\Livewire\Modales;

use Livewire\Component;

class ModalCodigoQR extends Component
{
    public $id;
    public $codigoBien;

    protected $listeners = ['openModalQR'];

    public function openModalQR($id, $codigoBien)
    {
        $this->id = $id;
        $this->codigoBien = $codigoBien;
        $this->dispatchBrowserEvent('showModalQR');
    }

    public function render()
    {
        return view('livewire.modales.modal-codigo-q-r', [
            'id' => $this->id,
            'codigoBien' => $this->codigoBien
        ]);
    }
}
