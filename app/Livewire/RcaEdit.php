<?php

namespace App\Livewire;

use App\Models\RootCauseAnalysis;
use Livewire\Component;

class RcaEdit extends Component
{
    public RootCauseAnalysis $rca;

    // Form properties
    public $analysis_method;
    public $root_cause_summary;
    public $root_cause_category;
    public $is_human_factor;
    public $is_equipment_factor;
    public $is_material_factor;
    public $is_method_factor;
    public $is_environment_factor;

    protected $rules = [
        'analysis_method' => 'nullable|string|max:255',
        'root_cause_summary' => 'required|string',
        'root_cause_category' => 'nullable|string|max:255',
        'is_human_factor' => 'boolean',
        'is_equipment_factor' => 'boolean',
        'is_material_factor' => 'boolean',
        'is_method_factor' => 'boolean',
        'is_environment_factor' => 'boolean',
    ];

    public function mount(RootCauseAnalysis $rca)
    {
        $this->rca = $rca;
        $this->analysis_method = $rca->analysis_method;
        $this->root_cause_summary = $rca->root_cause_summary;
        $this->root_cause_category = $rca->root_cause_category;
        $this->is_human_factor = $rca->is_human_factor;
        $this->is_equipment_factor = $rca->is_equipment_factor;
        $this->is_material_factor = $rca->is_material_factor;
        $this->is_method_factor = $rca->is_method_factor;
        $this->is_environment_factor = $rca->is_environment_factor;
    }

    public function update()
    {
        $this->validate();

        $this->rca->update([
            'analysis_method' => $this->analysis_method,
            'root_cause_summary' => $this->root_cause_summary,
            'root_cause_category' => $this->root_cause_category,
            'is_human_factor' => $this->is_human_factor,
            'is_equipment_factor' => $this->is_equipment_factor,
            'is_material_factor' => $this->is_material_factor,
            'is_method_factor' => $this->is_method_factor,
            'is_environment_factor' => $this->is_environment_factor,
        ]);

        session()->flash('message', 'RCA berhasil diperbarui.');

        return redirect()->route('rca.show', $this->rca);
    }

    public function render()
    {
        return view('livewire.rca-edit')->layout('layouts.app');
    }
}
