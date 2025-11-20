<?php

namespace App\Livewire;

use App\Models\RootCauseAnalysis;
use Livewire\Component;
use Livewire\WithPagination;

class RcaList extends Component
{
    use WithPagination;

    public function render()
    {
        $rcas = RootCauseAnalysis::with('accident')->latest()->paginate(10);

        return view('livewire.rca-list', [
            'rcas' => $rcas,
        ])->layout('layouts.app');
    }
}
