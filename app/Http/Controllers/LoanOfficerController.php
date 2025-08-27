<?php
namespace App\Http\Controllers;

use App\Services\LoanOfficerService;
use App\Services\LoanApplicationService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class LoanOfficerController extends Controller
{
    public function LoanOfficerdashboard(LoanOfficerService $dashboard ,$status)
    {
        $grouped = $dashboard->getMyCustomersGroupedByStatus();
        if($status == 'new'){
                $new_customers = $grouped->get('new') ?? new Collection();
                return view('onlycustomerlist', ['customer' => $new_customers , 'status' =>'new']);
            }
            
        
        elseif($status == 'pending'){
                $pending_customers = $grouped->get('pending') ?? new Collection();
                return view('onlycustomerlist', ['customer' => $pending_customers , 'status' =>'pending']);
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


    // function for loading  new customers details after clicking the customer list from loan officer dashboard :
        public function customerdetails(LoanOfficerService $dashboard,$id){
        $customer=$dashboard->customerdetailsservice($id);
        return view('customerdetails', compact('customer'));
        }


    //function for loading pending customers loan application information after clicking the list from loan officer dashboard :
      public function customerLoanInformation(LoanApplicationService $appForm , $id){
        

        $sections=['CustomerInfo' => ['Customer Name', 'Customer Last Name','Customer Phone', 'Customer Email'],
                   'LoanInfo' => ['Application ID', 'Requested Amount','Terms-months','Purpose'],
                    'Guarantor'=>['Guarantor Name','Relationship','Guarantor Email', 'Guarantor Phone'],
                    'Collateral'=>['Collateral Type', 'Estimated Value','Description','Document']];

        //To connect blade table title to the retrieved table row from data base:
        $titleMap = [
        'CustomerInfo' => 'customer',
        'LoanInfo'     => 'loan',
        'Guarantor'    => 'guarantor',
        'Collateral'   => 'collateral',
        ];

        // label -> actual attribute key
        $fieldMap = [
        'Customer Name'        => 'first_name',
        'Customer Last Name'   => 'last_name',
        'Customer Phone'       => 'phone',
        'Customer Email'       => 'email',
        'Application ID'       => 'application_id',
        'Requested Amount'     => 'requested_amount',
        'Terms-months'       => 'terms_months',
        'Purpose'              => 'purpose',
        'Guarantor Name'       => 'guarantor_name',
        'Relationship'         => 'relationship',
        'Guarantor Phone'      => 'phone',
        'Guarantor Email'      => 'email',
        'Collateral Type'      => 'collateral_type',
        'Description'          => 'description',
        'Estimated Value'      => 'estimated_value',
        'Document'             => 'document_reference',
        ];

        $loanData=$appForm->sendLoanInfo($id);
        return view('customerLoanInformation',['sections'=>$sections,
                                                'titleMap'=>$titleMap,
                                                'fieldMap'=>$fieldMap,
                                                'loanData'=>$loanData,
                                                'customerId'=>$id,]);
      }  

    //function for changing customer status from pending to approved then create a loan account for that customer_id and return a pyament schedule view:
        public function approvedCustomer($id , LoanApplicationService $loanAccount){
            
            $loanAcc=$loanAccount-> creatLoanAccount($id);

             $loanAccount-> associateLoanIdtoCustomer($loanAcc,$id);

        }
}



?>