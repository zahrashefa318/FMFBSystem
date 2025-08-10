<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Address;
use App\Models\Business_info;
use App\Models\Collateral;
use App\Models\Guarantor;
use App\Models\LoanApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LoanApplicationService
{
    public function saveLoanApplication(array $data): LoanApplication
    {
        return DB::transaction(function () use ($data) {

            // load customer to access status and validate existence
            $customer = Customer::findOrFail($data['id']);

            // business address
            $businessAddress = Address::create([
                'street'  => $data['address_street'],
                'city'    => $data['address_city'],
                'state'   => $data['address_state'],
                'zipcode' => $data['address_zipcode'],
            ]);

            // business info
            $businessInfo = Business_info::create([
                'business_name'   => $data['business_name'],
                'legal_structure' => $data['business_structure'] ?? null,
                'address_id'      => $businessAddress->id, // adjust if PK name differs
                'customer_id'     => $customer->id,
                'phone'           => $data['phone'],
                'email'           => $data['email'] ?? null,
            ]);

            // loan application
            $loanApplication = LoanApplication::create([
                'customer_id'            => $customer->id,
                'requested_amount'       => $data['loan_amount'],
                'terms_months'           => $data['repayment_term_months'],
                'application_submit_date'=> $data['date_signed'],
                'notes'                  => $data['additional_information'] ?? null,
                'status'                 => $customer->status, // use loaded customer
                'business_id'            => $businessInfo->id,
                'purpose'                => $data['loan_purpose'],
                'frequency'              => $data['repayment_frequency'],
                'interest_rate'          => $data['interest_rate'] ?? null,
                'guarantor_signature'    => $data['guarantor_signature'],
                'customer_signature'     => $data['customer_signature'],
            ]);

            // guarantor address & record
            $guarantorAddress = Address::create([
                'street'  => $data['guarantor_street'],
                'city'    => $data['guarantor_city'],
                'state'   => $data['guarantor_state'],
                'zipcode' => $data['guarantor_zip'],
            ]);

            $loanGuarantor = Guarantor::create([
                'guarantor_name' => $data['guarantor_name'],
                'relationship'   => $data['guarantor_relationship'],
                'phone'          => $data['guarantor_phone'],
                'email'          => $data['guarantor_email'] ?? null,
                'address_id'     => $guarantorAddress->id,
                'customer_id'    => $customer->id,
            ]);

            // handle collateral documents (array of UploadedFile)
            if (!empty($data['collateral_documents']) && is_array($data['collateral_documents'])) {
                foreach ($data['collateral_documents'] as $file) {
                    // store file and create Collateral row pointing to path
                    $path = $file->store('collateral_documents'); // uses default disk
                    Collateral::create([
                        'collateral_type'     => $data['collateral_type'],
                        'description'         => $data['collateral_description'] ?? null,
                        'estimated_value'     => $data['collateral_value'],
                        'document_reference'  => $path,
                        'loan_application_id' => $loanApplication->id,
                    ]);
                }
            } else {
                // create at least one collateral record (no file)
                Collateral::create([
                    'collateral_type'     => $data['collateral_type'],
                    'description'         => $data['collateral_description'] ?? null,
                    'estimated_value'     => $data['collateral_value'],
                    'document_reference'  => null,
                    'application_id' => $loanApplication->id,
                ]);
            }

            return $loanApplication;
        }); // DB::transaction
    }
}
