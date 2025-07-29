<?php
namespace App\Http\Controllers;

use App\Services\LoanOfficerDashboardService;

class LoanOfficerController extends Controller
{
    public function LoanOfficerdashboard(LoanOfficerDashboardService $dashboard)
    {
        $grouped = $dashboard->getMyCustomersGroupedByStatus();
        if ($grouped != null){
             return view('loanofficerdashboard', ['grouped' => $grouped]);
        }
        return redirect()->back()->with('error', 'Invalid Id of staff!');

       
    }
}



?>