// Keep signatures crisp and validations active.
// Uses class-based selectors, and selects canvases via tag name.

document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('form');
  if (!form) return;

  const on = (el, evt, fn) => el && el.addEventListener(evt, fn);
  const byClass = (cls) => Array.from(document.getElementsByClassName(cls));

  // Phone validation/format
  const PHONE_RE = /^\(\d{3}\) \d{3}-\d{4}$/;
  const formatPhone = (v) => {
    const d = v.replace(/\D/g, '').slice(0, 10);
    const m = d.match(/^(\d{0,3})(\d{0,3})(\d{0,4})$/);
    if (!m) return v;
    const [, a, b, c] = m;
    return !b ? a : `(${a}) ${b}${c ? '-' + c : ''}`;
  };
  byClass('phone-field').forEach((el) => {
    on(el, 'input', (e) => { e.target.value = formatPhone(e.target.value); });
    on(el, 'blur', () => {
      if (el.value && !PHONE_RE.test(el.value)) el.setCustomValidity('Phone must be in format (123) 456-7890');
      else el.setCustomValidity('');
      el.reportValidity();
    });
  });

  // Email
  const EMAIL_RE = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
  byClass('email-field').forEach((el) => {
    on(el, 'blur', () => {
      if (el.value && !EMAIL_RE.test(el.value)) el.setCustomValidity('Enter a valid email like you@example.com');
      else el.setCustomValidity('');
      el.reportValidity();
    });
  });

  // Names
  const NAME_RE = /^[A-Za-zÀ-ÖØ-öø-ÿ' -]{2,60}$/;
  byClass('name-field').forEach((el) => {
    on(el, 'input', (e) => { e.target.value = e.target.value.replace(/\d+/g, ''); });
    on(el, 'blur', () => {
      if (el.value && !NAME_RE.test(el.value.trim())) el.setCustomValidity(`Invalid ${el.dataset.label || 'name'}; use letters, spaces, hyphens, apostrophes (2–60 chars).`);
      else el.setCustomValidity('');
      el.reportValidity();
    });
  });

  // ZIPs
  const ZIP_RE = /^\d{5}$/;
  byClass('zip-field').forEach((el) => {
    on(el, 'keypress', (e) => { if (!/[0-9]/.test(e.key)) e.preventDefault(); });
    on(el, 'blur', () => {
      if (el.value && !ZIP_RE.test(el.value)) el.setCustomValidity('Please enter exactly 5 digits (leading zeros allowed)');
      else el.setCustomValidity('');
      el.reportValidity();
    });
  });

  // Numeric ranges
  const loanAmt = document.getElementById('loan_amount');
  on(loanAmt, 'blur', () => {
    const n = Number(loanAmt.value);
    if (loanAmt.value && !(n > 0 && n <= 10000000)) loanAmt.setCustomValidity('Enter a positive amount (≤ 10,000,000).');
    else loanAmt.setCustomValidity('');
    loanAmt.reportValidity();
  });

  const term = document.getElementById('repayment_term_months');
  on(term, 'blur', () => {
    const n = parseInt(term.value, 10);
    if (term.value && (!Number.isInteger(n) || n < 1 || n > 360)) term.setCustomValidity('Enter an integer number of months (1–360).');
    else term.setCustomValidity('');
    term.reportValidity();
  });

  const rate = document.getElementById('interest_rate');
  on(rate, 'blur', () => {
    if (!rate || !rate.value) { rate?.setCustomValidity(''); return; }
    const ok = /^(\d{1,2}(\.\d{1,2})?|100(\.0{1,2})?)$/.test(rate.value);
    rate.setCustomValidity(ok ? '' : 'Rate must be 0–100 with up to 2 decimals (e.g., 7.5).');
    rate.reportValidity();
  });

  // === Signature Pads via <canvas> tag selection ===
  const canvases = Array.from(document.getElementsByTagName('canvas'));
  let customerPad = null, guarantorPad = null;

  canvases.forEach((canvas) => {
    if (canvas.id === 'signature-pad-customer') {
      customerPad = new SignaturePad(canvas, { penColor: 'black' });
    } else if (canvas.id === 'signature-pad-guarantor') {
      guarantorPad = new SignaturePad(canvas, { penColor: 'black' });
    }
  });

  // DPI-aware resize (per signature_pad guidance)
  function resizePad(canvas, pad) {
    if (!canvas || !pad) return;
    const ratio = Math.max(window.devicePixelRatio || 1, 1);
    canvas.width  = canvas.offsetWidth  * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext('2d').setTransform(ratio, 0, 0, ratio, 0, 0);
    pad.clear();
  }
  const resizeAll = () => canvases.forEach((c) => {
    const pad = c.id === 'signature-pad-customer' ? customerPad
              : c.id === 'signature-pad-guarantor' ? guarantorPad
              : null;
    resizePad(c, pad);
  });
  window.addEventListener('resize', resizeAll);
  resizeAll();

  // Clear buttons
  on(document.getElementById('clear-signature-customer'),  'click', () => customerPad?.clear());
  on(document.getElementById('clear-signature-guarantor'), 'click', () => guarantorPad?.clear());

  // Final submit gate
  on(form, 'submit', (e) => {
    let ok = true;
    byClass('phone-field').forEach((el) => {
      if (el.value && !PHONE_RE.test(el.value)) { el.reportValidity(); ok = false; }
    });
    if (customerPad && customerPad.isEmpty()) { alert('Please provide the customer signature.'); ok = false; }
    if (guarantorPad && guarantorPad.isEmpty()) { alert('Please provide the guarantor signature.'); ok = false; }
    if (!ok) { e.preventDefault(); return; }

    // Put signature images into hidden inputs
    const custHidden = document.getElementById('customer_signature');
    const guarHidden = document.getElementById('guarantor_signature');
    if (custHidden && customerPad)  custHidden.value  = customerPad.toDataURL();
    if (guarHidden && guarantorPad) guarHidden.value = guarantorPad.toDataURL();
  });
});
