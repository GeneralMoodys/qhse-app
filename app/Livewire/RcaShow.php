<?php

namespace App\Livewire;

use App\Models\RootCauseAnalysis;
use Livewire\Component;

class RcaShow extends Component
{
    public RootCauseAnalysis $rca;

    public function mount(RootCauseAnalysis $rca)
    {
        $this->rca = $rca;
    }

    public function render()
    {
        return view('livewire.rca-show')->layout('layouts.app');
    }
}
