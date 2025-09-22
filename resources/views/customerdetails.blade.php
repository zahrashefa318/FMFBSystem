{{-- resources/views/customerdetails.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf‑8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Customer Details</title>
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

    /* 1) Lock the 4-column layout so the divider at 50% lines up cleanly */
table.data-table { table-layout: fixed; } /* you already have this */
table.data-table td:nth-child(1) { width: 22%; }  /* label L */
table.data-table td:nth-child(2) { width: 28%; }  /* value L */
table.data-table td:nth-child(3) { width: 22%; }  /* label R */
table.data-table td:nth-child(4) { width: 28%; }  /* value R */

/* 2) Make inputs obey the cell width (no spill past the divider) */
table.data-table input,
table.data-table select,
table.data-table textarea {
  width: 100%;
  max-width: 100%;
  box-sizing: border-box;   /* include padding/border in the width */
  display: block;           /* prevent inline overflow quirks */
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

    /* === Flash (scoped) === */
.fmfb-flash {
  --accent: #60a5fa;                 /* default (info) */
  --bg: rgba(255,255,255,0.08);      /* looks good on your #341539 panel */
  --fg: #fff;
  --border: rgba(255,255,255,0.25);

  position: relative;
  margin: 12px 0;
  padding: 12px 16px 12px 14px;
  border: 1px solid var(--border);
  border-left: 6px solid var(--accent);
  border-radius: 10px;
  background: var(--bg);
  color: var(--fg);
  line-height: 1.35;
  font: inherit;
}

/* Variants (just set the accent color) */
.fmfb-flash--success { --accent:#34d399; } /* green */
.fmfb-flash--warning { --accent:#f59e0b; } /* amber */
.fmfb-flash--error   { --accent:#ef4444; } /* red   */

/* Close button (scoped) */
.fmfb-flash__close{
  position:absolute; top:8px; right:8px;
  background:transparent; border:0; color:var(--fg);
  font-size:18px; line-height:1; padding:6px; cursor:pointer;
}
.fmfb-flash__close:focus-visible{ outline:2px solid currentColor; outline-offset:2px; }

/* Gentle fade-in, but respect reduced-motion */
@media (prefers-reduced-motion: no-preference){
  .fmfb-flash{ animation: fmfb-fade .16s ease-out both; }
  @keyframes fmfb-fade { from {opacity:0; transform:translateY(-2px)} to {opacity:1; transform:none} }
}

  </style>
</head>
<body>
  <div class="header-container">
    <h1>Customer Details</h1>
  </div>

  <div class="dashboard-wrapper">
    <div class="dashboard-container">
      @if(!empty($customer))
      <div class="container-header">
        Customer ID: {{ $customer->customer_id }}
      </div>
{{-- Success --}}
@if (session('success'))
  <div class="fmfb-flash fmfb-flash--success" role="status" aria-live="polite">
    {{ session('success') }}
    <button type="button" class="fmfb-flash__close" data-close aria-label="Close">&times;</button>
  </div>
@endif

{{-- Warning / “Nothing changed” --}}
@if (session('warning'))
  <div class="fmfb-flash fmfb-flash--warning" role="status" aria-live="polite">
    {{ session('warning') }}
    <button type="button" class="fmfb-flash__close" data-close aria-label="Close">&times;</button>
  </div>
@endif

{{-- Errors --}}
@if (session('error'))
  <div class="fmfb-flash fmfb-flash--error" role="alert" aria-live="assertive">
    {{ session('error') }}
    <button type="button" class="fmfb-flash__close" data-close aria-label="Close">&times;</button>
  </div>
@endif

{{-- Validation errors (kept as-is, styled like error) --}}
@if ($errors->any())
  <div class="fmfb-flash fmfb-flash--error" role="alert" aria-live="assertive">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
    <button type="button" class="fmfb-flash__close" data-close aria-label="Close">&times;</button>
  </div>
@endif

       {{-- UPDATE: wrap fields in a form --}}
        <form id="customerForm"
              action="{{ route('customers.update', $customer->customer_id) }}"
              method="POST" novalidate>
          @csrf {{-- CSRF token is required for POST/PUT/PATCH/DELETE --}}
          @method('PATCH') {{-- method spoofing for RESTful update --}}

          {{-- Start locked/read-only fields --}}
          <fieldset id="detailsFieldset" disabled>
            <div style="position: relative;">
              <table class="data-table">
                <tbody>
                  <tr>
                    <td class="label">First Name:</td>
                    <td>
                      <input name="first_name" class="form-control form-control-plaintext"
                             value="{{ $customer->first_name }}" readonly>
                    </td>
                    <td class="label">Last Name:</td>
                    <td>
                      <input name="last_name" class="form-control form-control-plaintext"
                             value="{{ $customer->last_name }}" readonly>
                    </td>
                  </tr>

                  <tr>
                    <td class="label">SSN:</td>
                    <td>
                      <input name="social_security_num" class="form-control form-control-plaintext"
                             value="{{ $customer->social_security_num }}" readonly>
                    </td>
                    <td class="label">Phone:</td>
                    <td>
                      <input name="phone" class="form-control form-control-plaintext"
                             value="{{ $customer->phone }}" readonly>
                    </td>
                  </tr>

                  <tr>
                    <td class="label">Email:</td>
                    <td>
                      <input name="email" type="email" class="form-control form-control-plaintext"
                             value="{{ $customer->email }}" readonly>
                    </td>
                    <td class="label">Business Type:</td>
                    <td>
                      <input name="type_of_business" class="form-control form-control-plaintext"
                             value="{{ $customer->type_of_business }}" readonly>
                    </td>
                  </tr>

                  <tr>
                    <td class="label">Time in Business:</td>
                    <td>
                      <input name="time_in_business" class="form-control form-control-plaintext"
                             value="{{ $customer->time_in_business }}" readonly>
                    </td>
                    <td class="label">Business Phone:</td>
                    <td>
                      <input name="business_phone" class="form-control form-control-plaintext"
                             value="{{ $customer->business_phone }}" readonly>
                    </td>
                  </tr>

                  <tr>
                    <td class="label">Loan Officer ID:</td>
                    <td>
                      <input name="staff_username" class="form-control form-control-plaintext"
                             value="{{ $customer->staff_username }}" readonly>
                    </td>
                    <td class="label">Registered On:</td>
                    <td>
                      <input class="form-control form-control-plaintext"
                             value="{{ $customer->registrationdate }}" readonly>
                    </td>
                  </tr>

                  <tr>
                    <td class="label">Status:</td>
                    <td>
                      <input name="status" class="form-control form-control-plaintext"
                             value="{{ $customer->status }}" readonly>
                    </td>
                    <td class="label">Active Loan Account:</td>
                    <td>
                      <input class="form-control form-control-plaintext"
                             value="{{ $customer->active_loan_account ?? 'N/A' }}" readonly>
                    </td>
                  </tr>

                  @if($customer->address)
                  <tr>
                    <td class="label">Street:</td>
                    <td>
                      <input name="address[street]" class="form-control form-control-plaintext"
                             value="{{ $customer->address->street }}" readonly>
                    </td>
                    <td class="label">City:</td>
                    <td>
                      <input name="address[city]" class="form-control form-control-plaintext"
                             value="{{ $customer->address->city }}" readonly>
                    </td>
                  </tr>
                  <tr>
                    <td class="label">State:</td>
                    <td>
                      <input name="address[state]" class="form-control form-control-plaintext"
                             value="{{ $customer->address->state }}" readonly>
                    </td>
                    <td class="label">Zip:</td>
                    <td>
                      <input name="address[zipcode]" class="form-control form-control-plaintext"
                             value="{{ $customer->address->zipcode }}" readonly>
                    </td>
                  </tr>
                  @endif

                  <tr>
                    <td class="label">Branch name:</td>
                    <td>
                      <input class="form-control form-control-plaintext"
                             value="{{ $customer->branch->branch_name }}" readonly>
                    </td>
                    <td class="label">Branch email:</td>
                    <td>
                      <input class="form-control form-control-plaintext"
                             value="{{ $customer->branch->branch_email }}" readonly>
                    </td>
                  </tr>
                  <tr>
                    <td class="label">Branch address:</td>
                    <td>
                      <input class="form-control form-control-plaintext"
                             value="{{ $customer->branch?->address?->street ?? '—' }}, {{ $customer->branch->address?->zipcode ?? '—' }}"
                             readonly>
                    </td>
                    <td class="label">Branch phone:</td>
                    <td>
                      <input class="form-control form-control-plaintext"
                             value="{{ $customer->branch->branch_phone }}" readonly>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="divider-left"></div>
            </div>
          </fieldset>

          
          {{-- Buttons --}}
          <div class="btn-row">
            {{-- Edit shows by default; Save/Cancel hidden until edit mode --}}
            <button type="button" id="editBtn" class="btn btn-theme">Edit</button>
            <button type="submit" id="saveBtn" class="btn btn-theme d-none" disabled>Save changes</button>
            <button type="button" id="cancelBtn" class="btn btn-theme d-none">Cancel</button>

            {{-- keep your other buttons --}}
            @if(!empty($showButtons) && $showButtons)
              <a href="{{url('loanApplicationForm')}}?id={{$customer->customer_id}}" class="btn btn-theme">
                {{ $customer->status_button_text ?? 'Under Process' }}
              </a>
              <button type="button" class="btn btn-theme" onclick="window.print()">Print Detail</button>
            @endif
            <a href="{{ route('dashboard') }}" class="btn btn-theme">Back</a>
          </div>
        </form>

      @else
        <div class="alert alert-warning">{{ $error ?? 'No customer found.' }}</div>
      @endif

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  document.addEventListener('DOMContentLoaded', () => {
  const form      = document.getElementById('customerForm');
  const fieldset  = document.getElementById('detailsFieldset');
  const editBtn   = document.getElementById('editBtn');
  const saveBtn   = document.getElementById('saveBtn');
  const cancelBtn = document.getElementById('cancelBtn');

  if (!form || !fieldset || !editBtn || !saveBtn || !cancelBtn) return; // IDs must match

  // cache originals
  const original = new Map();
  const controls = fieldset.querySelectorAll('input,select,textarea');
  function cacheOriginals() {
    original.clear();
    controls.forEach(el => { if (el.name) original.set(el.name, el.value); });
  }
  function hasChanged() {
    for (const el of controls) {
      if (!el.name) continue;
      if ((original.get(el.name) ?? '') !== (el.value ?? '')) return true;
    }
    return false;
  }

  function enterEdit() {
    // 1) enable the fieldset
    fieldset.disabled = false; // MDN: disabled fieldset blocks editing/submit. :contentReference[oaicite:1]{index=1}
    // 2) remove readonly/disabled on each control and switch out of plaintext look
    controls.forEach(el => {
      el.readOnly = false;             // MDN: readOnly prevents editing. :contentReference[oaicite:2]{index=2}
      el.removeAttribute('readonly');
      el.disabled = false;
      el.classList.remove('form-control-plaintext'); // Bootstrap readonly-display utility. :contentReference[oaicite:3]{index=3}
    });
    // 3) buttons
    editBtn.classList.add('d-none');
    saveBtn.classList.remove('d-none');
    cancelBtn.classList.remove('d-none');
    saveBtn.disabled = true; // stays off until something changes
  }

  function exitEdit(restoreValues) {
    if (restoreValues) {
      controls.forEach(el => { if (el.name && original.has(el.name)) el.value = original.get(el.name); });
    }
    // lock again (optional—your choice)
    fieldset.disabled = true;
    controls.forEach(el => {
      el.readOnly = true;
      el.classList.add('form-control-plaintext');
    });
    saveBtn.classList.add('d-none');
    cancelBtn.classList.add('d-none');
    editBtn.classList.remove('d-none');
  }

  // wire up
  cacheOriginals();
  exitEdit(false); // start locked

  editBtn.addEventListener('click', (e) => { e.preventDefault(); enterEdit(); });
  cancelBtn.addEventListener('click', (e) => { e.preventDefault(); exitEdit(true); });

  // enable Save only when a value actually changed
  controls.forEach(el => {
    el.addEventListener('input',  () => saveBtn.disabled = !hasChanged());
    el.addEventListener('change', () => saveBtn.disabled = !hasChanged());
  });

  // final guard: don’t submit if nothing changed
  form.addEventListener('submit', (e) => {
    if (!hasChanged()) {
      e.preventDefault();
      // optional toast/alert here
    } else {
      // if you keep the form unlocked during submit, it will send field values.
      // (Disabled controls are NOT submitted per HTML spec/MDN.) :contentReference[oaicite:4]{index=4}
    }
  });
});

</script>
<!-- ---------script for close button of flash messages --------->
 <script>
  document.addEventListener('click', (e) => {
    if (e.target.matches('[data-close]')) {
      const box = e.target.closest('.fmfb-flash');
      if (box) box.remove();
    }
  });
</script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
