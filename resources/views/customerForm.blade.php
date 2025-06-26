<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Customer Information Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h1 class="mb-4 text-center">Customer Information Form</h1>
    <form class="custom-form mx-auto" style="max-width: 600px;">
      <div class="row mb-3">
        <div class="col">
          <label class="form-label">First Name</label>
          <input type="text" class="form-control" name="firstName" required>
        </div>
        <div class="col">
          <label class="form-label">Last Name</label>
          <input type="text" class="form-control" name="lastName" required>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-12">
          <label class="form-label">Social Security Number</label>
          <input type="text" class="form-control" name="ssn" required>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col">
          <label class="form-label">Phone Number</label>
          <input type="tel" class="form-control" name="phone" required>
        </div>
        <div class="col">
          <label class="form-label">Email Address</label>
          <input type="email" class="form-control" name="email" required>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Type of Business</label>
        <select class="form-select" name="businessType" required>
          <option value="">Select...</option>
          <option>Retail Trade</option>
          <option>Accommodation &amp; Food Services</option>
          <option>Repair &amp; Maintenance Services</option>
          <option>Hospitality</option>
          <option>Goods-Producing Sectors</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Time in Business</label>
        <input type="text" class="form-control" name="timeInBusiness" placeholder="e.g. 5 years" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Business Address</label>
        <input type="text" class="form-control" name="businessAddress" required>
      </div>

      <div class="row mb-3">
        <div class="col">
          <label class="form-label">Zip Code</label>
          <input type="text" class="form-control" name="zipcode" required>
        </div>
        <div class="col">
          <label class="form-label">Business Phone</label>
          <input type="tel" class="form-control" name="businessPhone" required>
        </div>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-light">Submit</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
