<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Loan Officer Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
  </head>
<body>
  <!-- Header Section -->
  <div class="header-container">
    <h1>Loan Officer Dashboard</h1>
     @auth
    <h2 style="color:black;">Loan Officer Id: {{ auth()->id() }}</h2>
  @else
    <h2  style="color:black;" class="text-muted">Not signed in</h2>
  @endauth
  </div>

  <!-- Main Dashboard Content -->
  <div class="dashboard-wrapper">
    <div class="dashboard-container">
      <div class="sidebar">
        <div class="sidebar-title">Menu</div>

        <div class="nav-links">
          <a href="#placeholderSection"
           class="nav-link load-new"
           data-url="{{route('onlycustomerlist',['status' => 'new'], false)}}"
           data-bs-target="#placeholderSection"
           role="button"
           aria-expanded="false"
           aria-controls="placeholderSection"
           >New Customers</a>
          <a href="#placeholderSection" 
           class="nav-link load-pending"
           data-url="{{route('onlycustomerlist',['status' => 'pending'],false)}}"
           data-bs-target="#placeholderSection"
           role="button"
           aria-expanded="false"
           aria-controls="placeholderSection"
          >Pending Customers</a>
          <a href="#placeholderSection" 
           class="nav-link load-approved"
           data-url="{{route('onlycustomerlist',['status' => 'approved'],false)}}"
           data-bs-target="#placeholderSection"
           role="button"
           aria-expanded="false"
           aria-controls="placeholderSection">Approved Customers</a>

          <a href="#placeholderSection" 
           class="nav-link load-denied"
           data-url="{{route('onlycustomerlist',['status' => 'denied'],false)}}"
           data-bs-target="#placeholderSection"
           role="button"
           aria-expanded="false"
           aria-controls="placeholderSection">Denied Customers</a>
          <a href="#" class="nav-link">Paid Off Customers</a>
        </div>

        <!-- Search by SSN field and button -->
          <form action="{{ route('search_customer_for_loanofficer') }}" method="POST">
    @csrf
        <div class="search-ssn">
          <input type="text" class="form-control d-inline-block" id="ssn-search2" name="ssn2" required placeholder="SSN">
          <button type="submit" class="btn btn-light btn-sm">Go</button>
        </div>
    </form>
        <!-- Logout link -->
        <div class="logout-link">
          <a href="{{ url('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-link">Logout</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
          @csrf
        </form>
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
$('.load-new').on('click', function(e){
  e.preventDefault();
  var target = $('#placeholderSection');
  // Collapse it
  var bsCollapse = bootstrap.Collapse.getOrCreateInstance(target[0]);
  bsCollapse.hide();

  // Now AJAX load the table
  $.ajax({
    url: $(this).data('url'),
    success: function(html){
      target.html(html);
      bsCollapse.show(); // then show once content is ready
    },
    error: function(){
      target.html('<p class="text-danger p‑3">Error loading data</p>');
      bsCollapse.show();
    }
  });
});
//load pending customers--------------------------------------
$('.load-pending').on('click', function(e){
  e.preventDefault();
  var target = $('#placeholderSection');
  // Collapse it
  var bsCollapse = bootstrap.Collapse.getOrCreateInstance(target[0]);
  bsCollapse.hide();

  // Now AJAX load the table
  $.ajax({
    url: $(this).data('url'),
    success: function(html){
      target.html(html);
      bsCollapse.show(); // then show once content is ready
    },
    error: function(){
      target.html('<p class="text-danger p‑3">Error loading data</p>');
      bsCollapse.show();
    }
  });
});

//load approved customers--------------------------------------
$('.load-approved').on('click', function(e){
  e.preventDefault();
  var target = $('#placeholderSection');
  // Collapse it
  var bsCollapse = bootstrap.Collapse.getOrCreateInstance(target[0]);
  bsCollapse.hide();

  // Now AJAX load the table
  $.ajax({
    url: $(this).data('url'),
    success: function(html){
      target.html(html);
      bsCollapse.show(); // then show once content is ready
    },
    error: function(){
      target.html('<p class="text-danger p‑3">Error loading data</p>');
      bsCollapse.show();
    }
  });
});

//load denied customers--------------------------------------
$('.load-denied').on('click', function(e){
  e.preventDefault();
  var target = $('#placeholderSection');
  // Collapse it
  var bsCollapse = bootstrap.Collapse.getOrCreateInstance(target[0]);
  bsCollapse.hide();

  // Now AJAX load the table
  $.ajax({
    url: $(this).data('url'),
    success: function(html){
      target.html(html);
      bsCollapse.show(); // then show once content is ready
    },
    error: function(){
      target.html('<p class="text-danger p‑3">Error loading data</p>');
      bsCollapse.show();
    }
  });
});
</script>


<!-- script for clickable rows to show customer details-->
<script>
  $(document).on('click', '.clickable-row', function() {
    const url = $(this).data('url');
    if (url) {
      window.location.href = url;
    }
  });
</script>
<!-- -------- script for ssn search client side validation------------>
<script>
  // --- your strict SSN pattern ---
  const ssnStrictPattern = /^(?!(000|666|9\d{2}))\d{3}-(?!00)\d{2}-(?!0000)\d{4}$/;

  // --- formatter: keep only digits, format as 123-45-6789 while typing ---
  function fixSSN(val) {
    let digits = val.replace(/\D/g, '').slice(0, 9);
    return digits.replace(/(\d{3})(\d{2})(\d{0,4})/, (m, a, b, c) => `${a}-${b}${c ? '-' + c : ''}`);
  }

  // helper: addEventListener shorthand (so your 'on(...)' calls work)
  const on = (el, ev, fn) => el && el.addEventListener(ev, fn);

  // hook up the input + form
  (function () {
    const input = document.getElementById('ssn-search2');
    const form  = input?.closest('form');

    if (!input) return; // safety

    // optional UX hints (doesn't change server-side)
    input.setAttribute('inputmode', 'numeric');
    input.setAttribute('autocomplete', 'off');
    input.setAttribute('maxlength', '11'); // 9 digits + 2 dashes

    // live format while typing, keep caret position
    on(input, 'input', (e) => {
      const posBefore  = e.target.selectionStart;
      const lenBefore  = e.target.value.length;
      e.target.value   = fixSSN(e.target.value);
      const lenAfter   = e.target.value.length;
      const newPos     = Math.max(0, (posBefore ?? lenAfter) + (lenAfter - lenBefore));
      e.target.setSelectionRange(newPos, newPos);
    });

    // validate on blur
    on(input, 'blur', (e) => {
      const v = e.target.value.trim();
      const valid = v === '' ? true : ssnStrictPattern.test(v);
      if (!valid) {
        alert('Invalid SSN format; expected 123-45-6789');
        e.target.focus();
      }
    });

    // block submit if invalid
    if (form) {
      on(form, 'submit', (e) => {
        const v = input.value.trim();
        if (!ssnStrictPattern.test(v)) {
          e.preventDefault();
          alert('Please enter a valid SSN in the format 123-45-6789.');
          input.focus();
        }
      });
    }
  })();
</script>






</body>
</html>
