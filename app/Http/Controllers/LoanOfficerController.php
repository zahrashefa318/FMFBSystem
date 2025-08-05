<?php
namespace App\Http\Controllers;

use App\Services\LoanOfficerService;


class LoanOfficerController extends Controller
{
    public function LoanOfficerdashboard(LoanOfficerService $dashboard)
    {
        $grouped = $dashboard->getMyCustomersGroupedByStatus();
        if ($grouped->has('new') ){
            $new_customers=$grouped->get('new');
             return view('onlycustomerlist', ['grouped' => $new_customers]);
        }
        return redirect()->back()->with('error', 'Invalid Id of staff!');

       
    }
    public function customerdetails($id ,  LoanOfficerService $dashboard){
        $customer=$dashboard->customerdetailsservice($id);
        return view('customerdetails', compact('customer'));
    }
}



?>