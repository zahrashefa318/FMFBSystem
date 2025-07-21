<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Receptionist Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
 <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
  <!-- Main header -->
  <div class="dashboard-header">Receptionist Dashboard</div>
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

  <div class="wrapper">
    <div class="dashboard">
      <!-- Left panel: Repeat Applicant -->
      <div class="sidebar">
        <form action="search_ssn" method="POST">
    @csrf

    <div class="mb-3">
        <label for="ssn-search" class="form-label">Search by SSN</label>
        <input
            type="text"
            id="ssn-search"
            name="ssn"
            class="form-control"
  
            required
        >
    </div>

    <button type="submit" class="btn btn-custom w-100 mb-3">
        🔍 Search SSN
    </button>
</form>

<div class="mb-3">
  <textarea 
    class="form-control" 
    rows="6" 
    style="white-space: pre-wrap; padding-left: 0; text-indent: 0;" 
    readonly 
    placeholder="Details...">@if(session('customerInfo'))
    Name: {{ session('customerInfo')->first_name }}
    Last name: {{ session('customerInfo')->last_name }}
    RegistrationDate: {{ session('customerInfo')->registrationdate }}
    Status: {{ session('customerInfo')->status }}
    @elseif (session('message'))
    {{ session('message') }}
    @endif</textarea>
    </div>


        <h4>Repeat applicant</h4>

        <div class="mb-3">
          <label for="repeat-ssn" class="form-label">SSN</label>
          <input type="text" id="repeat-ssn" class="form-control" name="repeatSsn">
        </div>

        <div class="row g-2 mb-3">
          <div class="col">
            <label for="repeat-date" class="form-label text-white">Date</label>
            <input type="date" id="repeat-date" class="form-control" name="repeatDate">
          </div>
          <div class="col">
            <label for="repeat-status" class="form-label text-white">Status</label>
            <select id="repeat-status" class="form-select" name="repeatStatus">
              <option value="" selected>Select status…</option>
              <option>New</option>
            </select>
          </div>
        </div>

        <button class="btn btn-custom w-100 mb-3">Submit</button>
        <a href="#" class="logout-link">Logout</a>
      </div>

      <!-- Right panel: Customer Information Form -->
      <div class="content">
        <div class="form-fixed">
          <div class="container py-3">
            <h2 class="text-center text-white">Customer Information Form</h2>
            <form class="custom-form mx-auto" style="max-width: 600px;" action="{{route('to_customertbl')}}" method="POST">
              @csrf
              <div class="row mb-3">
                <div class="col">
                  <label for="firstName" class="form-label text-white">First Name</label>
                  <input type="text" inputmode="text" pattern="[A-Za-zÀ-ÖØ-öø-ÿ' -]{2,30}"  title="2–30 letters, spaces, hyphens or apostrophes" class="form-control" name="firstName" id="firstName" required>
                </div>
                <div class="col">
                  <label for="lastName" class="form-label text-white">Last Name</label>
                  <input type="text" inputmode="text" pattern="[A-Za-zÀ-ÖØ-öø-ÿ' -]{2,30}"  title="2–30 letters, spaces, hyphens or apostrophes" class="form-control" name="lastName" id="lastName" required>
                </div>
              </div>

              <div class="mb-3">
                <label for="ssn" class="form-label text-white"  >Social Security Number</label>
           
                <input type="text"  inputmode="numeric" class="form-control" name="ssn" id="ssn" required>
              </div>

              <div class="row mb-3">
                <div class="col">
                  <label for="phone" class="form-label text-white">Phone Number</label>
                  <input type="tel"  inputmode="tel"  maxlength="14" placeholder="(123) 456-7890"  class="form-control" name="phone" id="phone" required>
                </div>
                <div class="col">
                  <label for="email" class="form-label text-white">Email Address</label>
                  <input type="email" inputmode="email" placeholder="you@example.com" pattern="^[^@\s]+@[^@\s]+\.[^@\s]+$" title="Enter a valid email address (e.g., you@example.com)" class="form-control" name="email" id="email" required>
                </div>
              </div>

              <div class="mb-3">
                <label for="businessType" class="form-label text-white">Type of Business</label>
                <select class="form-select" name="businessType" id="businessType" required>
                  <option value="">Select…</option>
                  <option>Retail Trade</option>
                  <option>Accommodation & Food Services</option>
                  <option>Repair & Maintenance Services</option>
                  <option>Hospitality</option>
                  <option>Goods‑Producing Sectors</option>
                </select>
              </div>

              <div class="mb-3">
                <label for="timeInBusiness" class="form-label text-white">Time in Business</label>
                <input type="text" inputmode="numeric" pattern="[0-9]*"  class="form-control" name="timeInBusiness" id="timeInBusiness" placeholder="Enter number of years." required>
              </div>

              <div class="mb-3">
                    <label class="form-label text-white">Business Address</label>
                    <div class="row gx-2">
                      <div class="col">
                        <input type="text" class="form-control" name="addrStreet" id="addrStreet" placeholder="Street" required>
                      </div>
                      <div class="col">
                        <input type="text" class="form-control" name="addrCity" id="addrCity" placeholder="City" required>
                      </div>
                      <div class="col">
                        <input type="text" class="form-control" name="addrState" id="addrState" placeholder="State" required>
                      </div>
                    </div>
                  </div>


              <div class="row mb-3">
                <div class="col">
                  <label for="zipcode" class="form-label text-white">Zip Code</label>
                  <input type="text" class="form-control" name="zipcode" id="zipcode" required>
                </div>
                <div class="col">
                  <label for="businessPhone" class="form-label text-white">Business Phone</label>
                  <input type="tel" inputmode="tel"  maxlength="14" placeholder="(123) 456-7890" class="form-control" name="businessPhone" id="businessPhone" required>
                </div>
              </div>

              <div class="mb-3">
                <label for="registrationDate" class="form-label text-white">Date of Registration</label>
                <input type="date" class="form-control" name="registrationDate" id="registrationDate" required>
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
  <script>
  const input = document.getElementById('ssn');
  const input2 = document.getElementById('ssn-search');
  const ssnStrictPattern = /^(?!(000|666|9\d{2}))\d{3}-(?!00)\d{2}-(?!0000)\d{4}$/;
  const phoneInput = document.getElementById('phone');
  const phoneInput2 = document.getElementById('businessPhone');


  function fixSSN(val) {
    // strip non-digits and limit to 9
    let digits = val.replace(/\D/g, '').slice(0, 9);
    return digits
      .replace(/(\d{3})(\d{2})(\d{0,4})/, (m, a, b, c) =>
        `${a}-${b}${c ? '-' + c : ''}`
      );
  }

  input.addEventListener('input', e => {
    const cursorPos = e.target.selectionStart;
    const oldLength = e.target.value.length;
    e.target.value = fixSSN(e.target.value);
    const newLength = e.target.value.length;
    // maintain caret position roughly
    e.target.setSelectionRange(cursorPos + (newLength - oldLength), cursorPos + (newLength - oldLength));
  });

  input.addEventListener('blur', e => {
    const valid = ssnStrictPattern.test(e.target.value);

    if (!valid && e.target.value !== '') {
      alert('Invalid SSN format; expected 123-45-6789');
      e.target.focus();
    }
  });
// Sanitization and validation for ssn-search field :

  input2.addEventListener('input', e => {
    const cursorPos = e.target.selectionStart;
    const oldLength = e.target.value.length;
    e.target.value = fixSSN(e.target.value);
    const newLength = e.target.value.length;
    // maintain caret position roughly
    e.target.setSelectionRange(cursorPos + (newLength - oldLength), cursorPos + (newLength - oldLength));
  });

  input2.addEventListener('blur', e => {
     const valid = ssnStrictPattern.test(e.target.value);
    if (!valid && e.target.value !== '') {
      alert('Invalid SSN format; expected 123-45-6789');
      e.target.focus();
    }
  });

  //phone inputs sanitization:
  function fixPhone(val) {
  const digits = val.replace(/\D/g, '').slice(0, 10);
  return digits
    .replace(/(\d{3})(\d{3})(\d{0,4})/, (m, a, b, c) =>
      `(${a}) ${b}${c ? '-' + c : ''}`
    );
}



phoneInput.addEventListener('input', e => {
  const pos = e.target.selectionStart;
  const before = e.target.value.length;
  e.target.value = fixPhone(e.target.value);
  const after = e.target.value.length;
  e.target.setSelectionRange(pos + (after - before), pos + (after - before));
});

phoneInput.addEventListener('blur', e => {
  const valid = /^\(\d{3}\) \d{3}-\d{4}$/.test(e.target.value);
  if (e.target.value !== '' && !valid) {
    alert('Invalid phone format; expected (123) 456-7890');
    e.target.focus();
  }
});

//Sanitization for business phone input:
  phoneInput2.addEventListener('input', e => {
  const pos = e.target.selectionStart;
  const before = e.target.value.length;
  e.target.value = fixPhone(e.target.value);
  const after = e.target.value.length;
  e.target.setSelectionRange(pos + (after - before), pos + (after - before));
});

phoneInput2.addEventListener('blur', e => {
  const valid = /^\(\d{3}\) \d{3}-\d{4}$/.test(e.target.value);
  if (e.target.value !== '' && !valid) {
    alert('Invalid phone format; expected (123) 456-7890');
    e.target.focus();
  }
});

//name and last name inputs sanitization:
const NAME_REGEX = /^[A-Za-zÀ-ÖØ-öø-ÿ' -]{2,30}$/;

function attachNameValidator(el, nameType) {
  el.addEventListener('blur', e => {
    const val = e.target.value.trim();
    const isValid = NAME_REGEX.test(val);
    if (val !== '' && !isValid) {
      alert(`Invalid ${nameType}; please use 2–30 letters, spaces, hyphens, or apostrophes.`);
      el.focus();
    }
  });
  
  el.addEventListener('input', e => {
    // Clears a previously set invalid state as user types
    if (NAME_REGEX.test(e.target.value.trim())) {
      e.target.setCustomValidity('');
    }
  });
}

const nameField = document.getElementById('firstName');

nameField.addEventListener('input', e => {
  e.target.value = e.target.value.replace(/[0-9]/g, '');
});
const nameField2 = document.getElementById('lastName');

nameField2.addEventListener('input', e => {
  e.target.value = e.target.value.replace(/[0-9]/g, '');
});

attachNameValidator(document.getElementById('firstName'), 'first name');
attachNameValidator(document.getElementById('lastName'), 'last name');

//validation for email input:
  const emailInput = document.getElementById('email');
const emailRegex = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;

emailInput.addEventListener('blur', e => {
  const val = e.target.value.trim();
  if (val !== '' && !emailRegex.test(val)) {
    alert('Please enter a valid email address (e.g., you@example.com).');
    emailInput.focus();
  }
});


// validation for time in business input:
 const timeInBusiness = document.getElementById('timeInBusiness');

  timeInBusiness.addEventListener('keypress', e => {
    const char = String.fromCharCode(e.which || e.keyCode);
    // Allow only digits 0–9
    if (!/[0-9]/.test(char)) {
      e.preventDefault(); // Block the keystroke
    }
  });
   timeInBusiness.addEventListener('paste', e => {
    const pasted = (e.clipboardData || window.clipboardData).getData('text');
    if (!/^\d*$/.test(pasted)) {
      e.preventDefault();
    }
  });

  timeInBusiness.addEventListener('blur', e => {
    let value = e.target.value.replace(/\D/g, '') || '';
    if (value !== '') {
      let num = parseInt(value, 10);
      if (num < 3) num = 3;
      if (num > 50) num = 50;
      e.target.value = num;
    }
  });

  //validation for zipcode input:
const zipInput = document.getElementById('zipcode');
const zipRegex = /^\d{5}(?:-\d{4})?$/;

// On form submission or input check:
zipInput.addEventListener('input', () => {
  const value = zipInput.value; // This is a string
  if (zipRegex.test(value)) {
    zipInput.setCustomValidity('');
  } else {
    zipInput.setCustomValidity('Enter a valid 5-digit ZIP or ZIP+4 code');
  }
});



</script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
