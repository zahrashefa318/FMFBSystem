<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Receptionist Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root {
      --purple-dark: #563d7c;
      --purple-light: #6f5499;
      --wrapper-bg: #341539;
    }
    body {
      background: #fff;
      margin: 0;
      padding: 0;
    }
    .dashboard-header {
      background: #fff;
      color: var(--purple-dark);
      text-align: center;
      font-weight: bold;
      font-size: 1.5rem;
      padding: 1rem;
    }
    .wrapper {
      background: var(--wrapper-bg) !important;
      max-width: 800px;
      height: 90vh;
      margin: 1rem auto;
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }
    .dashboard {
      flex: 1;
      display: flex;
      overflow: hidden;
    }
    .sidebar {
      flex: 1;
      padding: 1rem;
      display: flex;
      flex-direction: column;
    }
    .sidebar h4 {
      color: #fff;
      margin-top: 1rem;
      margin-bottom: 1rem;
      font-weight: bold;
    }
    .content {
      flex: 2.5;
      padding: 1rem;
      overflow-y: auto;
    }
    .form-fixed {
      position: sticky;
      top: 0;
    }
    .btn-custom {
      background-color: var(--purple-dark);
      color: #fff;
      border: none;
    }
    .btn-custom:hover {
      background-color: var(--purple-light);
    }
    .logout-link {
      margin-top: auto;
      text-decoration: none;
      color: #ffc;
    }
    .logout-link:hover {
      text-decoration: underline;
    }
    label {
      color: #fff;
    }
    .form-control,
    .form-select,
    textarea {
      background: transparent;
      color: #fff;
      border: 1px solid #fff;
    }
  </style>
</head>
<body>
  <!-- Main header -->
  <div class="dashboard-header">Receptionist Dashboard</div>

  <div class="wrapper">
    <div class="dashboard">
      <!-- Left panel -->
      <div class="sidebar">
        <button class="btn btn-custom w-100 mb-3">🔍 Search SSN</button>

        <div class="mb-3">
          <label for="ssn-search" class="form-label">Search by SSN</label>
          <input type="text" id="ssn-search" class="form-control">
        </div>

        <div class="mb-3">
          <textarea class="form-control" rows="4" placeholder="Details..."></textarea>
        </div>

        <!-- Moved this header under the textarea -->
        <h4>Repeat applicant</h4>

        <div class="row g-2 mb-3">
          <div class="col">
            <input type="date" class="form-control">
          </div>
          <div class="col">
            <select class="form-select">
              <option value="" selected>Select status…</option>
              <option>New</option>
            </select>
          </div>
        </div>

        <button class="btn btn-custom w-100 mb-3">Submit</button>
        <a href="#" class="logout-link">Logout</a>
      </div>

      <!-- Right panel -->
      <div class="content">
        <div class="form-fixed">
          <div class="container py-3">
            <h2 class="text-center text-white">Customer Information Form</h2>
            <form class="custom-form mx-auto" style="max-width: 600px;" action="#" method="POST">
              <div class="row mb-3">
                <div class="col">
                  <label>First Name</label>
                  <input type="text" class="form-control" name="firstName" required>
                </div>
                <div class="col">
                  <label>Last Name</label>
                  <input type="text" class="form-control" name="lastName" required>
                </div>
              </div>

              <div class="mb-3">
                <label>Social Security Number</label>
                <input type="text" class="form-control" name="ssn" required>
              </div>

              <div class="row mb-3">
                <div class="col">
                  <label>Phone Number</label>
                  <input type="tel" class="form-control" name="phone" required>
                </div>
                <div class="col">
                  <label>Email Address</label>
                  <input type="email" class="form-control" name="email" required>
                </div>
              </div>

              <div class="mb-3">
                <label>Type of Business</label>
                <select class="form-select" name="businessType" required>
                  <option value="">Select…</option>
                  <option>Retail Trade</option>
                  <option>Accommodation & Food Services</option>
                  <option>Repair & Maintenance Services</option>
                  <option>Hospitality</option>
                  <option>Goods-Producing Sectors</option>
                </select>
              </div>

              <div class="mb-3">
                <label>Time in Business</label>
                <input type="text" class="form-control" name="timeInBusiness" placeholder="e.g. 5 years" required>
              </div>

              <div class="mb-3">
                <label>Business Address</label>
                <input type="text" class="form-control" name="businessAddress" required>
              </div>

              <div class="row mb-3">
                <div class="col">
                  <label>Zip Code</label>
                  <input type="text" class="form-control" name="zipcode" required>
                </div>
                <div class="col">
                  <label>Business Phone</label>
                  <input type="tel" class="form-control" name="businessPhone" required>
                </div>
              </div>

              <div class="mb-3">
                <label>Date of Registration</label>
                <input type="date" class="form-control" name="registrationDate" required>
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
