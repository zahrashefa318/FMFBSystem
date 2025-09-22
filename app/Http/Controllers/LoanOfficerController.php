<?php
namespace App\Http\Controllers;

use App\Services\LoanOfficerService;
use App\Services\LoanApplicationService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoanScheduleMailable;
use App\Models\LoanAccount;   
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;   




class LoanOfficerController extends Controller
{
 public function LoanOfficerdashboard(LoanOfficerService $dashboard, string $status)
{
    $status = strtolower(trim($status));

    // valid statuses
    $valid = ['new','pending','approved','denied'];
    if (!in_array($status, $valid, true)) {
        return view('onlycustomerlist', ['customer' => collect(), 'status' => $status]);
    }

    $grouped = $dashboard->getMyCustomersGroupedByStatus();
    return view('onlycustomerlist', [
        'customer' => $grouped->get($status, collect()), // default: empty collection
        'status'   => $status,
    ]);
}



       

       
    


    // function for loading  new customers details after clicking the customer list from loan officer dashboard :
        public function customerdetails(LoanOfficerService $dashboard,$id){
        $showButtons = true;
        $customer=$dashboard->customerdetailsservice($id);
        return view('customerdetails', compact('customer', 'showButtons'));
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

    //function for changing customer status from pending to approved(in loan application service class) then create a loan account for that customer_id and return a pyament schedule view:
        public function approvedCustomer($id , LoanApplicationService $loanAccount){

          try{  
            $loanAcc=$loanAccount-> creatLoanAccount($id);

            $loanAccount-> associateLoanIdtoCustomer($loanAcc,$id);

            // Build schedule once, keep a fixed monthly value for display
        [$schedule, $paymentFixed] = $this->buildSchedule($loanAcc);

        return view('schedulePage', [
            'loanAcc'        => $loanAcc,
            'monthlyPayment' => $paymentFixed, // constant monthly figure
            'schedule'       => $schedule,
        ]);
        }
        catch(\Illuminate\Validation\ValidationException $e){
            return back()->withErrors($e->errors())->withInput();
        }
        }


    //function for sending the payment schedule to approved customer via email :
        public function emailSchedule(LoanAccount $loan){
            // Find approved customer for this loan
            $cust = Customer::where('customer_id', $loan->customer_id)
                ->first(['first_name','email','status']);

            if (!$cust || $cust->status !== 'approved') {
                return back()->with('error', 'Customer not approved or not found.');
            }

            // Build schedule + fixed payment
            [$schedule, $paymentFixed] = $this->buildSchedule($loan);

            // Send
            Mail::to($cust->email)->send(
                new LoanScheduleMailable($loan, $schedule, $paymentFixed)
            ); // Facade + Mailable pattern per docs. :contentReference[oaicite:4]{index=4}

            return redirect()
                ->back()
                ->with('status', 'Schedule emailed to ' . $cust->email);
                }

        /** DRY helper to build amortization schedule and return [schedule, paymentFixed] */
    private function buildSchedule(LoanAccount $loan): array
    {
        $P = (float) $loan->total_loan_given;
        $annualRate = (float) $loan->interest_rate;  // e.g. 12 for 12%
        $r = $annualRate / 100 / 12;                 // monthly rate
        $n = (int) $loan->duration;                  // months
        $startDate = Carbon::parse($loan->start_date);

        // Monthly payment (fixed)
        $paymentFixed = $r > 0
            ? $P * ($r * pow(1 + $r, $n)) / (pow(1 + $r, $n) - 1)
            : $P / $n;
        $paymentFixed = round($paymentFixed, 2);

        $schedule = [];
        $balance  = $P;

        for ($i = 1; $i <= $n; $i++) {
            $date      = $startDate->copy()->addMonthsNoOverflow($i - 1)->toDateString();
            $interest  = round($balance * $r, 2);
            $principal = round($paymentFixed - $interest, 2);

            if ($i === $n) {
                // Final row clears the balance; actual paid may differ by a few cents
                $principal      = $balance;
                $paymentActual  = round($interest + $principal, 2);
                $balance        = 0.0;
            } else {
                $paymentActual  = $paymentFixed;
                $balance        = round($balance - $principal, 2);
            }

            $schedule[] = [
                'payment_no' => $i,
                'date'       => $date,
                'payment'    => $paymentActual,   // what actually gets paid that row
                'interest'   => $interest,
                'principal'  => $principal,
                'balance'    => $balance,
            ];
        }

        return [$schedule, $paymentFixed];
    }



    //function for deleting customers from loan officer's dashboard.
    
public function customerdestroy($id, LoanOfficerService $customerlist)
{
    try {
        $customerlist->deleteCustomer($id);
        return response()->json([
            'ok' => true,
            'message' => "Customer #$id deleted successfully"
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'ok' => false,
            'message' => "Failed to delete customer #$id",
            'error' => $e->getMessage()
        ], 500);
    }
}
// function for searching customer in loan officer dashboard:
        public function search_customer_for_loanofficer(Request $req , MyTableController $search,LoanOfficerService $dashboard1){
            $showButtons = false;
            $customer=null;
            $ssn=$req->input('ssn2');
            $customerexists=$search->search_ssn($ssn);
            if ($customerexists){
                $customer=$dashboard1->customerdetailsserviceBySSN($ssn);
                 return view('customerdetails', compact('customer', 'showButtons'));
            }
            return redirect()->route('dashboard')->with('error', 'No such customer');
                        
        }

// function for changing customer status from pending to denied :
    public function deny($id){
       $affected = Customer::where('customer_id',$id)
                 ->where('status', 'pending')
                 ->update(['status'=>'denied']);
         return redirect()->route('dashboard')->with(
        $affected ? 'success' : 'error',
        $affected ? 'Customer has been denied successfully!' : 'No changes made (already denied or approved).'
         );
    }

    public function DeniedApprovedDetail(LoanOfficerService $dashboard2, $id){
            $showButtons = false;
            $customer=null;
            $customer=$dashboard2->customerdetailsservice($id);
                 return view('customerdetails', compact('customer', 'showButtons'));
            
    }

    // ------------Function for Editing customer detail-----------
    public function edit(Request $req, Customer $customer)
{
    
    $data = $req->validate([
        'first_name' => 'required|string|max:100',
        'last_name'  => 'required|string|max:100',
        'phone'      => 'nullable|string|max:30',
        'email'      => 'nullable|email',
        'type_of_business' => 'nullable|string|max:120',
        'time_in_business' => 'nullable|string|max:50',
        'business_phone'   => 'nullable|string|max:30',
        'status'     => 'required|string|in:new,pending,approved,denied',
        'address.street'  => 'nullable|string|max:150',
        'address.city'    => 'nullable|string|max:80',
        'address.state'   => 'nullable|string|max:30',
        'address.zipcode' => 'nullable|string|max:20',
    ]);  // request validation, standard Laravel. 

    // Track customer changes
    $customer->fill($data); // do not save yet
    $customerChanged = $customer->isDirty(); // true if any filled attribute differs. 

    // Track address changes (if you allow editing it here)
    $addressChanged = false;
    if (array_key_exists('address', $data)) {
        // Clone current or make a temp instance to compare
        $addr = $customer->address ?: new Address();
        $addr->fill($data['address'] ?? []);
        $addressChanged = $addr->isDirty(); // true if edited. 
    }

    if (! $customerChanged && ! $addressChanged) {
        // Nothing changed: flash + back to same page
        return back()->with('warning', 'Nothing changed.')->withInput(); // flash message. 
    }

    // Persist actual changes
    $customer->save(); // only runs UPDATE if dirty.

    if ($addressChanged) {
        $customer->address()->updateOrCreate(
            ['address_id' => optional($customer->address)->address_id],
            $data['address']
        ); // upsert address cleanly. 
    }

    return back()->with('success', 'Customer updated successfully.');
}

}     

 


?>