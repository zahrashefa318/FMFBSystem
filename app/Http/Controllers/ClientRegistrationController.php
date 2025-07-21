<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRegistrationRequest;
use App\Http\Controllers\MyTableController;
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

    try{
        $hartford    = ['06001','06010','06103','06033'];
        $fairfield   = ['06801','06810','06830','06850'];
        $new_haven   = ['06511','06401','06437'];
        $new_london  = ['06340','06355','06371'];
        $litchfield  = ['06701','06226','06269'];

        
        DB::beginTransaction(); // Start transaction
        $branch_id=0;
        $zipcode=$validatedData['zipcode'];
        if ($zipcode >= '06001' && $zipcode <= '06103') {
                $branch_id = 1;
            } elseif ($zipcode >= '06801' && $zipcode <= '06850') {
                $branch_id = 2;
            } elseif ($zipcode >= '06401' && $zipcode <= '06511') {
                $branch_id = 3;
            } elseif ($zipcode >= '06340' && $zipcode <= '06371') {
                $branch_id = 4;
            } elseif ($zipcode >= '06226' && $zipcode <= '06701') {
                $branch_id = 5;
            } else {
                return redirect()->back()
                                ->withInput()
                                ->with('error', 'The zipcode does not belong to Connecticut!');
            }
         
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
          'address_id'            => $address->id,
          ]);
          
          
         

          DB::commit(); // Commit transaction

        return redirect()->route('dashboard')->with('success','Data saved!');
        }
        catch(\Illuminate\Database\QueryException $e)
        {
          \Log::error('Insert failed: ' . $e->getMessage());
          return redirect()->back()->withInput()->with('error','An error occured during saving data!');
          
        } 
}
}