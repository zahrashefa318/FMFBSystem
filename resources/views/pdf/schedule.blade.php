{{-- resources/views/pdf/schedule.blade.php --}}
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Loan Schedule PDF</title>
  <style>
    /* DomPDF ships DejaVu fonts so Unicode (e.g., Arabic/Dari) renders correctly */
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; line-height: 1.35; color: #111; }
    h1 { font-size: 18px; margin: 0 0 10px; }
    .meta { color: #555; margin: 0 0 12px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #ddd; padding: 6px 8px; }
    th { background: #f4f4f6; font-weight: 600; }
    td.right, th.right { text-align: right; }
    /* Help DomPDF avoid breaking a row across pages */
    tr { page-break-inside: avoid; }
  </style>
</head>
<body>
  <h1>Loan Repayment Schedule</h1>
  <p class="meta">
    Principal: ${{ number_format($loan->total_loan_given, 2) }} ·
    APR: {{ number_format($loan->interest_rate, 2) }}% ·
    Term: {{ $loan->duration }} months ·
    Monthly: ${{ number_format($monthlyPayment, 2) }}<br>
    Start: {{ \Carbon\Carbon::parse($loan->start_date)->toDateString() }} ·
    End: {{ \Carbon\Carbon::parse($loan->end_date)->toDateString() }}
  </p>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Date</th>
        <th class="right">Payment</th>
        <th class="right">Interest</th>
        <th class="right">Principal</th>
        <th class="right">Balance</th>
      </tr>
    </thead>
    <tbody>
      @foreach($schedule as $row)
      <tr>
        <td>{{ $row['payment_no'] }}</td>
        <td>{{ \Carbon\Carbon::parse($row['date'])->toDateString() }}</td>
        <td class="right">${{ number_format($row['payment'], 2) }}</td>
        <td class="right">${{ number_format($row['interest'], 2) }}</td>
        <td class="right">${{ number_format($row['principal'], 2) }}</td>
        <td class="right">{{ $row['balance'] == 0 ? '—' : '$'.number_format($row['balance'], 2) }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
