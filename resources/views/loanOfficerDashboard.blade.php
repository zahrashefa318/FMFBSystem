<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Loan Officer Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
  </head>
<body>
  <!-- Header Section -->
  <div class="header-container">
    <h1>Loan Officer Dashboard</h1>
  </div>

  <!-- Main Dashboard Content -->
  <div class="dashboard-wrapper">
    <div class="dashboard-container">
      <div class="sidebar">
        <div class="sidebar-title">Menu</div>

        <div class="nav-links">
          <a href="#" class="nav-link">New Customers</a>
          <a href="#" class="nav-link">Pending Customers</a>
          <a href="#" class="nav-link">Approved Customers</a>
          <a href="#" class="nav-link">Denied Customers</a>
          <a href="#" class="nav-link">Paid Off Customers</a>
        </div>

        <!-- Search by SSN field and button -->
        <div class="search-ssn">
          <input type="text" class="form-control d-inline-block" placeholder="SSN">
          <button type="button" class="btn btn-light btn-sm">Go</button>
        </div>

        <!-- Logout link -->
        <div class="logout-link">
          <a href="#">Logout</a>
        </div>
      </div>

      <div class="main">
        <div class="main-title">Customers</div>
        <div class="placeholder">Customers</div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
