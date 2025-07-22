<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;  // Allow request through; 
    }

    public function rules(): array
    {
        return [
            'firstName'         => ['required', 'string', 'regex:/^[A-Za-zÀ-ÖØ-öø-ÿ\' -]{2,30}$/'],
            'lastName'          => ['required', 'string', 'regex:/^[A-Za-zÀ-ÖØ-öø-ÿ\' -]{2,30}$/'],
            'email'             => ['required', 'email', 'unique:users,email'],
            'phone'             => ['required', 'regex:/^\(\d{3}\) \d{3}-\d{4}$/'],
            'businessPhone'     => ['required', 'regex:/^\(\d{3}\) \d{3}-\d{4}$/'],
            'ssn'               => ['required', 'regex:/^\d{3}-\d{2}-\d{4}$/'],
            'businessType'      => ['required', 'string', 'regex:/^[A-Za-z\s,&-]+$/'],
            'timeInBusiness'    => ['required', 'integer', 'min:0'],
            'addrStreet'        => ['required', 'string', 'max:255'],
            'addrCity'          => ['required', 'string', 'max:100'],
            'addrState'         => ['required', 'string', 'size:2'],
            'zipcode'           => ['required', 'regex:/^\d{5}(?:-\d{4})?$/'],
            'registrationDate'  => ['required', 'date', 'before_or_equal:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'firstName.regex'        => 'First name must be 2–30 letters, spaces, hyphens, or apostrophes.',
            'lastName.regex'         => 'Last name must be 2–30 letters, spaces, hyphens, or apostrophes.',
            'email.email'            => 'Enter a valid email address.',
            'email.unique'           => 'This email is already registered.',
            'phone.digits'           => 'Phone must be exactly 10 digits.',
            'businessPhone.digits'   => 'Business phone must be exactly 10 digits.',
            'ssn.regex'              => 'SSN must follow the format 123-45-6789.',
            'timeInBusiness.integer' => 'Time in business must be an integer.',
            'timeInBusiness.min'     => 'Time in business cannot be negative.',
            'addrStreet.required'    => 'Street address is required.',
            'addrCity.required'      => 'City is required.',
            'addrState.size'         => 'State must be a two-letter code.',
            'zipcode.regex'          => 'ZIP must be in 12345 or 12345-6789 format.',
            'registrationDate.date'  => 'Registration date must be a valid date.',
            'registrationDate.before_or_equal' => 'Registration date cannot be in the future.',
        ];
    }
}
