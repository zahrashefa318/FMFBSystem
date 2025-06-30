<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  

class MyTableController extends Controller
{
   
   public function save(Request $req){
      $ssn=$req->input('ssn');
      $existed_ssn=DB::table('customer_tbl')->where('social_security_num',$ssn);
      if($existed_ssn){
        return redirect()->back()->withInput()->with('error','Frequent patron');
      }

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
    
    $inserted=DB::table('customer_tbl')->insert($data);
    if($inserted){
      return redirect()->route('dashboard')->with('success','Data saved!');
    }
    
    
    return redirect()->back()->withInput()->with('error','An error occured during saving data!');
    
    

   }
   
}
?>