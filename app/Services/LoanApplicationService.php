<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Address;
use App\Models\Business_info;
use App\Models\Collateral;
use App\Models\Guarantor;
use App\Models\LoanApplication;
use App\Models\LoanAccount;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class LoanApplicationService
{
    public function saveLoanApplication(array $data): LoanApplication
    {
        try {
            return DB::transaction(function () use ($data) {

                // 1) Load customer (fail if not found)
                /** @var \App\Models\Customer $customer */
                Customer::where('customer_id',$data['id'])->update(['status'=>'pending']);
                $customer = Customer::findOrFail($data['id']);

                // 2) Create business address
                /** @var \App\Models\Address $businessAddress */
                $businessAddress = Address::create([
                    'street'  => $data['address_street']     ?? null,
                    'city'    => $data['address_city']       ?? null,
                    'state'   => $data['address_state']      ?? null,
                    'zipcode' => $data['address_zipcode']    ?? null,
                ]);

                // 3) Create business info (note: Business_info likely has PK = business_id)
                /** @var \App\Models\Business_info $businessInfo */
                $businessInfo = $customer->businesses()->create([
                    'business_name'   => $data['business_name']        ?? null,
                    'legal_structure' => $data['business_structure']   ?? null,
                    'address_id'      => $businessAddress->address_id, // uses your key name
                    'phone'           => $data['phone']                ?? null,
                    'email'           => $data['email']                ?? null,
                ]);

                // 4) Create loan application
                /** @var \App\Models\LoanApplication $loanApplication */
                $loanApplication = $customer->applications()->create([
                    'requested_amount'        => $this->toDecimal($data['loan_amount'] ?? null),
                    'terms_months'            => (int)($data['repayment_term_months'] ?? 0),
                    'application_submit_date' => $data['date_signed'] ?? now()->toDateString(),
                    'notes'                   => $data['additional_information'] ?? null,
                    'status'                  => $customer->status ?? 'pending',
                    // If Business_info PK is business_id (common in your schema), use that
                    'business_id'             => $businessInfo->id,
                    'purpose'                 => $data['loan_purpose']       ?? null,
                    'frequency'               => $data['repayment_frequency'] ?? null,
                    'interest_rate'           => $this->toDecimal($data['interest_rate'] ?? null),
                    // You currently store raw data URLs; that’s fine if your DB column is LONGTEXT
                    'guarantor_signature'     => $data['guarantor_signature'] ?? null,
                    'customer_signature'      => $data['customer_signature']  ?? null,
                ]);

                // 5) Guarantor address + record
                /** @var \App\Models\Address $guarantorAddress */
                $guarantorAddress = Address::create([
                    'street'  => $data['guarantor_street'] ?? null,
                    'city'    => $data['guarantor_city']   ?? null,
                    'state'   => $data['guarantor_state']  ?? null,
                    'zipcode' => $data['guarantor_zip']    ?? null,
                ]);

                $customer->guarantors()->create([
                    'guarantor_name' => $data['guarantor_name']        ?? ($data['guarantor_full_name'] ?? null),
                    'relationship'   => $data['guarantor_relationship'] ?? null,
                    'phone'          => $data['guarantor_phone']        ?? null,
                    'email'          => $data['guarantor_email']        ?? null,
                    'address_id'     => $guarantorAddress->address_id,
                
                ]);

                // 6) Collateral (file optional)
                $documentPath = null;
                if (!empty($data['collateral_documents']) && $data['collateral_documents'] instanceof UploadedFile) {
                    /** @var UploadedFile $file */
                    $file        = $data['collateral_documents'];
                    // stores under storage/app/public/collateral_documents
                    $documentPath = $file->store('collateral_documents', 'public');
                } elseif (is_string($data['collateral_documents'] ?? null)) {
                    // If controller already stored the file and passed the path (recommended)
                    $documentPath = $data['collateral_documents'];
                }

                $loanApplication->collaterals()->create([
                    'collateral_type'    => $data['collateral_type']         ?? null,
                    'description'        => $data['collateral_description']  ?? null,
                    'estimated_value'    => $this->toDecimal($data['collateral_value'] ?? null),
                    'document_reference' => $documentPath, // may be null
                    'status'             =>$customer->status,
            
                ]);

                // Return with relationships if you like
                return $loanApplication->fresh();
            });
        } catch (Throwable $e) {
            Log::error('Failed saving loan application: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    /**
     * Normalize numeric strings like "76,567" -> 76567.00
     */
    private function toDecimal($value): ?float
    {
        if ($value === null || $value === '') return null;
        $clean = str_replace([',', ' '], '', (string)$value);
        return is_numeric($clean) ? (float)$clean : null;
    }


    /**
 * Retrieve comprehensive loan-related data for a given customer.
 *
 * This method returns multiple records associated with the customer:
 * - **Customer Info** (uses `first()`): only the first matching record of personal details.
 * - **Loan Info** (uses `firstOrFail()`): the loan application details or throws a 404 if none found.
 * - **Guarantor Info** (uses `get()`): possibly multiple guarantor records as a Collection.
 * - **Collateral Info** (uses `first()` or empty Collection): a single collateral record if it exists.
 *
 * The method returns an associative array with keys:
 * - 'customer'   => Customer|null
 * - 'loan'       => LoanApplication (throws 404 if not found)
 * - 'guarantor'  => \Illuminate\Support\Collection (of Guarantor models)
 * - 'collateral' => Collateral|null|\Illuminate\Support\Collection
 *
 * @param int $id  The unique identifier of the customer.
 *
 * @return array{
 *     customer:\App\Models\Customer|null,
 *     loan:\App\Models\LoanApplication,
 *     guarantor:\Illuminate\Support\Collection,
 *     collateral:\App\Models\Collateral|null|\Illuminate\Support\Collection
 * }
 *
 * @throws \Illuminate\Database\Eloquent\ModelNotFoundException  If no loan application is found.
 */
    public function sendLoanInfo($id):array
    {
        $customerInfo=Customer:: where('customer_id', $id)
                                ->firstOrFail(['first_name','last_name','phone','email']);

        $loanInfo=LoanApplication:: where('customer_id',$id)
                                ->firstOrFail(['application_id','requested_amount','terms_months','purpose']);
        $appId=$loanInfo->application_id;

        $guarantorInfo=Guarantor:: where('customer_id',$id)
                                ->firstOrFail(['guarantor_name','relationship','phone','email']);

        $collateralInfo=Collateral:: where('application_id',$appId)
                                ->firstOrFail(['collateral_type','description','estimated_value','document_reference']);
        
        return [
            'customer' =>$customerInfo,
            'loan'     =>$loanInfo,
            'guarantor'=>$guarantorInfo,
            'collateral'=>$collateralInfo,
        ];
    }

    public function creatLoanAccount($id):LoanAccount
    {   
        $customerstatus=Customer::where('customer_id', $id)->value('status');
        if($customerstatus === 'approved'){
            throw ValidationException::withMessages(['status'=>['Already approved !']]);
        }


        Customer::where('customer_id', $id)
                ->where('status','pending')
                ->update(['status'=>'approved']);
        return DB::transaction(function() use ($id) {

             $loan_app=LoanApplication::where('customer_id',$id)
                                                ->first(['requested_amount','terms_months','frequency','interest_rate']);

             // “start date = one month after created_at”
        $startDate = Carbon::parse($loan_app->created_at)
            ->addMonthNoOverflow()   // avoids 31st→next month overflow weirdness
            ->toDateString();

        // “end date = end of the term (in months) starting from startDate”
        $endDate = Carbon::parse($startDate)
            ->addMonthsNoOverflow((int) $loan_app->terms_months)
            ->subDay()               // end *of* the term window
            ->toDateString();

           return LoanAccount::create(['customer_id'=>$id,
                                'total_loan_given'=>$loan_app->requested_amount,
                                'duration'=>$loan_app->terms_months,
                                'start_date'=>$startDate,
                                'end_date'=>$endDate,
                                'status'=>'active',
                                'interest_rate'=>$loan_app->interest_rate,
                                ]);
});
    }
    public function associateLoanIdtoCustomer($loanAcc,$id){
        Customer::where('customer_id',$id)->update(['active_loan_account'=>$loanAcc->loan_id]);
    }
}
?>