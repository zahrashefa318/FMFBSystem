<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Requests\loanApplicationRequest;
use App\Services\LoanApplicationService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use App\Models\LoanApplication;
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

  public function submitForm(loanApplicationRequest $request) 
    {
        Log::debug('submitForm HIT', ['req' => (string) Str::uuid()]);
        // Validated payload from your FormRequest
        $data = $request->validated();
        Log::debug('validated payload', $data);
        if (empty($data)) {
                 Log::warning('validated payload is EMPTY — validation likely failed.');

            }
        // Ensure a date exists (service also defaults, but this keeps data explicit)
        $data['date_signed'] = $data['date_signed'] ?? now()->toDateString();
       
        // If a file is present, store it now and pass the saved path to the service.
        // This saves from temp and gives you a stable path. Requires: php artisan storage:link
        if ($request->hasFile('collateral_documents')) {
            $data['collateral_documents'] = $request->file('collateral_documents')
                                                   ->store('collateral_documents', 'public'); // e.g. "collateral_documents/abc123.pdf"
        }
         else {
            // Make sure the key exists even if no file uploaded (service tolerates null)
            $data['collateral_documents'] = $data['collateral_documents'] ?? null;
        }

            $loanApp = $this->loanService->saveLoanApplication($data);
            if($loanApp){
                     return redirect()
                    ->back()
                    ->with('success', 'Application submitted!');
        }

            return back()
                ->withInput()
                ->with('error', 'We encountered an issue submitting your loan application. Please try again or contact support.');
        }
    }

?>