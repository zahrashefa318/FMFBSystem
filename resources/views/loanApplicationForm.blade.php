<!DOCTYPE html>
<html lang="eng">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Loan Application Form</title>
   
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
     /* General Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
     /* ----------- Loan Application Form--------*/


    /* Body Styling */
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

    /* Form Container */
    form {
      background-color:  #341539;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 900px;
      box-sizing: border-box;
      color: #fff;
    }

    /* Header Styling */
    h1 {
      text-align: center;
      color: #fff;
      margin-bottom: 20px;
    }

    /* Grid Layout */
    .grid-container {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      margin-bottom: 20px;
    }

    .grid-item {
      display: flex;
      flex-direction: column;
    }

    label {
      font-size: 0.9rem;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="number"],
    select,
    textarea {
      width: 100%;
      padding: 8px;
      font-size: 0.95rem;
      border: 1px solid #ccc;
      border-radius: 4px;
      background: #f9f9f9;
      color: #333;
    }

    button[type="submit"] {
      width: auto;
      padding: 10px 20px;
      margin-top: 20px;
      background-color: #5e2a84;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    button[type="submit"]:hover {
      background-color: #4a1f6d;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
      .grid-container {
        grid-template-columns: repeat(3, 1fr);
      }
    }

    @media (max-width: 900px) {
      .grid-container {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 600px) {
      .grid-container {
        grid-template-columns: 1fr;
      }
    }
@media print {
  #printButton,
  button[type="submit"] {
    display: none;
  }
  .no-print {
    display: none !important;
  }

  /* Optional: Fit content to one page by scaling */
  html, body {
    zoom: 70%; /* Adjust as needed */
  }

  /* Set margins and page size */
  @page {
    size: auto;
    margin: 1cm;
  }
}
/* ---------- buttons styling---------*/
/* Only affect the two action buttons inside .button-row */
.button-row .action-btn {
  background-color: #5e2a84;
  color: #fff;
  border: none;
  padding: 10px 20px;
  font-size: 1rem;
  line-height: 1.2;     /* normalize text box height */
  border-radius: 4px;
  cursor: pointer;
  transition: background-color .2s ease;
  margin-top: 0;        /* cancel global submit margin */
  box-sizing: border-box;
  display: inline-flex; /* consistent vertical alignment */
  align-items: center;
}

.button-row .action-btn:hover {
  background-color: #4a1f6d;
}
.button-row {
      position: sticky;
      bottom: 0;
      display: flex;
      justify-content: center;
      gap: 20px;
      padding: 12px 0;
      background: #341539;
      z-index: 1;
    }
.action-btn.no-underline,
.action-btn.no-underline:visited,
.action-btn.no-underline:hover,
.action-btn.no-underline:active {
  text-decoration: none;
}
  </style>
</head>
<body>

  <form action="{{url('submitForm')}}" method="POST" enctype="multipart/form-data">
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

    <!-- Business Information -->
    <div class="grid-container">
      <div class="grid-item">
        <label for="business_name">Business Name *</label>
        <input type="text" id="business_name" name="business_name" required>
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
        <input type="text" id="address_zipcode" name="address_zipcode" required>
      </div>
      <div class="grid-item">
        <label for="phone">Phone Number *</label>
        <input type="tel" id="phone" name="phone" required>
      </div>
      <div class="grid-item">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email">
      </div>
      <div class="grid-item">
        <label for="loan_amount">Loan Amount *</label>
        <input type="number" id="loan_amount" name="loan_amount" required>
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
        <input type="number" id="repayment_term_months" name="repayment_term_months" required>
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
        <input type="number" id="interest_rate" name="interest_rate">
      </div>
    </div>

    <!-- Guarantor Information -->
    <div class="grid-container">
      <div class="grid-item">
        <label for="guarantor_name">Guarantor Full Name *</label>
        <input type="text" id="guarantor_name" name="guarantor_name" required>
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
        <input type="text" id="guarantor_zip" name="guarantor_zip" required>
      </div>
      <div class="grid-item">
        <label for="guarantor_phone">Guarantor Phone *</label>
        <input type="tel" id="guarantor_phone" name="guarantor_phone" required>
      </div>
      <div class="grid-item">
        <label for="guarantor_email">Guarantor Email</label>
        <input type="email" id="guarantor_email" name="guarantor_email">
      </div>
      <div class="grid-item">
        <label for="guarantor_relationship">Guarantor Relationship *</label>
        <input type="text" id="guarantor_relationship" name="guarantor_relationship" required>
      </div>
    </div>

    <!-- Collateral Information -->
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

    <!-- Additional Information -->
    <div class="grid-container">
      <div class="grid-item">
        <label for="additional_information">Additional Information</label>
        <textarea id="additional_information" name="additional_information" rows="4"></textarea>
      </div>
    </div>

    <!-- Agreement Checklist -->
    <div class="grid-container">
      <div class="grid-item">
        <label><input type="checkbox" name="agreement_checklist_one" value="1" required> I have provided all required documents.</label>
      </div>
      <div class="grid-item">
        <label><input type="checkbox" name="agreement_checklist_two" value="1" required> I understand the loan terms and conditions.</label>
      </div>
      <div class="grid-item">
        <label><input type="checkbox" name="agreement_checklist_three" value="1"required> I agree to the repayment schedule.</label>
      </div>
    </div>

    <!-- Customer Agreement -->
        <!-- Customer Agreement -->
    <div class="grid-container">
      <div class="grid-item">
        <label><input type="checkbox" name="customer_agreement_one" value="1" required> I agree to the terms and conditions.</label>
      </div>
      <div class="grid-item">
        <label><input type="checkbox" name="customer_agreement_two" value="1" required> I consent to the use of my personal data as per the privacy policy.</label>
      </div>
      <div class="grid-item">
        <label><input type="checkbox" name="customer_agreement_three"value="1"  required> I confirm the information provided is accurate to the best of my knowledge.</label>
      </div>
    </div>

    
    
  </div>
</div>

<!-- Signature Section with side-by-side layout -->
<div class="grid-container">
  <div class="grid-item" style="grid-column: span 2;">
    <div style="display: flex; gap: 20px; justify-content: space-between; align-items: flex-start;">

      <!-- Customer Signature -->
      <div style="flex: 1; border: 2px solid purple; padding: 10px;">
      <label for="signer_first_name">Customer full name *</label>
      <input type="text" id="signer_first_name" name="customer_full_name" required>
        <label>Customer Signature *</label>
        <canvas id="signature-pad-customer"></canvas>
        <button type="button" id="clear-signature-customer">Clear</button>
        <input type="hidden" name="customer_signature" id="customer_signature" required>
      </div>

      <!-- Guarantor Signature -->
      <div style="flex: 1; border: 2px solid purple; padding: 10px;">
      <label for="signer_last_name">Guarantor full name *</label>
      <input type="text" id="signer_last_name" name="guarantor_full_name" required>
        <label>Guarantor Signature *</label>
        <canvas id="signature-pad-guarantor"></canvas>
        <button type="button" id="clear-signature-guarantor">Clear</button>
        <input type="hidden" name="guarantor_signature" id="guarantor_signature" required>
      </div>

      <!-- Date Signed -->
      <div style="flex: 1; padding: 10px;">
        <label for="date_signed">Date Signed *</label>
        <input type="date" id="date_signed" name="date_signed" required style="width: 100%;">
      </div>

    </div>
  </div>
</div>



    <!-- Submit Button -->
   <!-- Buttons Container (Submit & Back) -->
<div class="button-row">
  <a href="{{ route('dashboard') }}" class="action-btn no-print no-underline">  Back to Dashboard</a>
  <button type="submit" class="action-btn no-print">Submit Application</button>
</div>
<button type="button" id="printButton" onclick="window.print()">Print Application</button>



  </form>


  <script src="https://cdn.jsdelivr.net/npm/signature_pad@latest/dist/signature_pad.umd.min.js"></script>
<script>
  const customerCanvas = document.getElementById('signature-pad-customer');
  const guarantorCanvas = document.getElementById('signature-pad-guarantor');

  const customerPad = new SignaturePad(customerCanvas, { penColor: '#fff' });
  const guarantorPad = new SignaturePad(guarantorCanvas, { penColor: '#fff' });

  function resizeSignatureCanvas(canvas, pad) {
    canvas.width = canvas.offsetWidth;
    canvas.height = canvas.offsetHeight;
    pad.clear();
  }

  window.addEventListener('resize', () => {
    resizeSignatureCanvas(customerCanvas, customerPad);
    resizeSignatureCanvas(guarantorCanvas, guarantorPad);
  });

  // Initial canvas resize
  resizeSignatureCanvas(customerCanvas, customerPad);
  resizeSignatureCanvas(guarantorCanvas, guarantorPad);

  // Clear buttons
  document.getElementById('clear-signature-customer').addEventListener('click', () => {
    customerPad.clear();
  });
  document.getElementById('clear-signature-guarantor').addEventListener('click', () => {
    guarantorPad.clear();
  });

  // On form submit
  document.querySelector('form').addEventListener('submit', function (e) {
    if (customerPad.isEmpty()) {
      alert('Please provide the customer signature.');
      e.preventDefault();
      return;
    }
    if (guarantorPad.isEmpty()) {
      alert('Please provide the guarantor signature.');
      e.preventDefault();
      return;
    }

    document.getElementById('customer_signature').value = customerPad.toDataURL();
    document.getElementById('guarantor_signature').value = guarantorPad.toDataURL();
  });
</script>
<!-- -------script for data sanitization and validation for the form---------  -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('form');
  const phoneField = form.phone;
  const phonePattern = /^\(\d{3}\) \d{3}-\d{4}$/;

  function showError(field, msg) {
    field.setCustomValidity(msg);
    field.reportValidity();
  }
  function clearError(field) {
    field.setCustomValidity('');
  }

  // Auto-format as user types:
  phoneField.addEventListener('input', (e) => {
    let digits = e.target.value.replace(/\D/g, '');
    let match = digits.match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
    if (match) {
      e.target.value = !match[2]
        ? match[1]
        : `(${match[1]}) ${match[2]}${match[3] ? '-' + match[3] : ''}`;
    }
  });

  // Validate format on blur and submit:
  function validatePhone() {
    if (!phonePattern.test(phoneField.value)) {
      showError(phoneField, 'Phone must be in format (123) 456‑7890');
      return false;
    }
    clearError(phoneField);
    return true;
  }

  phoneField.addEventListener('blur', validatePhone);

  form.addEventListener('submit', function(e) {
    if (!validatePhone()) {
      e.preventDefault();
    } else {
      // Signature logic, etc.
    }
  });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

 
