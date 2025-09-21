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
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
      padding: 1.5rem;
      flex: 1;
    }

    /* Table Styling with Rounded Corners */
    .section-table {
      background-color: #341539 !important;
      color: #fff !important;
      border: 2px solid #fff;
      border-collapse: separate !important;
      border-radius: 0.5rem;
      border-spacing: 0;
      overflow: hidden;
    }
    .section-table th,
    .section-table td {
      border: 1px solid #fff !important;
      padding: 0.25rem 0.5rem !important;
      font-size: 0.9rem;
    }
    .section-table thead th {
      text-align: center;
      font-size: 1.15rem;
      font-weight: 600;
      background-color: #341539 !important;
    }

    /* Button Styling */
    .btn-custom {
      background-color: #341539 !important;
      border-color: #341539 !important;
      color: #fff !important;
      min-width: 100px;
    }
    .btn-custom:hover,
    .btn-custom:focus,
    .btn-custom:active {
      background-color: #2a122f !important;
      border-color: #2a122f !important;
    }
    /* Make anchor & button compute the same height */
a.btn-custom,
button.btn-custom {
  /* use Bootstrap's btn variables so both render identically */
  --bs-btn-padding-y: .5rem;
  --bs-btn-padding-x: 1rem;
  --bs-btn-line-height: 1.5;
  --bs-btn-border-width: 1px;

  display: inline-flex;           /* same layout model */
  align-items: center;            /* vertical centering */
  justify-content: center;
  line-height: var(--bs-btn-line-height);
  padding: var(--bs-btn-padding-y) var(--bs-btn-padding-x);
  border-width: var(--bs-btn-border-width);
  box-sizing: border-box;
  vertical-align: middle;         /* avoid baseline quirks */
  text-decoration: none;          /* anchors only, but safe */
}

/* optional: force identical widths */
.btn-same { min-width: 8rem; }


/* -------Style for flash messages-----------------*/

  .simple-alert {
    position: relative; padding: .75rem 2.5rem .75rem 1rem; border:1px solid transparent;
    border-radius:.375rem; margin:1rem 0; display:block;
  }
  .simple-alert-success { color:#0f5132; background:#d1e7dd; border-color:#badbcc; }
  .simple-alert-danger  { color:#842029; background:#f8d7da; border-color:#f5c2c7; }
  .simple-alert .close {
    position:absolute; top:.5rem; right:.5rem; border:0; background:transparent;
    width:1rem; height:1rem; line-height:1rem; font-size:1.25rem; cursor:pointer;
  }


  </style>
</head>
<body>
  <div class="header-container">
    <h1>Loan Application</h1>
  </div>

@if ($errors->has('status'))
    <div class="standalone-error" role="alert">
        <span>{{ $errors->first('status') }}</span>
        <button type="button" class="close-btn" onclick="this.parentElement.remove()" aria-label="Close">
            &times;
        </button>
    </div>

    <style>
        /* Scoped styling: affects ONLY .standalone-error */
        .standalone-error {
            max-width: 500px;
            margin: 1rem auto;
            padding: 0.75rem 1rem;
            background-color: #fff3cd;   /* soft yellow */
            color: #664d03;             /* dark text */
            border: 1px solid #ffeeba;
            border-radius: 0.5rem;
            font-size: 0.95rem;
            line-height: 1.4;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            position: relative;
        }
        .standalone-error .close-btn {
            position: absolute;
            top: 0.25rem;
            right: 0.5rem;
            background: none;
            border: none;
            font-size: 1.25rem;
            color: inherit;
            cursor: pointer;
            line-height: 1;
            opacity: 0.6;
        }
        .standalone-error .close-btn:hover {
            opacity: 1;
        }
    </style>
@endif
  <div class="dashboard-wrapper">
  <div class="dashboard-container">
  @foreach ($sections as $title => $labels)
  @php
    // choose the dataset for this section (customer / loan / guarantor / collateral)
    $dataSet = $loanData[$titleMap[$title]] ?? null;
  @endphp

  <table class="table table-sm section-table mb-0">
    <thead>
      <tr>
        <th colspan="{{ count($labels) }}" class="text-center">{{ $title }}</th>
      </tr>
      <tr>
        @foreach ($labels as $label)
          <th scope="col">{{ $label }}</th>
        @endforeach
      </tr>
    </thead>

    <tbody>
      <tr>
        @foreach ($labels as $label)
          @php $key = $fieldMap[$label] ?? null; @endphp
          <td style="text-align:center;">
            @if ($key === 'document_reference')
              @php $path = data_get($dataSet, $key); @endphp
              @if ($path)
                <a href="{{ Storage::url($path) }}" class="text-white text-decoration-underline" style="color:#fff;" target="_blank" rel="noopener">View</a>
              @else
                —
              @endif
            @else
              {{ $key ? data_get($dataSet, $key, '—') : '—' }}
            @endif
          </td>
        @endforeach
      </tr>
    </tbody>
  </table>
@endforeach
  <!-- Buttons Anchored at Bottom and Centered -->
      <div class="mt-auto text-center" style="margin:0 auto;">
        @php
          $customerId=$customerId;
        @endphp
  <form id="approveForm" action="{{route('approvedCustomer',$customerId)}}" method="POST" style="display: none;">
  @csrf
 </form>
  <a href="#" class="btn btn-custom me-2 btn-same" onclick="event.preventDefault(); document.getElementById('approveForm').submit();">Approve</a>

  <form id="denyForm" action="{{route('deny',$customerId)}}" method="POST" style="display: none;">
  @csrf
 </form>
  <a href="#"
     class="btn btn-custom me-2 btn-same"onclick="event.preventDefault(); document.getElementById('denyForm').submit();"> Deny </a>

  <a href="{{ url()->previous() }}"
     class="btn btn-custom btn-same">Back</a>
</div>
</div>


      
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>
