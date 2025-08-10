<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class LoanApplicationFormController extends Controller
{   
    protected LoanApplicationService $loanService;

    public function __construct(LoanApplicationService $loanService){
        $this->loanService = $loanService;
    }
    public function viewLoanApplicationForm(Request $req)
    {  $id=$req->query('id');
         Customer::where('customer_id',$id)->update(['status'=>'pending']);
        return view('loanApplicationForm',['id'=>$id]);
    }

    public function submitForm( loanApplicationRequest $req  ){
        $data=$req->validated();
        $this->loanService->saveLoanApplication($data);
        return redirect()->back()->with('success', 'Data saved!');

        



        
    }
}
?>