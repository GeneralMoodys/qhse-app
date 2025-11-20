<?php

namespace App\Livewire;

use App\Models\CorrectiveActionReport;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CarEdit extends Component
{
    public CorrectiveActionReport $car;

    // CAR fields
    public $number;
    public $source_of_information;
    public $issued_date;
    public $management_notes;
    public $status;

    // Dynamic actions
    public $actions = [];

    // User list for PIC dropdown
    public $users = [];

    public function rules()
    {
        return [
            'number' => ['required', 'string', Rule::unique('corrective_action_reports')->ignore($this->car->id)],
            'source_of_information' => 'required|in:internal,external',
            'issued_date' => 'required|date',
            'status' => 'required|in:open,closed,continued',
            'management_notes' => 'nullable|string',
            'actions' => 'required|array|min:1',
            'actions.*.description' => 'required|string',
            'actions.*.target_date' => 'required|date',
            'actions.*.pic_id' => 'required|exists:pgsql_master.users,id',
        ];
    }

    protected $messages = [
        'actions.required' => 'Setidaknya harus ada satu tindakan perbaikan.',
        'actions.*.description.required' => 'Deskripsi tindakan tidak boleh kosong.',
        'actions.*.target_date.required' => 'Target tanggal tidak boleh kosong.',
        'actions.*.pic_id.required' => 'P.I.C. tidak boleh kosong.',
    ];

    public function mount(CorrectiveActionReport $car, UserService $userService)
    {
        $this->car = $car->load('actions');
        $this->users = $userService->getAllUsers()->pluck('name', 'id');

        // Populate fields from existing CAR
        $this->number = $this->car->number;
        $this->source_of_information = $this->car->source_of_information;
        $this->issued_date = $this->car->issued_date->format('Y-m-d');
        $this->status = $this->car->status;
        $this->management_notes = $this->car->management_notes;

        foreach ($this->car->actions as $action) {
            $this->actions[] = [
                'id' => $action->id,
                'description' => $action->description,
                'target_date' => $action->due_date->format('Y-m-d'),
                'pic_id' => $action->pic_user_id,
            ];
        }
    }

    public function addAction()
    {
        $this->actions[] = ['id' => null, 'description' => '', 'target_date' => '', 'pic_id' => ''];
    }

    public function removeAction($index)
    {
        unset($this->actions[$index]);
        $this->actions = array_values($this->actions);
    }

    public function update()
    {
        $this->validate();

        DB::transaction(function () {
            $this->car->update([
                'number' => $this->number,
                'source_of_information' => $this->source_of_information,
                'issued_date' => $this->issued_date,
                'status' => $this->status,
                'management_notes' => $this->management_notes,
            ]);

            $existingActionIds = [];

            foreach ($this->actions as $actionData) {
                $action = $this->car->actions()->updateOrCreate(
                    ['id' => $actionData['id'] ?? null],
                    [
                        'description' => $actionData['description'],
                        'due_date' => $actionData['target_date'],
                        'pic_user_id' => $actionData['pic_id'],
                    ]
                );
                $existingActionIds[] = $action->id;
            }

            // Delete actions that were removed from the form
            $this->car->actions()->whereNotIn('id', $existingActionIds)->delete();
        });

        session()->flash('message', 'Corrective Action Report berhasil diperbarui.');
        return redirect()->route('cars.show', $this->car);
    }

    public function render()
    {
        return view('livewire.car-edit')->layout('layouts.app');
    }
}