<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Address;
use App\Models\Business_info;
use App\Models\Collateral;
use App\Models\Guarantor;
use App\Models\LoanApplication;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class LoanApplicationService
{
    public function saveLoanApplication(array $data): LoanApplication
    {
        try {
            return DB::transaction(function () use ($data) {

                // 1) Load customer (fail if not found)
                /** @var \App\Models\Customer $customer */
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
                $businessInfo = Business_info::create([
                    'business_name'   => $data['business_name']        ?? null,
                    'legal_structure' => $data['business_structure']   ?? null,
                    'address_id'      => $businessAddress->address_id, // uses your key name
                    'customer_id'     => $customer->customer_id,
                    'phone'           => $data['phone']                ?? null,
                    'email'           => $data['email']                ?? null,
                ]);

                // 4) Create loan application
                /** @var \App\Models\LoanApplication $loanApplication */
                $loanApplication = LoanApplication::create([
                    'customer_id'             => $customer->customer_id,
                    'requested_amount'        => $this->toDecimal($data['loan_amount'] ?? null),
                    'terms_months'            => (int)($data['repayment_term_months'] ?? 0),
                    'application_submit_date' => $data['date_signed'] ?? now()->toDateString(),
                    'notes'                   => $data['additional_information'] ?? null,
                    'status'                  => $customer->status ?? 'pending',
                    // If Business_info PK is business_id (common in your schema), use that
                    'business_id'             => $businessInfo->business_id ?? $businessInfo->id,
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

                Guarantor::create([
                    'guarantor_name' => $data['guarantor_name']        ?? ($data['guarantor_full_name'] ?? null),
                    'relationship'   => $data['guarantor_relationship'] ?? null,
                    'phone'          => $data['guarantor_phone']        ?? null,
                    'email'          => $data['guarantor_email']        ?? null,
                    'address_id'     => $guarantorAddress->address_id,
                    'customer_id'    => $customer->customer_id,
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

                Collateral::create([
                    'collateral_type'    => $data['collateral_type']         ?? null,
                    'description'        => $data['collateral_description']  ?? null,
                    'estimated_value'    => $this->toDecimal($data['collateral_value'] ?? null),
                    'document_reference' => $documentPath, // may be null
                    'application_id'     => $loanApplication->application_id,
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
}
?>