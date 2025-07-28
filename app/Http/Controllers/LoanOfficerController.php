<?php
namespace App\Http\Controllers;

use App\Services\LoanOfficerDashboardService;

class LoanOfficerController extends Controller
{
    public function LoanOfficerdashboard(LoanOfficerDashboardService $dashboard)
    {
        $grouped = $dashboard->getMyCustomersGroupedByStatus();

        return view('loan_officer.dashboard', compact('grouped'));
    }
}



?>