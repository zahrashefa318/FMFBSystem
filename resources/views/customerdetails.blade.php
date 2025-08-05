{{-- resources/views/customerdetails.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf‑8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Customer Details – ID: {{ $customer->id }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #fff;
      margin: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      color: #fff;
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
      color: #341539 !important;
    }
    .dashboard-wrapper {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 1rem;
    }
    .dashboard-container {
      width:100%;
      max-width:800px;
      border-radius:0.5rem;
      background-color:#341539;
      padding:1.5rem;
      display:flex;
      flex-direction:column;
    }
    .container-header {
      font-size: 1.25rem;
      font-weight: 600;
      color: #fff;
      margin-bottom: 1rem;
    }
    table.data-table {
      width:100%;
      border-collapse: separate;
      border-spacing: 0;
      table-layout: fixed;
      color:#fff;
      margin-bottom:1.5rem;
      position: relative;
    }
    table.data-table td {
      padding:0.75rem;
      vertical-align:middle;
    }
    .divider-left {
      position:absolute;
      top:0;
      bottom:0;
      left:50%;
      width:0;
      margin-left:-1px;
      border-left:1px solid rgba(255,255,255,0.3);
    }
    table.data-table tr td {
      border-bottom:1px solid rgba(255,255,255,0.3);
    }
    table.data-table tr:last-child td {
      border-bottom:none;
    }
    td.label {
      font-weight:bold;
      width:25%;
    }
    .btn-row {
      margin-top:auto;
      text-align:right;
    }
    .btn-theme {
      background:transparent;
      color:#fff;
      border:1px solid rgba(255,255,255,0.7);
      margin-left:0.5rem;
    }
    .btn-theme:hover {
      background:rgba(255,255,255,0.9);
      color:#341539;
    }
  </style>
</head>
<body>
  <div class="header-container">
    <h1>Customer Details</h1>
  </div>

  <div class="dashboard-wrapper">
    <div class="dashboard-container">
      <div class="container-header">
        Customer ID: {{ $customer->customer_id }}
      </div>

      <div style="position: relative;">
        <table class="data-table">
          <tbody>
            <tr>
              <td class="label">First Name:</td>
              <td>{{ $customer->first_name }}</td>
              <td class="label">Last Name:</td>
              <td>{{ $customer->last_name }}</td>
            </tr>
            <tr>
              <td class="label">SSN:</td>
              <td>{{ $customer->social_security_num }}</td>
              <td class="label">Phone:</td>
              <td>{{ $customer->phone }}</td>
            </tr>
            <tr>
              <td class="label">Email:</td>
              <td>{{ $customer->email }}</td>
              <td class="label">Business Type:</td>
              <td>{{ $customer->type_of_business }}</td>
            </tr>
            <tr>
              <td class="label">Time in Business:</td>
              <td>{{ $customer->time_in_business }}</td>
              <td class="label">Business Phone:</td>
              <td>{{ $customer->business_phone }}</td>
            </tr>
            <tr>
              <td class="label">Loan Officer ID:</td>
              <td>{{ $customer->staff_username }}</td>
              <td class="label">Registered On:</td>
              <td>{{ $customer->created_at->format('F j, Y') }}</td>
            </tr>
            <tr>
              <td class="label">Status:</td>
              <td>{{ $customer->status }}</td>
              <td class="label">Active Loan Account:</td>
              <td>{{ $customer->active_loan_account ?? 'N/A' }}</td>
            </tr>

            @if($customer->address)
            <tr>
              <td class="label">Street:</td>
              <td>{{ $customer->address->street }}</td>
              <td class="label">City:</td>
              <td>{{ $customer->address->city }}</td>
            </tr>
            <tr>
              <td class="label">State:</td>
              <td>{{ $customer->address->state }}</td>
              <td class="label">Zip:</td>
              <td>{{ $customer->address->zipcode }}</td>
            </tr>
             <tr>
              <td class="label">Branch name:</td>
              <td>{{ $customer->branch->branch_name }}</td>
              <td class="label">Branch email:</td>
              <td>{{ $customer->branch->branch_email }}</td>
            </tr>
            <tr>
              <td class="label">Branch address:</td>
              <td>{{ $customer->branch?->address?->street ?? '—'  }},{{$customer->branch->address?->zipcode ?? '—'}}</td>
              <td class="label">Branch phone:</td>
              <td>{{ $customer->branch->branch_phone }}</td>
            </tr>
            @endif
          </tbody>
        </table>
        <div class="divider-left"></div>
      </div>

      <div class="btn-row">
        <a href="{{url('loanApplicationForm')}}?id={{$customer->customer_id}}" id="pending" name="pending"class="btn btn-theme">{{ $customer->status_button_text ?? 'Under Process' }}</a>
        <button type="button" class="btn btn-theme" onclick="window.print()">Print Detail</button>
        <a href="{{ url()->previous() }}" class="btn btn-theme">Back</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
