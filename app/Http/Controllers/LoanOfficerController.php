<?php
namespace App\Http\Controllers;

use App\Services\LoanOfficerService;
use Illuminate\Database\Eloquent\Collection;


class LoanOfficerController extends Controller
{
    public function LoanOfficerdashboard(LoanOfficerService $dashboard ,$status)
    {
        $grouped = $dashboard->getMyCustomersGroupedByStatus();
        if($status == 'new'){
                $new_customers = $grouped->get('new') ?? new Collection();
                return view('onlycustomerlist', ['customer' => $new_customers]);
            }
            
        
        elseif($status == 'pending'){
            if ($grouped->has('pending') ){
                $pending_customers=$grouped->get('pending');
                return view('onlycustomerlist', ['customer' => $pending_customers]);
            }
        }
        elseif($status =='approved'){
            if ($grouped->has('approved') ){
                $approved_customers=$grouped->get('approved');
                return view('onlycustomerlist', ['customer' => $approved_customers]);
            }
        }
        elseif($status == 'denied'){
            if ($grouped->has('denied') ){
                $denied_customers=$grouped->get('denied');
                return view('onlycustomerlist', ['customer' => $denied_customers]);
        }
    }
        return redirect()->back()->with('error', 'Invalid Id of staff!');
       

       
    }
    public function customerdetails($id ,  LoanOfficerService $dashboard){
        $customer=$dashboard->customerdetailsservice($id);
        return view('customerdetails', compact('customer'));
    }
}



?>