{{-- resources/views/customerLoanInformation.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Loan Form Sections</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #fff;
      color: #341539;
      margin: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .header-container {
      background-color: #fff;
      padding: 2rem 0 1rem;
      text-align: center;
    }
    .header-container h1 {
      margin: 0;
      font-size: 1.6rem;
      font-weight: 800;
      color: #341539;
    }
    .dashboard-wrapper {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 1rem;
    }
    .dashboard-container {
      width: 100%;
      max-width: 900px;
      border-radius: 0.5rem;
      background-color: #f8f9fa;
      padding: 1.5rem;
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    .section-box {
      padding: 1rem;
      border: 1px dashed rgba(52, 21, 57, 0.3); /* narrow, subtle, nonsensical */
      border-radius: 0.25rem;
    }
    .section-title {
      font-size: 1.25rem;
      font-weight: 600;
      margin-bottom: 0.75rem;
      color: #341539;
    }
  </style>
</head>
<body>
  <div class="header-container">
    <h1>Loan Application</h1>
  </div>

  <div class="dashboard-wrapper">
    <div class="dashboard-container">

      <div class="section-box">
        <div class="section-title">Customer Information</div>
        {{-- Add customer info form fields here --}}
      </div>

      <div class="section-box">
        <div class="section-title">Loan Application</div>
        {{-- Add loan application fields here --}}
      </div>

      <div class="section-box">
        <div class="section-title">Guarantor</div>
        {{-- Add guarantor info here --}}
      </div>

      <div class="section-box">
        <div class="section-title">Collateral</div>
        {{-- Add collateral details here --}}
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
