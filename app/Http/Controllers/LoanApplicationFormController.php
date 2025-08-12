<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Requests\loanApplicationRequest;
use App\Services\LoanApplicationService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
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

   public function submitForm(loanApplicationRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('collateral_documents')) {
            $data['collateral_documents'] = $request->file('collateral_documents');
        }

        try {
            $loanApp = $this->loanService->saveLoanApplication($data);

            return back()->with('success', 'Application submitted! ID: ' . $loanApp->application_id);
        } catch (\Throwable $e) {
            Log::error('Error in controller submitForm: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'We encountered an issue submitting your loan application. Please try again or contact support.');
        }

    }
}
?>