<?php
namespace App\Http\Controllers;

use App\Services\LoanOfficerService;

class LoanOfficerController extends Controller
{
    public function LoanOfficerdashboard(LoanOfficerService $dashboard)
    {
        $grouped = $dashboard->getMyCustomersGroupedByStatus();
        if ($grouped != null){
             return view('onlycustomerlist', ['grouped' => $grouped]);
        }
        return redirect()->back()->with('error', 'Invalid Id of staff!');

       
    }
}



?>