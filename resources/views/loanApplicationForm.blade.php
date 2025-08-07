<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Loan Application Form</title>
  <style>
    /* General Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

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
  </style>
</head>
<body>

  <form action="/submit" method="POST">
    <h1>Loan Application Form</h1>

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
        <label for="guarantor_signature">Guarantor Signature *</label>
        <input type="text" id="guarantor_signature" name="guarantor_signature" required>
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
        <label><input type="checkbox" name="agreement_checklist" required> I have provided all required documents.</label>
      </div>
      <div class="grid-item">
        <label><input type="checkbox" name="agreement_checklist" required> I understand the loan terms and conditions.</label>
      </div>
      <div class="grid-item">
        <label><input type="checkbox" name="agreement_checklist" required> I agree to the repayment schedule.</label>
      </div>
    </div>

    <!-- Customer Agreement -->
        <!-- Customer Agreement -->
    <div class="grid-container">
      <div class="grid-item">
        <label><input type="checkbox" name="customer_agreement" required> I agree to the terms and conditions.</label>
      </div>
      <div class="grid-item">
        <label><input type="checkbox" name="customer_agreement" required> I consent to the use of my personal data as per the privacy policy.</label>
      </div>
      <div class="grid-item">
        <label><input type="checkbox" name="customer_agreement" required> I confirm the information provided is accurate to the best of my knowledge.</label>
      </div>
    </div>

    <!-- Signature Section -->
    <div class="grid-container" >
      <div class="grid-item">
        <div class="signature-section"style="border: 2px solid purple; padding: 20px;">
      <label>Customer Signature *</label>
      <canvas id="signature-pad"></canvas>
      <button type="button" id="clear-signature">Clear Signature</button>
      <input type="hidden" name="customer_signature" id="customer_signature" required>
    </div>

      </div>
      <div class="grid-item">
        <label for="date_signed">Date Signed *</label>
        <input type="date" id="date_signed" name="date_signed" required>
      </div>
    </div>

    <!-- Submit Button -->
    <div class="grid-container">
      <div class="grid-item">
        <button type="submit">Submit Application</button>
      </div>
    </div>
  </form>
   <script src="https://cdn.jsdelivr.net/npm/signature_pad@latest/dist/signature_pad.umd.min.js"></script>
<script>
  const canvas = document.getElementById('signature-pad');
  const signaturePad = new SignaturePad(canvas, { penColor: '#fff' });

  function resizeCanvas() {
    const ratio = Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext('2d').scale(ratio, ratio);
    signaturePad.clear();
  }

  window.addEventListener('resize', resizeCanvas);
  resizeCanvas();

  document.getElementById('clear-signature').addEventListener('click', () => signaturePad.clear());
  document.querySelector('form').addEventListener('submit', function(event) {
    if (signaturePad.isEmpty()) {
      alert('Please provide your signature.');
      event.preventDefault();
    } else {
      document.getElementById('customer_signature').value = signaturePad.toDataURL();
    }
  });
</script>

</body>
</html>

 
