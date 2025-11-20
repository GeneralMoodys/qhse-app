<?php

namespace App\Livewire;

use App\Models\Accident;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class AccidentEdit extends Component
{
    use WithFileUploads;

    public Accident $accident;

    public $nik;
    public $employee_name;
    public $division;
    public $location;
    public $accident_date;
    public $description;
    public $initial_action;
    public $consequence;

    // New detailed columns
    public $employee_age_group;
    public $equipment_type;
    public $accident_time_range;
    public $financial_loss;
    public $injured_body_parts = []; // For checkboxes
    public $accident_types = []; // For checkboxes
    public $lost_work_days;
    public $photo_path; // For new file upload
    public $current_photo_path; // To display existing photo

    protected $rules = [
        'nik' => 'required|string|exists:users,nik',
        'employee_name' => 'required|string',
        'division' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'accident_date' => 'required|date',
        'description' => 'required|string',
        'initial_action' => 'nullable|string',
        'consequence' => 'nullable|string',

        // Validation for new detailed columns
        'employee_age_group' => 'nullable|string|max:255',
        'equipment_type' => 'nullable|string|max:255',
        'accident_time_range' => 'nullable|string|max:255',
        'financial_loss' => 'nullable|numeric|min:0',
        'injured_body_parts' => 'nullable|array',
        'accident_types' => 'nullable|array',
        'lost_work_days' => 'nullable|integer|min:0',
        'photo_path' => 'nullable|image|max:1024', // Max 1MB
    ];

    public function mount(Accident $accident)
    {
        $this->accident = $accident;
        $this->nik = User::find($accident->user_id)->nik ?? null; // Assuming user_id is the reporter
        $this->employee_name = $accident->employee_name;
        $this->division = $accident->division;
        $this->location = $accident->location;
        $this->accident_date = $accident->accident_date->format('Y-m-d');
        $this->description = $accident->description;
        $this->initial_action = $accident->initial_action;
        $this->consequence = $accident->consequence;

        // Populate new detailed columns
        $this->employee_age_group = $accident->employee_age_group;
        $this->equipment_type = $accident->equipment_type;
        $this->accident_time_range = $accident->accident_time_range;
        $this->financial_loss = $accident->financial_loss;
        $this->injured_body_parts = $accident->injured_body_parts ?? [];
        $this->accident_types = $accident->accident_types ?? [];
        $this->lost_work_days = $accident->lost_work_days;
        $this->current_photo_path = $accident->photo_path; // Store current photo path
    }

    public function updatedNik($value)
    {
        $user = User::where('nik', $value)->first();
        if ($user) {
            $this->employee_name = $user->name;
            $this->resetErrorBag('nik');
        } else {
            $this->employee_name = null;
            $this->addError('nik', 'NIK tidak ditemukan di database.');
        }
    }

    public function update()
    {
        $this->validate();

        $photoPath = $this->current_photo_path; // Keep existing photo by default
        if ($this->photo_path) {
            if ($this->current_photo_path) {
                Storage::disk('public')->delete($this->current_photo_path); // Delete old photo
            }
            $photoPath = $this->photo_path->store('photos', 'public');
        }

        $this->accident->update([
            'user_id' => User::where('nik', $this->nik)->first()->id, // Update reporter ID based on NIK
            'employee_name' => $this->employee_name,
            'division' => $this->division,
            'location' => $this->location,
            'accident_date' => $this->accident_date,
            'description' => $this->description,
            'initial_action' => $this->initial_action,
            'consequence' => $this->consequence,

            // New detailed columns
            'employee_age_group' => $this->employee_age_group,
            'equipment_type' => $this->equipment_type,
            'accident_time_range' => $this->accident_time_range,
            'financial_loss' => $this->financial_loss,
            'injured_body_parts' => $this->injured_body_parts,
            'accident_types' => $this->accident_types,
            'lost_work_days' => $this->lost_work_days,
            'photo_path' => $photoPath,
        ]);

        session()->flash('message', 'Laporan kecelakaan berhasil diperbarui.');

        return redirect()->route('accidents.show', $this->accident);
    }

    public function render()
    {
        return view('livewire.accident-edit')->layout('layouts.app');
    }
}
