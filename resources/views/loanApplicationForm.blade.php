{{-- resources/views/loanApplicationForm.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf‑8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Business Loan Application</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #fff;
      margin: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      color: #fff;
    }
    .dashboard-container {
      background-color: #341539;
      padding: 1.5rem;
      border-radius: 0.5rem;
      max-width: 800px;
      width: 100%;
      display: flex;
      flex-direction: column;
    }
    .container-header {
      text-align: center;
      margin-bottom: 1.5rem;
      font-size: 1.25rem;
      font-weight: 600;
      color: #fff;
    }

    /* Uniform label + input sizing */
    .form-label {
      width: 180px;
      min-width: 180px;
      white-space: nowrap;
      text-align: left;
    }
    .form-control,
    .form-select {
      min-height: 2.45rem; /* matches label's approx height */
    }

    fieldset {
      border: 1px solid rgba(255,255,255,0.4);
      border-radius: 4px;
      padding: 1rem;
      margin-bottom: 1.25rem;
    }
    legend {
      color: #fff;
      font-weight: bold;
      padding: 0 0.5rem;
    }
    label, .form-label, .form-check-label, fieldset legend {
      color: #fff;
    }

    .column-pair {
      display: flex;
      gap: 1rem;
    }
    .column-pair > div {
      flex: 1;
    }

    .btn-row { text-align: center; margin-top: auto; }
    .btn-theme {
      background: transparent;
      color: #fff;
      border: 1px solid rgba(255,255,255,0.7);
      margin: 0.25rem;
    }
    .btn-theme:hover {
      background: rgba(255,255,255,0.9);
      color: #341539;
    }
  </style>
</head>
<body>
  <div class="header-container">
    <h1>Business Loan Application</h1>
  </div>

  <div class="dashboard-wrapper">
    <div class="dashboard-container">
      <div class="container-header">
        Please complete the form below
      </div>

      <form action="#" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <fieldset>
          <legend>1. Applicant &amp; Business Information</legend>

          <div class="mb-3 row align-items-center">
            <label for="business_name" class="form-label">Business Name *</label>
            <input type="text" id="business_name" name="business_name"
                   class="form-control col ms-3"
                   required value="{{ old('business_name') }}">
          </div>

          <div class="mb-3 row align-items-center">
            <label for="business_structure" class="form-label">Legal Structure</label>
            <input type="text" id="business_structure" name="business_structure"
                   class="form-control col ms-3" placeholder="e.g. LLC"
                   value="{{ old('business_structure') }}">
          </div>

          {{-- Business Address including label --}}
          <div class="mb-3 row">
            <label class="form-label">Business Address *</label>
            <div class="col ms-3">
              <div class="row g-2">
                <div class="col-md-6"><input type="text" name="address_street" id="address_street"
                  class="form-control" placeholder="Street" required
                  value="{{ old('address_street') }}"></div>
                <div class="col-md-3"><input type="text" name="address_city" id="address_city"
                  class="form-control" placeholder="City" required
                  value="{{ old('address_city') }}"></div>
                <div class="col-md-2"><input type="text" name="address_zipcode" id="address_zipcode"
                  class="form-control" placeholder="Zip" required
                  value="{{ old('address_zipcode') }}"></div>
                <div class="col-md-1"><input type="text" name="address_state" id="address_state"
                  class="form-control" placeholder="State" required
                  value="{{ old('address_state') }}"></div>
              </div>
            </div>
          </div>

          <div class="mb-3 row align-items-center">
            <label for="phone" class="form-label">Phone Number *</label>
            <input type="tel" id="phone" name="phone" class="form-control col ms-3"
                   required value="{{ old('phone') }}">
          </div>

          <div class="mb-3 row align-items-center">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" id="email" name="email" class="form-control col ms-3"
                   value="{{ old('email') }}">
          </div>
        </fieldset>

        <fieldset>
          <legend>2. Loan Request Details</legend>
          <div class="mb-3 row align-items-center">
            <label for="loan_amount" class="form-label">Loan Amount *</label>
            <input type="number" step="0.01" id="loan_amount" name="loan_amount"
                   class="form-control col ms-3" required
                   value="{{ old('loan_amount') }}">
          </div>

          <div class="mb-3 row align-items-center">
            <label for="loan_purpose" class="form-label">Purpose *</label>

            <select id="loan_purpose" name="loan_purpose"
                    class="form-select col ms-3" required>
              <option value="">– Select –</option>
              @foreach(['Equipment','Marketing','WorkingCapital','CapacityExpansion','Other'] as $option)
                @php
                  $label = match ($option) {
                    'Equipment'         => 'Equipment Purchase',
                    'Marketing'         => 'Marketing & Advertising',
                    'WorkingCapital'    => 'Working Capital',
                    'CapacityExpansion' => 'Capacity Expansion',
                    'Other'             => 'Other…',
                    default             => "$option Purchase",
                  };
                @endphp
                <option value="{{ $option }}"
                  {{ old('loan_purpose') === $option ? 'selected' : '' }}>
                  {{ $label }}
                </option>
              @endforeach
            </select>
            <input type="text" id="loan_purpose_other" name="loan_purpose_other"
                   class="form-control ms-3 mt-2 col"
                   placeholder="If ‘Other’, please describe"
                   value="{{ old('loan_purpose_other') }}">
          </div>

          <div class="row mb-3 align-items-center">
            <label for="repayment_term_months" class="form-label">Term (months) *</label>
            <input type="number" id="repayment_term_months" name="repayment_term_months"
                   class="form-control col ms-3" placeholder="e.g. 12" required
                   value="{{ old('repayment_term_months') }}">

            <label for="repayment_frequency" class="form-label ms-4">Frequency *</label>
            <select id="repayment_frequency" name="repayment_frequency"
                    class="form-select col ms-3" required>
              @foreach(['Monthly','Quarterly','Annually'] as $freq)
                <option value="{{ $freq }}"
                  {{ old('repayment_frequency') === $freq ? 'selected' : '' }}>
                  {{ $freq }}
                </option>
              @endforeach
            </select>

            <label for="interest_rate" class="form-label ms-4">Interest (%)</label>
            <input type="number" step="0.01" id="interest_rate" name="interest_rate"
                   class="form-control col ms-3" placeholder="10.5"
                   value="{{ old('interest_rate') }}">
          </div>
        </fieldset>

        {{-- Continue with sections 3, 4, 5 as before, adjusting label/field rows similarly... --}}
        {{-- Final submit button --}}
        <div class="btn-row">
          <button type="submit" class="btn btn-theme w-100">Submit Application</button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
