<?php

namespace App\Observers;

use App\Models\CorrectiveActionReport;

class CorrectiveActionReportObserver
{
    /**
     * Handle the CorrectiveActionReport "created" event.
     */
    public function created(CorrectiveActionReport $correctiveActionReport): void
    {
        //
    }

    /**
     * Handle the CorrectiveActionReport "updated" event.
     */
    public function updated(CorrectiveActionReport $correctiveActionReport): void
    {
        // If status was changed...
        if ($correctiveActionReport->wasChanged('status')) {
            // Scenario 1: CAR is closed or continued, so we close its open actions.
            if (in_array($correctiveActionReport->status, ['closed', 'continued'])) {
                $correctiveActionReport->actions()->where('status', 'open')->update(['status' => 'closed']);
            }
            // Scenario 2: CAR is re-opened, so we re-open its closed actions.
            elseif ($correctiveActionReport->status === 'open') {
                $correctiveActionReport->actions()->where('status', 'closed')->update(['status' => 'open']);
            }
        }
    }

    /**
     * Handle the CorrectiveActionReport "deleted" event.
     */
    public function deleted(CorrectiveActionReport $correctiveActionReport): void
    {
        //
    }

    /**
     * Handle the CorrectiveActionReport "restored" event.
     */
    public function restored(CorrectiveActionReport $correctiveActionReport): void
    {
        //
    }

    /**
     * Handle the CorrectiveActionReport "force deleted" event.
     */
    public function forceDeleted(CorrectiveActionReport $correctiveActionReport): void
    {
        //
    }
}