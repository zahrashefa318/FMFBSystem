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


  </style>
</head>
<body>
  <div class="header-container">
    <h1>Loan Application</h1>
  </div>

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

  <a href="#"
     class="btn btn-custom me-2 btn-same"> Deny </a>

  <a href="{{ url()->previous() }}"
     class="btn btn-custom btn-same">Back</a>
</div>
</div>


      
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
