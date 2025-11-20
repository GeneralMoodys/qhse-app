<?php

namespace App\Livewire;

use App\Models\Accident;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class AccidentCreate extends Component
{
    use WithFileUploads;

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
    public $photo_path; // For file upload

    protected $rules = [
        'nik' => 'required|string|exists:pgsql_master.users,nik',
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

    public function updatedNik($value, UserService $userService)
    {
        Log::info('updatedNik dipanggil dengan NIK: ' . $value);
        $user = $userService->findByNik($value);
        if ($user) {
            Log::info('Pengguna ditemukan: ' . $user->name);
            $this->employee_name = $user->name;
            $this->resetErrorBag('nik');
        } else {
            Log::info('Pengguna tidak ditemukan.');
            $this->employee_name = null;
            $this->addError('nik', 'NIK tidak ditemukan di database.');
        }
    }

    public function save()
    {
        $this->validate();

        $photoPath = null;
        if ($this->photo_path) {
            $photoPath = $this->photo_path->store('photos', 'public');
        }

        Accident::create([
            'user_id' => Auth::id(), // Reporter ID
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

        session()->flash('message', 'Laporan kecelakaan berhasil dibuat.');

        return redirect()->route('accidents.index');
    }

    public function render()
    {
        return view('livewire.accident-create')->layout('layouts.app');
    }
}
