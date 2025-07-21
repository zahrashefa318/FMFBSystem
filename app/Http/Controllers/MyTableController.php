<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Log; 

class MyTableController extends Controller
{
   
  public function search_ssn( string $ssn):bool{

   return DB::table('customer_tbl')->where('social_security_num',$ssn)->exists();
  
   }
}
?>