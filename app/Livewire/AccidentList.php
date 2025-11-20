<?php

namespace App\Livewire;

use App\Models\Accident;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\UserService; // Import UserService
use Illuminate\Support\Collection; // Import Collection

class AccidentList extends Component
{
    use WithPagination;

    public function render(UserService $userService) // Inject UserService
    {
        $accidents = Accident::latest()->paginate(10);

        // Get all unique user IDs from the accidents
        $userIds = $accidents->pluck('user_id')->unique()->toArray();

        // Fetch all users in a single call using UserService
        $users = $userService->findByIds($userIds);

        // Manually assign users to accidents to prevent N+1 queries
        $accidents->each(function ($accident) use ($users) {
            if ($user = $users->get($accident->user_id)) {
                // Set the user_data attribute which the accessor will use
                $accident->setAttribute('user_data', $user);
            }
        });

        return view('livewire.accident-list', [
            'accidents' => $accidents,
        ])->layout('layouts.app');
    }
}
