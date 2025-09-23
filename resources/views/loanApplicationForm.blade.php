<!DOCTYPE html>
<html lang="eng">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Loan Application Form</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* Reset */
    * { margin: 0; padding: 0; box-sizing: border-box; }

    /* Body & wrapper */
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
      padding: 20px;
    }
    form {
      background-color: #341539;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 900px;
      color: #fff;
    }
    h1 { text-align: center; margin-bottom: 20px; }

    /* Main grid for other fields */
    .grid-container {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      margin-bottom: 20px;
    }
    .grid-item { display: flex; flex-direction: column; }
    label { font-size: .9rem; margin-bottom: 5px; }
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="number"],
    input[type="date"],
    select,
    textarea {
      width: 100%;
      padding: 8px;
      font-size: .95rem;
      border: 1px solid #ccc;
      border-radius: 4px;
      background: #f9f9f9;
      color: #333;
    }

    /* --- Signature row: keep 3 items side-by-side --- */
    .signature-row {
      display: flex;
      flex-wrap: nowrap;     /* force one line */
      gap: 20px;
      align-items: stretch;
      overflow-x: auto;      /* enable horizontal scroll if too narrow */
      -webkit-overflow-scrolling: touch;
    }
    .signature-box,
    .date-box {
      flex: 0 0 33.333%;     /* 3 equal columns */
      min-width: 340px;      /* keep usable width on small screens */
    }
    .signature-box { border: 2px solid purple; border-radius: 6px; padding: 10px; background: rgba(255,255,255,0.05); }
    .date-box      { padding: 10px; }

    .signature-canvas {
      width: 100%;
      height: 220px;         /* visual height; adjust as desired */
      background: #fff;
      border: 2px solid purple;
      border-radius: 4px;
      display: block;
    }

    /* Sticky actions */
    .button-row {
      position: sticky; bottom: 0;
      display: flex; justify-content: center; gap: 20px;
      padding: 12px 0; background: #341539; z-index: 1;
    }
    .action-btn {
      background-color: #5e2a84; color: #fff; border: none;
      padding: 10px 20px; font-size: 1rem; line-height: 1.2;
      border-radius: 4px; cursor: pointer; transition: background-color .2s;
      display: inline-flex; align-items: center; text-decoration: none;
    }
    .action-btn:hover { background-color: #4a1f6d; }
    .no-underline, .no-underline:visited, .no-underline:hover, .no-underline:active { text-decoration: none; }

    /* Print */
    @media print {
      #printButton, .button-row { display: none !important; }
      html, body { zoom: 70%; }
      @page { size: auto; margin: 1cm; }
    }

    /* Responsive grid for other fields */
    @media (max-width: 1200px) { .grid-container { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 900px)  { .grid-container { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px)  { .grid-container { grid-template-columns: 1fr; } }
  </style>
</head>
<body>

  <form action="{{ url('submitForm') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <h1>Loan Application Form</h1>
    <input type="hidden" name="id" value="{{ $id }}">

    @foreach (['success', 'error', 'warning', 'info'] as $msg)
      @if (session()->has($msg))
        <div class="alert alert-{{ $msg === 'error' ? 'danger' : $msg }} alert-dismissible fade show" role="alert">
          {{ session($msg) }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
    @endforeach

    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Please check the errors below:</strong>
        <ul>
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <!-- Business Information (keep your existing fields) -->
    <div class="grid-container">
      <div class="grid-item">
        <label for="business_name">Business Name *</label>
        <input type="text" id="business_name" name="business_name" class="name-field" data-label="business name" required>
      </div>
      <div class="grid-item">
        <label for="business_structure">Legal Structure</label>
        <input type="text" id="business_structure" name="business_structure">
      </div>
      <div class="grid-item">
        <label for="address_street">Street Address *</label>
        <input type="text" id="address_street" name="address_street" required>
      </div>
      <div class="grid-item">
        <label for="address_city">City *</label>
        <input type="text" id="address_city" name="address_city" required>
      </div>
      <div class="grid-item">
        <label for="address_state">State *</label>
        <input type="text" id="address_state" name="address_state" required>
      </div>
      <div class="grid-item">
        <label for="address_zipcode">Zip Code *</label>
        <input type="text" id="address_zipcode" name="address_zipcode" class="zip-field" inputmode="numeric" pattern="\d{5}" maxlength="5" required>
      </div>
      <div class="grid-item">
        <label for="phone">Phone Number *</label>
        <input type="tel" id="phone" name="phone" class="phone-field" inputmode="tel" required>
      </div>
      <div class="grid-item">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" class="email-field" inputmode="email">
      </div>
      <div class="grid-item">
        <label for="loan_amount">Loan Amount *</label>
        <input type="number" id="loan_amount" name="loan_amount" inputmode="numeric" pattern="\d+" required>
      </div>
      <div class="grid-item">
        <label for="loan_purpose">Purpose *</label>
        <select id="loan_purpose" name="loan_purpose" required>
          <option value="">Select</option>
          <option value="Equipment">Equipment Purchase</option>
          <option value="Marketing">Marketing & Advertising</option>
          <option value="WorkingCapital">Working Capital</option>
          <option value="CapacityExpansion">Capacity Expansion</option>
          <option value="Other">Other</option>
        </select>
      </div>
      <div class="grid-item">
        <label for="repayment_term_months">Term (months) *</label>
        <input type="number" id="repayment_term_months" name="repayment_term_months" inputmode="number" required>
      </div>
      <div class="grid-item">
        <label for="repayment_frequency">Frequency *</label>
        <select id="repayment_frequency" name="repayment_frequency" required>
          <option value="Monthly">Monthly</option>
          <option value="Quarterly">Quarterly</option>
          <option value="Annually">Annually</option>
        </select>
      </div>
      <div class="grid-item">
        <label for="interest_rate">Interest Rate (%)</label>
        <input type="number" id="interest_rate" name="interest_rate" min="0" max="9.9999" step="0.5" inputmode="decimal"/>
                
      </div>
    </div>

    <!-- Guarantor Information (keep your existing fields) -->
    <div class="grid-container">
      <div class="grid-item">
        <label for="guarantor_name">Guarantor Full Name *</label>
        <input type="text" id="guarantor_name" name="guarantor_name" class="name-field" data-label="guarantor name" required>
      </div>
      <div class="grid-item">
        <label for="guarantor_street">Guarantor Street Address *</label>
        <input type="text" id="guarantor_street" name="guarantor_street" required>
      </div>
      <div class="grid-item">
        <label for="guarantor_city">Guarantor City *</label>
        <input type="text" id="guarantor_city" name="guarantor_city" required>
      </div>
      <div class="grid-item">
        <label for="guarantor_state">Guarantor State *</label>
        <input type="text" id="guarantor_state" name="guarantor_state" required>
      </div>
      <div class="grid-item">
        <label for="guarantor_zip">Guarantor Zip Code *</label>
        <input type="text" id="guarantor_zip" name="guarantor_zip" class="zip-field" inputmode="numeric" required>
      </div>
      <div class="grid-item">
        <label for="guarantor_phone">Guarantor Phone *</label>
        <input type="tel" id="guarantor_phone" name="guarantor_phone" class="phone-field" inputmode="tel" required>
      </div>
      <div class="grid-item">
        <label for="guarantor_email">Guarantor Email</label>
        <input type="email" id="guarantor_email" name="guarantor_email" class="email-field" inputmode="email">
      </div>
      <div class="grid-item">
        <label for="guarantor_relationship">Guarantor Relationship *</label>
        <input type="text" id="guarantor_relationship" name="guarantor_relationship" class="name-field" data-label="relationship" required>
      </div>
    </div>

    <!-- Collateral + Additional (keep as you had) -->
    <div class="grid-container">
      <div class="grid-item">
        <label for="collateral_type">Collateral Type *</label>
        <input type="text" id="collateral_type" name="collateral_type" required>
      </div>
      <div class="grid-item">
        <label for="collateral_value">Collateral Value *</label>
        <input type="number" id="collateral_value" name="collateral_value" required>
      </div>
      <div class="grid-item">
        <label for="collateral_description">Collateral Description</label>
        <input type="text" id="collateral_description" name="collateral_description">
      </div>
      <div class="grid-item">
        <label for="collateral_documents">Collateral Documents</label>
        <input type="file" id="collateral_documents" name="collateral_documents" multiple>
      </div>
    </div>

    <!-- Agreements (unchanged) -->
    <div class="grid-container">
      <div class="grid-item">
        <label><input type="checkbox" name="agreement_checklist_one" value="1" required> I have provided all required documents.</label>
      </div>
      <div class="grid-item">
        <label><input type="checkbox" name="agreement_checklist_two" value="1" required> I understand the loan terms and conditions.</label>
      </div>
      <div class="grid-item">
        <label><input type="checkbox" name="agreement_checklist_three" value="1" required> I agree to the repayment schedule.</label>
      </div>
    </div>
    <div class="grid-container">
      <div class="grid-item">
        <label><input type="checkbox" name="customer_agreement_one" value="1" required> I agree to the terms and conditions.</label>
      </div>
      <div class="grid-item">
        <label><input type="checkbox" name="customer_agreement_two" value="1" required> I consent to the use of my personal data as per the privacy policy.</label>
      </div>
      <div class="grid-item">
        <label><input type="checkbox" name="customer_agreement_three" value="1" required> I confirm the information provided is accurate to the best of my knowledge.</label>
      </div>
    </div>

    <!-- === Signature Row (3 items, one line) === -->
    <div class="grid-container">
      <div class="grid-item" style="grid-column: span 4;">
        <div class="signature-row">
          <!-- Customer Signature -->
          <div class="signature-box">
            <label for="signer_first_name">Customer full name *</label>
            <input type="text" id="signer_first_name" name="customer_full_name"
                   class="name-field" data-label="customer full name" required>

            <label class="mt-2">Customer Signature *</label>
            <canvas class="signature-canvas" id="signature-pad-customer"></canvas>
            <button type="button" id="clear-signature-customer" class="btn btn-sm btn-light mt-2">Clear</button>
            <input type="hidden" name="customer_signature" id="customer_signature" required>
          </div>

          <!-- Guarantor Signature -->
          <div class="signature-box">
            <label for="signer_last_name">Guarantor full name *</label>
            <input type="text" id="signer_last_name" name="guarantor_full_name"
                   class="name-field" data-label="guarantor full name" required>

            <label class="mt-2">Guarantor Signature *</label>
            <canvas class="signature-canvas" id="signature-pad-guarantor"></canvas>
            <button type="button" id="clear-signature-guarantor" class="btn btn-sm btn-light mt-2">Clear</button>
            <input type="hidden" name="guarantor_signature" id="guarantor_signature" required>
          </div>

          <!-- Date Signed -->
          <div class="date-box">
            <label for="date_signed">Date Signed *</label>
            <input type="date" id="date_signed" name="date_signed" required style="width: 100%;">
          </div>
        </div>
      </div>
    </div>

    <!-- Actions -->
    <div class="button-row">
      <a href="{{ route('dashboard') }}" class="action-btn no-underline">Back to Dashboard</a>
      <button type="submit" class="action-btn">Submit Application</button>
    </div>
    <button type="button" id="printButton" class="btn btn-secondary mt-3" onclick="window.print()">Print Application</button>
  </form>

  <!-- Libraries first (deferred, order matters) -->
  <script src="https://cdn.jsdelivr.net/npm/signature_pad@latest/dist/signature_pad.umd.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

  <!-- Your page JS from public/ -->
  <script src="{{ asset('js/loan-application.page.js') }}" defer></script>
</body>
</html>
