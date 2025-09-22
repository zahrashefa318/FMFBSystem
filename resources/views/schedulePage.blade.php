<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Loan Repayment Schedule</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- Bootstrap 5 CSS (CDN) --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root {
      --brand: #341539;
      --brand-contrast: #ffffff;
    }

    /* Narrow page width */
    .container-narrow { max-width: 900px; }

    /* Sticky header cells inside the scrollable .table-responsive wrapper */
    .table-responsive thead th.sticky-th {
      position: sticky;
      top: 0;
      z-index: 2;
      background: var(--brand);
      color: var(--brand-contrast);
    }

    /* Brand surfaces */
    .bg-brand { background-color: var(--brand) !important; color: var(--brand-contrast) !important; }

    /* Brand for table tfoot as well */
    tfoot.table-light th { background-color: var(--brand) !important; color: var(--brand-contrast) !important; }

    /* Make badges readable on brand backgrounds */
    .card.bg-brand .badge { background-color: rgba(255,255,255,.2); color: #fff; }

    /* Right-align currency cells */
    .text-money { text-align: right; }

    /* -----------style for back and customer (emailing) buttons-------*/
    .btn-custom-purple {
  background-color: #341539; 
  color: #ffffff;
  border: 1px solid #341539;
}

/* Hover & focus state to lighten or darken a bit for feedback */
.btn-custom-purple:hover,
.btn-custom-purple:focus {
  background-color: #5C068C; /* slightly lighter or darker purple */
  border-color: #5C068C;
  color: #ffffff;
}
  </style>
</head>
<body>
  <div class="container container-narrow my-4">

    {{-- Header with email button --}}
    <div class="d-flex justify-content-between align-items-center mb-1">
      <h1 class="h4 mb-0">Loan Repayment Schedule</h1>

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

    <div class="d-flex gap-2 align-items-center">
      {{-- Back button --}}
  <a href="{{route('dashboard')}}" class="btn btn-sm btn-secondary btn-custom-purple">Back</a>
      {{-- Email schedule to approved customer --}}
      <form method="POST" action="{{ route('emailSchedule', $loanAcc->loan_id) }}" class="d-flex gap-2">
        @csrf
        <span class="align-self-center small text-muted d-none d-sm-inline">
          Email to: <strong>{{ $customerEmail ?? '—' }}</strong>
        </span>
        <button type="submit" class="btn btn-sm btn-primary btn-custom-purple">Customer</button>
      </form>
  </div>
    </div>

    <div class="text-muted small mb-3">
      Start: {{ \Carbon\Carbon::parse($loanAcc->start_date)->toDateString() ?? '—' }} ·
      End: {{ \Carbon\Carbon::parse($loanAcc->end_date)->toDateString() ?? '—' }}
    </div>

    {{-- Flash messages --}}
    @if(session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @elseif(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @php
      // Values from controller/model
      $principalRaw   = (float) ($loanAcc->total_loan_given ?? 0);
      $aprRaw         = (float) ($loanAcc->interest_rate   ?? 0);
      $termMonths     = (int)   ($loanAcc->duration        ?? 0);

      // Display formatting
      $principal      = number_format($principalRaw, 2);
      $apr            = number_format($aprRaw, 2);

      // Use first scheduled payment (or controller's $monthlyPayment) for display
      $displayMonthly = number_format((float) ($schedule[0]['payment'] ?? ($monthlyPayment ?? 0)), 2);

      // Totals from the schedule
      $totalInterest  = isset($schedule) ? collect($schedule)->sum('interest') : 0;
      $totalPaid      = isset($schedule) ? collect($schedule)->sum('payment')  : 0;
    @endphp

    {{-- Summary row (4 brand cards) --}}
    <div class="row g-3 mb-4">
      <div class="col-6 col-md-3">
        <div class="card h-100 bg-brand">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h6 class="mb-1">Principal</h6>
              <span class="badge">Base</span>
            </div>
            <div class="fs-5 fw-semibold">${{ $principal }}</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card h-100 bg-brand">
          <div class="card-body">
            <h6 class="mb-1">APR</h6>
            <div class="fs-5 fw-semibold">{{ $apr }}%</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card h-100 bg-brand">
          <div class="card-body">
            <h6 class="mb-1">Term</h6>
            <div class="fs-5 fw-semibold">{{ $termMonths }} mo</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card h-100 bg-brand">
          <div class="card-body">
            <h6 class="mb-1">Monthly Payment</h6>
            <div class="fs-5 fw-semibold">${{ $displayMonthly }}</div>
          </div>
        </div>
      </div>
    </div>

    {{-- Schedule table --}}
    <div class="card">
      <div class="card-header bg-brand">
        <span class="fw-semibold">Detailed Schedule</span>
      </div>

      <div class="table-responsive" style="max-height: 60vh;">
        <table class="table table-striped table-hover align-middle mb-0">
          <thead>
            <tr>
              <th class="sticky-th">#</th>
              <th class="sticky-th">Date</th>
              <th class="sticky-th text-money">Payment</th>
              <th class="sticky-th text-money">Interest</th>
              <th class="sticky-th text-money">Principal</th>
              <th class="sticky-th text-money">Balance</th>
            </tr>
          </thead>

          <tbody>
            @forelse ($schedule ?? [] as $row)
              <tr>
                <td class="text-muted">{{ $row['payment_no'] }}</td>
                <td>{{ \Carbon\Carbon::parse($row['date'])->toDateString() }}</td>
                <td class="text-money fw-semibold">${{ number_format($row['payment'], 2) }}</td>
                <td class="text-money">${{ number_format($row['interest'], 2) }}</td>
                <td class="text-money">${{ number_format($row['principal'], 2) }}</td>
                <td class="text-money">{{ ($row['balance'] ?? 0) == 0 ? '—' : '$' . number_format($row['balance'], 2) }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center text-muted py-4">No schedule available.</td>
              </tr>
            @endforelse
          </tbody>

          @if (!empty($schedule))
          <tfoot class="table-light">
            <tr>
              <th colspan="2" class="text-end">Totals:</th>
              <th class="text-money">${{ number_format($totalPaid, 2) }}</th>
              <th class="text-money">${{ number_format($totalInterest, 2) }}</th>
              <th class="text-money">${{ number_format($principalRaw, 2) }}</th>
              <th></th>
            </tr>
          </tfoot>
          @endif
        </table>
      </div>
    </div>

  </div>

  {{-- Bootstrap 5 JS (optional) --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
