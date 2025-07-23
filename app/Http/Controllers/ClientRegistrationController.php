<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRegistrationRequest;
use App\Http\Controllers\MyTableController;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class ClientRegistrationController extends Controller
{ 
    public function store(ClientRegistrationRequest $request){
        $validatedData=$request->validated();
        $tableController=new MyTableController;

        $ssn=$validatedData['ssn'];
        $existed=$tableController->search_ssn($ssn);

        if ($existed) {
            return redirect()->back()->withInput()->with('error', 'Frequent patron');
        }

    //try{
        $zipcode=$validatedData['zipcode'];
        $configStaff=config('filterByzip');
        $branch_id=null;
        $loanOfficer=null;
        foreach($configStaff['branches'] as $id =>[$min,$max]){
            if($zipcode >= $min && $zipcode <= $max){
                $branch_id=$id;
                $user=$configStaff['loanOfficerPerBranch'][$id];
                $loanOfficer=$user[(int)$zipcode % count($user)];
                break;
            }
        }
         if (!$branch_id) {
            return back()->withErrors(['zipcode' => 'No branch found for that ZIP code']);
        }

        DB::beginTransaction(); // Start transaction
        
         
         $address=Address::create([
            'street'=>$validatedData['addrStreet'],
            'city'=>$validatedData['addrCity'],
            'state'=>$validatedData['addrState'],
            'zipcode'=>$validatedData['zipcode'],
          ]);

        

         $customer=Customer::create([
          'first_name'=>$validatedData['firstName'],
          'last_name'=>$validatedData['lastName'],
          'social_security_num'=>$validatedData['ssn'],
          'phone'=>$validatedData['phone'],
          'email'=>$validatedData['email'],
          'type_of_business'=>$validatedData['businessType'],
          'time_in_business'=>$validatedData['timeInBusiness'],
          'business_phone'=>$validatedData['businessPhone'],
          'registrationdate'=>$validatedData['registrationDate'],
          'status'=>'new',
          'branch_id'=>$branch_id,
          'staff_username'=>$loanOfficer,
          'address_id'=> $address->address_id,
          ]);
          
          
         

          DB::commit(); // Commit transaction

        return redirect()->route('dashboard')->with('success','Data saved!');
        //}
       // catch(\Illuminate\Database\QueryException $e)
       // {
        //  \Log::error('Insert failed: ' . $e->getMessage());
         // return redirect()->back()->withInput()->with('error','An error occured during saving data!');
          
       // } 
}
}