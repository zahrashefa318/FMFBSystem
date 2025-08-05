<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Loan Application Form</title>
  <style>
    /* Reset default margins and padding */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Set the background color of the page */
    body {
      font-family: Arial, sans-serif;
      background-color:#fff; /* Dark purple background */
      color: white;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      height: 100vh;
      padding: 20px;
    }

    /* Style the form container */
    form {
      background-color: #301934; /* Dark purple form background */
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 900px;
      box-sizing: border-box;
    }

    /* Header style */
    h1 {
      text-align: center;
      color: #fff;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    td {
      padding: 8px;
      vertical-align: top;
    }

    label {
      display: inline-block;
      width: 200px;
      text-align: left;
      margin-bottom: 4px;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="number"],
    select,
    textarea {
      width: 100%;
      max-width: 250px; /* Shortened width */
      padding: 8px;
      margin-top: 4px;
      border: 1px solid #ccc;
      border-radius: 4px;
      background-color: #f9f9f9;
      color: #333;
    }

    button[type="submit"] {
      width: auto;
      padding: 10px 20px;
      margin-top: 20px;
      background-color: #5e2a84; /* Purple button */
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    button[type="submit"]:hover {
      background-color: #4a1f6d; /* Darker purple on hover */
    }

    .agreement-section {
      margin-top: 20px;
      border-top: 2px solid #ccc;
      padding-top: 20px;
    }

    .agreement-section label {
      width: auto;
      display: inline-block;
    }

    .signature-section {
      margin-top: 20px;
    }

    .signature-section input[type="text"] {
      width: 50%;
    }
  </style>
</head>
<body>

  <form action="/submit" method="POST">
    <h1>Loan Application Form</h1>
    <table>
      <tr>
        <td><label for="business_name">Business Name *</label></td>
        <td><input type="text" id="business_name" name="business_name" required></td>
      </tr>
      <tr>
        <td><label for="business_structure">Legal Structure</label></td>
        <td><input type="text" id="business_structure" name="business_structure"></td>
      </tr>
      <tr>
        <td><label for="address_street">Street Address *</label></td>
        <td><input type="text" id="address_street" name="address_street" required></td>
      </tr>
      <tr>
        <td><label for="address_city">City *</label></td>
        <td><input type="text" id="address_city" name="address_city" required></td>
      </tr>
      <tr>
        <td><label for="address_state">State *</label></td>
        <td><input type="text" id="address_state" name="address_state" required></td>
      </tr>
      <tr>
        <td><label for="address_zipcode">Zip Code *</label></td>
        <td><input type="text" id="address_zipcode" name="address_zipcode" required></td>
      </tr>
      <tr>
        <td><label for="phone">Phone Number *</label></td>
        <td><input type="tel" id="phone" name="phone" required></td>
      </tr>
      <tr>
        <td><label for="email">Email Address</label></td>
        <td><input type="email" id="email" name="email"></td>
      </tr>
      <tr>
        <td><label for="loan_amount">Loan Amount *</label></td>
        <td><input type="number" id="loan_amount" name="loan_amount" required></td>
      </tr>
      <tr>
        <td><label for="loan_purpose">Purpose *</label></td>
        <td>
          <select id="loan_purpose" name="loan_purpose" required>
            <option value="">Select</option>
            <option value="Equipment">Equipment Purchase</option>
            <option value="Marketing">Marketing & Advertising</option>
            <option value="WorkingCapital">Working Capital</option>
            <option value="CapacityExpansion">Capacity Expansion</option>
            <option value="Other">Other</option>
          </select>
        </td>
      </tr>
      <tr>
        <td><label for="repayment_term_months">Term (months) *</label></td>
        <td><input type="number" id="repayment_term_months" name="repayment_term_months" required></td>
      </tr>
      <tr>
        <td><label for="repayment_frequency">Frequency *</label></td>
        <td>
          <select id="repayment_frequency" name="repayment_frequency" required>
            <option value="Monthly">Monthly</option>
            <option value="Quarterly">Quarterly</option>
            <option value="Annually">Annually</option>
          </select>
        </td>
      </tr>
      <tr>
        <td><label for="interest_rate">Interest Rate (%)</label></td>
        <td><input type="number" id="interest_rate" name="interest_rate"></td>
      </tr>
      <tr>
        <td><label for="guarantor_name">Guarantor Full Name *</label></td>
        <td><input type="text" id="guarantor_name" name="guarantor_name" required></td>
      </tr>
      <tr>
        <td><label for="guarantor_street">Guarantor Street Address *</label></td>
        <td><input type="text" id="guarantor_street" name="guarantor_street" required></td>
      </tr>
      <tr>
        <td><label for="guarantor_city">Guarantor City *</label></td>
        <td><input type="text" id="guarantor_city" name="guarantor_city" required></td>
      </tr>
      <tr>
        <td><label for="guarantor_state">Guarantor State *</label></td>
        <td><input type="text" id="guarantor_state" name="guarantor_state" required></td>
      </tr>
      <tr>
        <td><label for="guarantor_zip">Guarantor Zip Code *</label></td>
        <td><input type="text" id="guarantor_zip" name="guarantor_zip" required></td>
      </tr>
      <tr>
        <td><label for="guarantor_phone">Guarantor Phone *</label></td>
        <td><input type="tel" id="guarantor_phone" name="guarantor_phone" required></td>
      </tr>
      <tr>
        <td><label for="guarantor_email">Guarantor Email</label></td>
        <td><input type="email" id="guarantor_email" name="guarantor_email"></td>
      </tr>
      <tr>
        <td><label for="guarantor_signature">Guarantor Signature *</label></td>
        <td><input type="text" id="guarantor_signature" name="guarantor_signature" required></td>
      </tr>
      <tr>
        <td><label for="collateral_type">Collateral Type *</label></td>
        <td><input type="text" id="collateral_type" name="collateral_type" required></td>
      </tr>
      <tr>
        <td><label for="collateral_value">Collateral Value *</label></td>
        <td><input type="number" id="collateral_value" name="collateral_value" required></td>
      </tr>
      <tr>
        <td><label for="collateral_description">Collateral Description</label></td>
        <td><input type="text" id="collateral_description" name="collateral_description"></td>
      </tr>
      <tr>
        <td><label for="collateral_documents">Collateral Documents</label></td>
        <td><input type="file" id="collateral_documents" name="collateral_documents" multiple></td>
      </tr>
      <tr>
        <td><label for="additional_information">Additional Information</label></td>
        <td><textarea id="additional_information" name="additional_information" rows="4"></textarea></td>
      </tr>
      
    
      

      <!-- Agreement Checklist -->
      <tr>
        <td colspan="2" class="agreement-section">
          <h3>Agreement Checklist</h3>
          <label><input type="checkbox" name="agreement_checklist" required> I have provided all required documents.</label><br>
          <label><input type="checkbox" name="agreement_checklist" required> I understand the loan terms and conditions.</label><br>
          <label><input type="checkbox" name="agreement_checklist" required> I agree to the repayment schedule.</label><br>
        </td>
      </tr>

      <!-- Customer Agreement -->
      <tr>
        <td colspan="2" class="agreement-section">
          <label for="customer_agreement">Customer Agreement *</label><br>
          <textarea id="customer_agreement" name="customer_agreement" rows="4" required></textarea>
        </td>
      </tr>

      <!-- Customer Signature -->
      <tr>
        <td colspan="2" class="signature-section">
          <label for="customer_signature">Customer Signature *</label><br>
          <input type="text" id="customer_signature" name="customer_signature" required>
        </td>
      </tr>

      <tr>
        <td colspan="2" style="text-align: center;">
          <button type="submit">Submit Application</button>
        </td>
      </tr>
    </table>
  </form>

</body>
</html>
