<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Accident;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // KPI Cards Data
        $openIncidentsCount = Accident::doesntHave('rca')->count();
        $openActionsCount = Action::where('status', 'open')->count();
        $overdueActionsCount = Action::where('status', 'open')->where('due_date', '<', now())->count();

        // My Pending Actions Table Data
        $myPendingActions = Action::where('pic_user_id', Auth::id())
            ->where('status', 'open')
            ->with(['car.rootCauseAnalysis.accident', 'incident'])
            ->latest('due_date')
            ->get();

        // Chart 1: Action Status Breakdown
        $actionStatuses = Action::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
        $actionByStatusLabels = $actionStatuses->pluck('status')->map(fn($label) => ucfirst($label));
        $actionByStatusData = $actionStatuses->pluck('total');

        // Chart 2: Incidents per Month (Last 12 Months)
        $incidentsByMonth = Accident::select(
                \DB::raw("to_char(accident_date, 'YYYY-MM') as month"),
                \DB::raw('count(*) as total')
            )
            ->where('accident_date', '>=', now()->subYear())
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
        $incidentByMonthLabels = $incidentsByMonth->pluck('month');
        $incidentByMonthData = $incidentsByMonth->pluck('total');


        return view('dashboard', compact(
            'openIncidentsCount',
            'openActionsCount',
            'overdueActionsCount',
            'myPendingActions',
            'actionByStatusLabels',
            'actionByStatusData',
            'incidentByMonthLabels',
            'incidentByMonthData'
        ));
    }
}
