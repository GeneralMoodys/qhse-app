<?php

namespace App\Livewire;

use App\Models\Accident;
use Livewire\Component;

class AccidentShow extends Component
{
    public Accident $accident;

    public function mount(Accident $accident)
    {
        $this->accident = $accident;
    }

    public function render()
    {
        return view('livewire.accident-show')->layout('layouts.app');
    }
}
