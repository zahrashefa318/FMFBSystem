<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class LoanApplicationFormController extends Controller
{
    public function viewLoanApplicationForm(Request $req)
    {  $id=$req->query('id');
         Customer::where('customer_id',$id)->update(['status'=>'pending']);
        return view('loanApplicationForm');
    }
}
?>