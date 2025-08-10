<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id'                      => ['required', 'integer', 'exists:customers,id'],
            'business_name'           => ['required', 'string', 'max:255'],
            'business_structure'      => ['nullable', 'string', 'max:255'],
            'address_street'          => ['required', 'string', 'max:255'],
            'address_city'            => ['required', 'string', 'max:100'],
            // if you require two-letter US state codes use size:2
            'address_state'           => ['required', 'string', 'size:2'],
            'address_zipcode'         => ['required', 'regex:/^\d{5}(-\d{4})?$/'],
            // allow optional space after area code
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
            'collateral_documents'    => ['required', 'array'],
            'collateral_documents.*'  => ['file', 'mimes:pdf,jpeg,png,jpg', 'max:5120'], // 5MB
            'additional_information'  => ['nullable', 'string'],
            'agreement_checklist'     => ['accepted'],
            'customer_agreement'      => ['accepted'],
            'customer_full_name'      => ['required', "regex:/^[a-zA-Z'\\- ]+$/", 'max:100'],
            'guarantor_full_name'     => ['required', "regex:/^[a-zA-Z'\\- ]+$/", 'max:100'],
            'customer_signature'      => ['required'],
            'guarantor_signature'     => ['required'],
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
            'collateral_documents.required'     => 'Please upload collateral documents.',
            'collateral_documents.*.mimes'      => 'Allowed file types: pdf, jpeg, png, jpg.',
            'collateral_documents.*.max'        => 'Each document must be <= 5 MB.',
            'agreement_checklist.accepted'      => 'You must accept the agreement checklist.',
            'customer_agreement.accepted'       => 'Customer agreement must be accepted.',
            'customer_full_name.required'       => 'Customer full name is required.',
            'date_signed.before_or_equal'       => 'The signed date cannot be in the future.',
        ];
    }
}
?>