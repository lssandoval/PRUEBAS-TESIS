<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Nuevat;

class BienesComponent extends Component
{
    public function render()
    {
        return view('livewire.bienes-component');
    }

    public function loadBienes()
    {
        return Nuevat::all();
    }
}
