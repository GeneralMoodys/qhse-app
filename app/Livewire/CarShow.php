<?php

namespace App\Livewire;

use App\Models\CorrectiveActionReport;
use App\Services\UserService;
use Livewire\Component;

class CarShow extends Component
{
    public CorrectiveActionReport $car;

    public function mount(CorrectiveActionReport $car, UserService $userService)
    {
        $this->car = $car->load('rootCauseAnalysis.accident', 'actions');

        // Eager load user data for the main CAR object
        $this->car->issuer;
        $this->car->mrApprover;
        $this->car->directorApprover;

        // Eager load user data for all associated actions
        $picIds = $this->car->actions->pluck('responsible_user_id')->unique()->filter()->toArray();
        $verifiedByIds = $this->car->actions->pluck('verified_by')->unique()->filter()->toArray();
        $allUserIds = array_unique(array_merge($picIds, $verifiedByIds));

        if (!empty($allUserIds)) {
            $users = $userService->findByIds($allUserIds);

            $this->car->actions->each(function ($action) use ($users) {
                if ($pic = $users->get($action->responsible_user_id)) {
                    $action->setAttribute('pic_data', $pic);
                }
                if ($verifier = $users->get($action->verified_by)) {
                    $action->setAttribute('verifier_data', $verifier);
                }
            });
        }
    }

    public function render()
    {
        return view('livewire.car-show')->layout('layouts.app');
    }
}