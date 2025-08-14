<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class loanApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normalize inputs before validation.
     */
    protected function prepareForValidation(): void
    {
        $merge = [];

        // Uppercase 2-letter states if present
        foreach (['address_state', 'guarantor_state'] as $st) {
            if ($this->filled($st)) {
                $merge[$st] = strtoupper(trim((string)$this->input($st)));
            }
        }

        // Strip commas/spaces from numeric-like strings
        foreach (['loan_amount', 'collateral_value', 'interest_rate'] as $num) {
            if ($this->filled($num)) {
                $merge[$num] = preg_replace('/[,\s]/', '', (string)$this->input($num));
            }
        }

        // Trim common strings
        foreach ([
            'business_name','business_structure','address_street','address_city',
            'guarantor_name','guarantor_relationship','guarantor_street','guarantor_city',
            'customer_full_name','guarantor_full_name','loan_purpose','repayment_frequency'
        ] as $key) {
            if ($this->filled($key)) {
                $merge[$key] = trim((string)$this->input($key));
            }
        }

        $this->merge($merge);
    }

    public function rules(): array
    {
        return [
            'id'                      => ['required', 'integer', 'exists:customer_tbl,customer_id'],

            'business_name'           => ['required', 'string', 'max:255'],
            'business_structure'      => ['nullable', 'string', 'max:255'],

            'address_street'          => ['required', 'string', 'max:255'],
            'address_city'            => ['required', 'string', 'max:100'],
            'address_state'           => ['required', 'string', 'size:2'],
            'address_zipcode'         => ['required', 'regex:/^\d{5}(-\d{4})?$/'],

            'phone'                   => ['required', 'regex:/^\(\d{3}\)\s?\d{3}-\d{4}$/'],
            'email'                   => ['nullable', 'email', 'max:255'],

            'loan_amount'             => ['required', 'numeric', 'min:1'],
            'loan_purpose'            => ['required', 'string', 'in:Equipment,Marketing,WorkingCapital,CapacityExpansion,Other'],
            'repayment_term_months'   => ['required', 'integer', 'min:1'],
            'repayment_frequency'     => ['required', 'string', 'in:Monthly,Quarterly,Annually'],
            'interest_rate'           => ['nullable', 'numeric', 'min:0'],

            'guarantor_name'          => ['required', 'string', 'max:255'],
            'guarantor_relationship'  => ['required', 'string', 'max:255'],
            'guarantor_street'        => ['required', 'string', 'max:255'],
            'guarantor_city'          => ['required', 'string', 'max:100'],
            'guarantor_state'         => ['required', 'string', 'size:2'],
            'guarantor_zip'           => ['required', 'regex:/^\d{5}(-\d{4})?$/'],
            'guarantor_phone'         => ['required', 'regex:/^\(\d{3}\)\s?\d{3}-\d{4}$/'],
            'guarantor_email'         => ['nullable', 'email', 'max:255'],

            'collateral_type'         => ['required', 'string', 'max:255'],
            'collateral_value'        => ['required', 'numeric', 'min:0'],
            'collateral_description'  => ['nullable', 'string'],

            // SINGLE file (matches your controller & service)
            'collateral_documents'    => ['nullable','file', 'mimes:pdf,jpeg,png,jpg', 'max:5120'],

            'additional_information'  => ['nullable', 'string'],

            'agreement_checklist_one'   => ['accepted'],
            'agreement_checklist_two'   => ['accepted'],
            'agreement_checklist_three' => ['accepted'],

            'customer_agreement_one'    => ['accepted'],
            'customer_agreement_two'    => ['accepted'],
            'customer_agreement_three'  => ['accepted'],

            // Note: this only allows basic Latin letters; remove/relax if you need diacritics or other alphabets
            'customer_full_name'      => ['required', "regex:/^[a-zA-Z'\\- ]+$/", 'max:100'],
            'guarantor_full_name'     => ['required', "regex:/^[a-zA-Z'\\- ]+$/", 'max:100'],

            // Base64 data URLs for signatures (service stores them directly; ensure LONGTEXT columns)
            'customer_signature'      => ['required', 'string'],
            'guarantor_signature'     => ['required', 'string'],

            'date_signed'             => ['required', 'date', 'before_or_equal:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'address_street.required'           => 'Street address is required.',
            'address_city.required'             => 'City is required.',
            'address_state.size'                => 'State must be a two-letter code.',
            'address_zipcode.required'          => 'ZIP code is required.',
            'address_zipcode.regex'             => 'ZIP code must be 5 digits or ZIP+4.',

            'phone.required'                    => 'Phone number is required.',
            'phone.regex'                       => 'Phone must be in the format (123) 456-7890 or (123)456-7890.',

            'email.email'                       => 'Enter a valid email address.',

            // Correct field name (singular key was wrong before)
            'collateral_documents.file'         => 'The collateral document must be a valid file.',
            'collateral_documents.mimes'        => 'Allowed file types: pdf, jpeg, png, jpg.',
            'collateral_documents.max'          => 'The document must be no larger than 5 MB.',

            'agreement_checklist_one.accepted'   => 'You must accept agreement checklist item 1.',
            'agreement_checklist_two.accepted'   => 'You must accept agreement checklist item 2.',
            'agreement_checklist_three.accepted' => 'You must accept agreement checklist item 3.',

            'customer_agreement_one.accepted'   => 'You must accept customer agreement item 1.',
            'customer_agreement_two.accepted'   => 'You must accept customer agreement item 2.',
            'customer_agreement_three.accepted' => 'You must accept customer agreement item 3.',

            'customer_full_name.required'       => 'Customer full name is required.',
            'guarantor_full_name.required'      => 'Guarantor full name is required.',

            'date_signed.before_or_equal'       => 'The signed date cannot be in the future.',
        ];
    }
}
