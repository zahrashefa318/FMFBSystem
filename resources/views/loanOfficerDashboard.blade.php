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
          <a href="#placeholderSection"
           class="nav-link load-new"
           data-url="{{route('onlycustomerlist')}}"
           data-bs-target="#placeholderSection"
           role="button"
           aria-expanded="false"
           aria-controls="placeholderSection"
           >New Customers</a>
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
        <div class="main-title">Customers
          @if (session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
          @endif  
        </div>
        <div id="placeholderSection" class="collapse">
          <div class="placeholder p-3">Customers</div>
        </div>
        
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $(function() {
  
    // Delegated click event handler
    $(document).on('click', '.clickable-row', function() {
      const url = $(this).data('url');
      if (url) window.location.href = url;
    });

    // AJAX trigger for New Customers
    $('.load-new').on('click', function(e) {
      e.preventDefault();
      const target = $('#placeholderSection');
      const bsCollapse = bootstrap.Collapse.getOrCreateInstance(target[0]);
      bsCollapse.hide();

      $.ajax({
        url: $(this).data('url'),
        method: 'GET',
        headers: { 'Accept': 'text/html' },
        success: function(html) {
          target.html(html);
          bsCollapse.show();
        },
        error: function(xhr) {
          target.html(`<p class="text-danger p-3">Error loading data (${xhr.status})</p>`);
          bsCollapse.show();
        }
      });
    });

  });
</script>




</body>
</html>
