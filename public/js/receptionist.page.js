// resources/js/receptionist.page.js
document.addEventListener('DOMContentLoaded', () => {
  // ---- helpers ----
  const $ = (id) => document.getElementById(id);
  const on = (el, evt, fn) => el && el.addEventListener(evt, fn);

  // ---- your original code (unchanged), with null-safety guards ----
  const input   = $('ssn');
  const input2  = $('ssn-search');
  const input3  = $('repeat-ssn');
  const phoneInput  = $('phone');
  const phoneInput2 = $('businessPhone');
  const emailInput  = $('email');
  const timeInBusiness = $('timeInBusiness');
  const zipInput  = $('zipcode');

  const ssnStrictPattern = /^(?!(000|666|9\d{2}))\d{3}-(?!00)\d{2}-(?!0000)\d{4}$/;

  function fixSSN(val) {
    let digits = val.replace(/\D/g, '').slice(0, 9);
    return digits.replace(/(\d{3})(\d{2})(\d{0,4})/, (m, a, b, c) => `${a}-${b}${c ? '-' + c : ''}`);
  }

  on(input,  'input', (e) => {
    const pos = e.target.selectionStart, before = e.target.value.length;
    e.target.value = fixSSN(e.target.value);
    const after = e.target.value.length;
    e.target.setSelectionRange(pos + (after - before), pos + (after - before));
  });
  on(input,  'blur',  (e) => {
    const valid = ssnStrictPattern.test(e.target.value);
    if (!valid && e.target.value !== '') { alert('Invalid SSN format; expected 123-45-6789'); e.target.focus(); }
  });

  on(input2, 'input', (e) => {
    const pos = e.target.selectionStart, before = e.target.value.length;
    e.target.value = fixSSN(e.target.value);
    const after = e.target.value.length;
    e.target.setSelectionRange(pos + (after - before), pos + (after - before));
  });
  on(input2, 'blur',  (e) => {
    const valid = ssnStrictPattern.test(e.target.value);
    if (!valid && e.target.value !== '') { alert('Invalid SSN format; expected 123-45-6789'); e.target.focus(); }
  });

  on(input3, 'input', (e) => {
    const pos = e.target.selectionStart, before = e.target.value.length;
    e.target.value = fixSSN(e.target.value);
    const after = e.target.value.length;
    e.target.setSelectionRange(pos + (after - before), pos + (after - before));
  });
  on(input3, 'blur',  (e) => {
    const valid = ssnStrictPattern.test(e.target.value);
    if (!valid && e.target.value !== '') { alert('Invalid SSN format; expected 123-45-6789'); e.target.focus(); }
  });

  function fixPhone(val) {
    const digits = val.replace(/\D/g, '').slice(0, 10);
    const match = digits.match(/^(\d{3})(\d{3})(\d{0,4})$/);
    if (match) { const [_, a, b, c] = match; return `(${a}) ${b}${c ? '-' + c : ''}`; }
    return digits;
  }

  on(phoneInput, 'input', (e) => {
    const pos = e.target.selectionStart, before = e.target.value.length;
    e.target.value = fixPhone(e.target.value);
    const after = e.target.value.length;
    e.target.setSelectionRange(pos + (after - before), pos + (after - before));
  });
  on(phoneInput, 'blur', (e) => {
    const valid = /^\(\d{3}\) \d{3}-\d{4}$/.test(e.target.value);
    if (e.target.value !== '' && !valid) { alert('Invalid phone format; expected (123) 456-7890'); e.target.focus(); }
  });

  on(phoneInput2, 'input', (e) => {
    const pos = e.target.selectionStart, before = e.target.value.length;
    e.target.value = fixPhone(e.target.value);
    const after = e.target.value.length;
    e.target.setSelectionRange(pos + (after - before), pos + (after - before));
  });
  on(phoneInput2, 'blur', (e) => {
    const valid = /^\(\d{3}\) \d{3}-\d{4}$/.test(e.target.value);
    if (e.target.value !== '' && !valid) { alert('Invalid phone format; expected (123) 456-7890'); e.target.focus(); }
  });

  const NAME_REGEX = /^[A-Za-zÀ-ÖØ-öø-ÿ' -]{2,30}$/;
  function attachNameValidator(el, label) {
    if (!el) return;
    on(el, 'blur', (e) => {
      const val = e.target.value.trim();
      if (val !== '' && !NAME_REGEX.test(val)) { alert(`Invalid ${label}; please use 2–30 letters, spaces, hyphens, or apostrophes.`); el.focus(); }
    });
    on(el, 'input', (e) => { if (NAME_REGEX.test(e.target.value.trim())) e.target.setCustomValidity(''); });
  }
  const firstName = $('firstName');
  const lastName  = $('lastName');
  on(firstName, 'input', (e) => { e.target.value = e.target.value.replace(/[0-9]/g, ''); });
  on(lastName,  'input', (e) => { e.target.value = e.target.value.replace(/[0-9]/g, ''); });
  attachNameValidator(firstName, 'first name');
  attachNameValidator(lastName,  'last name');

  const emailRegex = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
  on(emailInput, 'blur', (e) => {
    const val = e.target.value.trim();
    if (val !== '' && !emailRegex.test(val)) { alert('Please enter a valid email address (e.g., you@example.com).'); emailInput.focus(); }
  });

  on(timeInBusiness, 'keypress', (e) => {
    const char = String.fromCharCode(e.which || e.keyCode);
    if (!/[0-9]/.test(char)) e.preventDefault();
  });
  on(timeInBusiness, 'paste', (e) => {
    const pasted = (e.clipboardData || window.clipboardData).getData('text');
    if (!/^\d*$/.test(pasted)) e.preventDefault();
  });
  on(timeInBusiness, 'blur', (e) => {
    let value = e.target.value.replace(/\D/g, '') || '';
    if (value !== '') {
      let num = parseInt(value, 10);
      if (num < 3) num = 3;
      if (num > 50) num = 50;
      e.target.value = num;
    }
  });

  const zipRegex = /^\d{5}$/;
  on(zipInput, 'keypress', (e) => { if (!/^[0-9]$/.test(e.key)) e.preventDefault(); });
  on(zipInput, 'blur', () => {
    const value = zipInput.value;
    if (zipRegex.test(value)) zipInput.setCustomValidity('');
    else zipInput.setCustomValidity('Please enter exactly 5 digits (leading zeros allowed)');
    zipInput.reportValidity();
  });
});
