<?php
namespace App\Services;

use App\Models\Customer;
use App\Models\Address;
use App\Models\Business_info;
use App\Models\Collateral;
use App\Models\Guarantor;
use App\Models\LoanApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class LoanApplicationService
{
    public function saveLoanApplication(array $data): LoanApplication
    {
        try {
            return DB::transaction(function () use ($data) {
                $customer = Customer::findOrFail($data['id']);

                $businessAddress = Address::create([
                    'street'  => $data['address_street'],
                    'city'    => $data['address_city'],
                    'state'   => $data['address_state'],
                    'zipcode' => $data['address_zipcode'],
                ]);

                $businessInfo = Business_info::create([
                    'business_name'   => $data['business_name'],
                    'legal_structure' => $data['business_structure'] ?? null,
                    'address_id'      => $businessAddress->address_id,
                    'customer_id'     => $customer->customer_id,
                    'phone'           => $data['phone'],
                    'email'           => $data['email'] ?? null,
                ]);

                $loanApplication = LoanApplication::create([
                    'customer_id'             => $customer->customer_id,
                    'requested_amount'        => $data['loan_amount'],
                    'terms_months'            => $data['repayment_term_months'],
                    'application_submit_date' => $data['date_signed'],
                    'notes'                   => $data['additional_information'] ?? null,
                    'status'                  => $customer->status,
                    'business_id'             => $businessInfo->id,
                    'purpose'                 => $data['loan_purpose'],
                    'frequency'               => $data['repayment_frequency'],
                    'interest_rate'           => $data['interest_rate'] ?? null,
                    'guarantor_signature'     => $data['guarantor_signature'],
                    'customer_signature'      => $data['customer_signature'],
                ]);

                $guarantorAddress = Address::create([
                    'street'  => $data['guarantor_street'],
                    'city'    => $data['guarantor_city'],
                    'state'   => $data['guarantor_state'],
                    'zipcode' => $data['guarantor_zip'],
                ]);

                Guarantor::create([
                    'guarantor_name' => $data['guarantor_name'],
                    'relationship'   => $data['guarantor_relationship'],
                    'phone'          => $data['guarantor_phone'],
                    'email'          => $data['guarantor_email'] ?? null,
                    'address_id'     => $guarantorAddress->address_id,
                    'customer_id'    => $customer->customer_id,
                ]);

                if (!empty($data['collateral_documents']) && is_array($data['collateral_documents'])) {
                    foreach ($data['collateral_documents'] as $file) {
                        $path = $file->store('collateral_documents');

                        Collateral::create([
                            'collateral_type'    => $data['collateral_type'],
                            'description'        => $data['collateral_description'] ?? null,
                            'estimated_value'    => $data['collateral_value'],
                            'document_reference' => $path,
                            'application_id'     => $loanApplication->application_id,
                        ]);
                    }
                } else {
                    Collateral::create([
                        'collateral_type'    => $data['collateral_type'],
                        'description'        => $data['collateral_description'] ?? null,
                        'estimated_value'    => $data['collateral_value'],
                        'document_reference' => null,
                        'application_id'     => $loanApplication->application_id,
                    ]);
                }

                return $loanApplication;
            });
        } catch (Throwable $e) {
            Log::error('Failed saving loan application: ' . $e->getMessage());
            throw $e;
        }
    }
}
?>