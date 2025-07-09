<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Receptionist Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
 <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
  <!-- Main header -->
  <div class="dashboard-header">Receptionist Dashboard</div>
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

  <div class="wrapper">
    <div class="dashboard">
      <!-- Left panel: Repeat Applicant -->
      <div class="sidebar">
        <form action="search_ssn" method="POST">
    @csrf

    <div class="mb-3">
        <label for="ssn-search" class="form-label">Search by SSN</label>
        <input
            type="text"
            id="ssn-search"
            name="ssn"
            class="form-control"
            maxlength="11"
            minlength="11"
            pattern="\d{11}"
            required
        >
    </div>

    <button type="submit" class="btn btn-custom w-100 mb-3">
        🔍 Search SSN
    </button>
</form>

<div class="mb-3">
  <textarea 
    class="form-control" 
    rows="6" 
    style="white-space: pre-wrap; padding-left: 0; text-indent: 0;" 
    readonly 
    placeholder="Details...">@if(session('customerInfo'))
    Name: {{ session('customerInfo')->first_name }}
    Last name: {{ session('customerInfo')->last_name }}
    RegistrationDate: {{ session('customerInfo')->registrationdate }}
    Status: {{ session('customerInfo')->status }}
    @elseif (session('message'))
    {{ session('message') }}
    @endif</textarea>
    </div>


        <h4>Repeat applicant</h4>

        <div class="mb-3">
          <label for="repeat-ssn" class="form-label">SSN</label>
          <input type="text" id="repeat-ssn" class="form-control" name="repeatSsn">
        </div>

        <div class="row g-2 mb-3">
          <div class="col">
            <label for="repeat-date" class="form-label text-white">Date</label>
            <input type="date" id="repeat-date" class="form-control" name="repeatDate">
          </div>
          <div class="col">
            <label for="repeat-status" class="form-label text-white">Status</label>
            <select id="repeat-status" class="form-select" name="repeatStatus">
              <option value="" selected>Select status…</option>
              <option>New</option>
            </select>
          </div>
        </div>

        <button class="btn btn-custom w-100 mb-3">Submit</button>
        <a href="#" class="logout-link">Logout</a>
      </div>

      <!-- Right panel: Customer Information Form -->
      <div class="content">
        <div class="form-fixed">
          <div class="container py-3">
            <h2 class="text-center text-white">Customer Information Form</h2>
            <form class="custom-form mx-auto" style="max-width: 600px;" action="{{route('to_customertbl')}}" method="POST">
              @csrf
              <div class="row mb-3">
                <div class="col">
                  <label for="firstName" class="form-label text-white">First Name</label>
                  <input type="text" class="form-control" name="firstName" id="firstName" required>
                </div>
                <div class="col">
                  <label for="lastName" class="form-label text-white">Last Name</label>
                  <input type="text" class="form-control" name="lastName" id="lastName" required>
                </div>
              </div>

              <div class="mb-3">
                <label for="ssn" class="form-label text-white">Social Security Number</label>
                <input type="text" class="form-control" name="ssn" id="ssn" required>
              </div>

              <div class="row mb-3">
                <div class="col">
                  <label for="phone" class="form-label text-white">Phone Number</label>
                  <input type="tel" class="form-control" name="phone" id="phone" required>
                </div>
                <div class="col">
                  <label for="email" class="form-label text-white">Email Address</label>
                  <input type="email" class="form-control" name="email" id="email" required>
                </div>
              </div>

              <div class="mb-3">
                <label for="businessType" class="form-label text-white">Type of Business</label>
                <select class="form-select" name="businessType" id="businessType" required>
                  <option value="">Select…</option>
                  <option>Retail Trade</option>
                  <option>Accommodation & Food Services</option>
                  <option>Repair & Maintenance Services</option>
                  <option>Hospitality</option>
                  <option>Goods‑Producing Sectors</option>
                </select>
              </div>

              <div class="mb-3">
                <label for="timeInBusiness" class="form-label text-white">Time in Business</label>
                <input type="text" class="form-control" name="timeInBusiness" id="timeInBusiness" placeholder="e.g. 5 years" required>
              </div>

              <div class="mb-3">
                <label for="businessAddress" class="form-label text-white">Business Address</label>
                <input type="text" class="form-control" name="businessAddress" id="businessAddress" required>
              </div>

              <div class="row mb-3">
                <div class="col">
                  <label for="zipcode" class="form-label text-white">Zip Code</label>
                  <input type="text" class="form-control" name="zipcode" id="zipcode" required>
                </div>
                <div class="col">
                  <label for="businessPhone" class="form-label text-white">Business Phone</label>
                  <input type="tel" class="form-control" name="businessPhone" id="businessPhone" required>
                </div>
              </div>

              <div class="mb-3">
                <label for="registrationDate" class="form-label text-white">Date of Registration</label>
                <input type="date" class="form-control" name="registrationDate" id="registrationDate" required>
              </div>

              <div class="text-center">
                <button type="submit" class="btn btn-custom">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
