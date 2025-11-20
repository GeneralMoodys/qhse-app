<?php

namespace App\Livewire;

use App\Models\CorrectiveActionReport;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\UserService;
use Illuminate\Support\Collection;

class CarList extends Component
{
    use WithPagination;

    public function render(UserService $userService)
    {
        // Fetch CARs with their related RCA for efficiency
        $cars = CorrectiveActionReport::with('rootCauseAnalysis')->latest()->paginate(10);

        // Get all unique user IDs (issued_by) from the CARs
        $userIds = $cars->pluck('issued_by')->unique()->filter()->toArray();

        // Fetch all users in a single call
        if (!empty($userIds)) {
            $users = $userService->findByIds($userIds);

            // Manually assign users to CARs
            $cars->each(function ($car) use ($users) {
                if ($user = $users->get($car->issued_by)) {
                    // Set the issuer_data attribute which the accessor will use
                    $car->setAttribute('issuer_data', $user);
                }
            });
        }

        return view('livewire.car-list', [
            'cars' => $cars,
        ])->layout('layouts.app');
    }

    public function updateStatus(int $carId, string $newStatus)
    {
        $car = CorrectiveActionReport::findOrFail($carId);

        // Validate the new status
        $validStatuses = ['open', 'closed', 'continued'];
        if (!in_array($newStatus, $validStatuses)) {
            session()->flash('error', 'Status tidak valid.');
            return;
        }

        $car->status = $newStatus;
        $car->save(); // This will trigger the observer

        session()->flash('message', 'Status CAR berhasil diperbarui.');
    }
}
