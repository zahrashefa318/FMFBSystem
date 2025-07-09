<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Log; 

class MyTableController extends Controller
{
   
   public function save(Request $req){
    $ssn=$req->input('ssn');
     $existed = DB::table('customer_tbl')
    ->where('social_security_num', $ssn)
    ->exists(); // returns a boolean

    if ($existed) {
        return redirect()->back()->withInput()->with('error', 'Frequent patron');}

    $data=[
          'first_name'=>$req->input('firstName'),
          'last_name'=>$req->input('lastName'),
          'social_security_num'=>$req->input('ssn'),
          'phone'=>$req->input('phone'),
          'email'=>$req->input('email'),
          'type_of_business'=>$req->input('businessType'),
          'time_in_Business'=>$req->input('timeInBusiness'),
          'business_address'=>$req->input('businessAddress'),
          'zip_code'=>$req->input('zipcode'),
          'business_phone'=>$req->input('businessPhone'),
          'registrationdate'=>$req->input('registrationDate'),
          'status'=>'new',
          ];

    if (strlen($data['social_security_num']) != 11) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'The Social Security number must be exactly 11 characters.');
    }
        
    try{
        DB::table('customer_tbl')->insert($data);
        return redirect()->route('dashboard')->with('success','Data saved!');
        }
        catch(\Illuminate\Database\QueryException $e)
        {
          \Log::error('Insert failed: ' . $e->getMessage());
          return redirect()->back()->withInput()->with('error','An error occured during saving data!');
          
        } 

   }
   public function search_ssn(Request $req){
    $ssn= $req->input('ssn');
    $existed=DB::table('customer_tbl')->where('social_security_num',$ssn)->exists();
    if($existed){
      $customerInfo=DB::table('customer_tbl')->where('social_security_num',$ssn)->select('first_name','last_name','registrationdate','status')->first();
      return redirect()->route('dashboard')->with('customerInfo',$customerInfo);
    }
    else{
    return redirect()->back()->withInput()->with('message', 'No customer found with that SSN.');
    }
   }
}
?>