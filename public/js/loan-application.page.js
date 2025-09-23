// validators.js
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
    on(el, 'paste', (e) => {
      const t = (e.clipboardData || window.clipboardData).getData('text');
      if (!/^\d+$/.test(t)) e.preventDefault();
    });
    on(el, 'input', () => {
      const cleaned = el.value.replace(/\D+/g, '').slice(0, 5);
      if (cleaned !== el.value) el.value = cleaned;
    });
    on(el, 'blur', () => {
      if (el.value && !ZIP_RE.test(el.value)) el.setCustomValidity('Please enter exactly 5 digits (leading zeros allowed)');
      else el.setCustomValidity('');
      el.reportValidity();
    });
  });

  // Loan amount: digits only + existing range check
  const loanAmt = document.getElementById('loan_amount');
  if (loanAmt) {
    on(loanAmt, 'keypress', (e) => {
      const ch = String.fromCharCode(e.which || e.keyCode);
      const isCtrl = e.which === 0 || e.keyCode < 32;
      if (!/[0-9]/.test(ch) && !isCtrl) e.preventDefault();
    });
    on(loanAmt, 'paste', (e) => {
      const t = (e.clipboardData || window.clipboardData).getData('text');
      if (!/^\d+$/.test(t)) e.preventDefault();
    });
    on(loanAmt, 'input', () => {
      const cleaned = loanAmt.value.replace(/\D+/g, '');
      if (cleaned !== loanAmt.value) loanAmt.value = cleaned;
    });
    on(loanAmt, 'blur', () => {
      const n = Number(loanAmt.value);
      if (loanAmt.value && !(n > 0 && n <= 10000000)) loanAmt.setCustomValidity('Enter a positive amount (≤ 10,000,000).');
      else loanAmt.setCustomValidity('');
      loanAmt.reportValidity();
    });
  }

  // Term (months) digits only
  const term = document.getElementById('repayment_term_months');
  if (term) {
    on(term, 'keypress', (e) => {
      const ch = String.fromCharCode(e.which || e.keyCode);
      const isCtrl = e.which === 0 || e.keyCode < 32;
      if (!/[0-9]/.test(ch) && !isCtrl) e.preventDefault();
    });
    on(term, 'paste', (e) => {
      const t = (e.clipboardData || window.clipboardData).getData('text');
      if (!/^\d+$/.test(t)) e.preventDefault();
    });
    on(term, 'input', () => {
      const cleaned = term.value.replace(/\D+/g, '');
      if (cleaned !== term.value) term.value = cleaned;
    });
    on(term, 'blur', () => {
      const n = parseInt(term.value, 10);
      if (term.value && (!Number.isInteger(n) || n < 1 || n > 360)) term.setCustomValidity('Enter an integer number of months (1–360).');
      else term.setCustomValidity('');
      term.reportValidity();
    });
  }

  // Interest rate
  const rate = document.getElementById('interest_rate');
  if (rate) {
    on(rate, 'beforeinput', (e) => {
      const data = e.data;
      const isDelete = /^delete/i.test(e.inputType);
      if (isDelete || !data) return;
      const start = rate.selectionStart ?? rate.value.length;
      const end = rate.selectionEnd ?? rate.value.length;
      const insert = data === ',' ? '.' : data;
      const next = rate.value.slice(0, start) + insert + rate.value.slice(end);
      if (!/^\d{0,1}(\.\d{0,4})?$/.test(next)) e.preventDefault();
    });
    on(rate, 'paste', (e) => {
      let t = (e.clipboardData || window.clipboardData).getData('text');
      t = t.replace(',', '.');
      if (!/^\d{0,1}(\.\d{0,4})?$/.test(t)) e.preventDefault();
    });
    on(rate, 'keypress', (e) => {
      const ch = String.fromCharCode(e.which || e.keyCode);
      const isCtrl = e.which === 0 || e.keyCode < 32;
      const ok = /[0-9]/.test(ch) || ((ch === '.' || ch === ',') && !rate.value.includes('.'));
      if (!ok && !isCtrl) e.preventDefault();
    });
    on(rate, 'input', () => {
      rate.value = rate.value.replace(',', '.').trim();
      const v = rate.value;
      if (!v) { rate.setCustomValidity(''); return; }
      const decOk = /^\d(?:\.\d{1,4})?$/.test(v);
      const num = Number(v);
      const inRange = num >= 0 && num <= 9.9999;
      rate.setCustomValidity(decOk && inRange ? '' : 'Enter a rate between 0.0000 and 9.9999 (up to 4 decimals).');
      rate.reportValidity();
    });
    on(rate, 'blur', () => {
      rate.value = rate.value.replace(',', '.').trim();
      const v = rate.value;
      if (!v) { rate.setCustomValidity(''); return; }
      const decOk = /^\d(?:\.\d{1,4})?$/.test(v);
      const num = Number(v);
      const inRange = num >= 0 && num <= 9.9999;
      rate.setCustomValidity(decOk && inRange ? '' : 'Enter a rate between 0.0000 and 9.9999 (up to 4 decimals).');
      rate.reportValidity();
    });
  }

  // Signature Pads
  const canvases = Array.from(document.getElementsByTagName('canvas'));
  let customerPad = null, guarantorPad = null;

  canvases.forEach((canvas) => {
    if (canvas.id === 'signature-pad-customer') {
      customerPad = new SignaturePad(canvas, { penColor: 'black' });
    } else if (canvas.id === 'signature-pad-guarantor') {
      guarantorPad = new SignaturePad(canvas, { penColor: 'black' });
    }
  });

  function resizePad(canvas, pad) {
    if (!canvas || !pad) return;
    const ratio = Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
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

  on(document.getElementById('clear-signature-customer'), 'click', () => customerPad?.clear());
  on(document.getElementById('clear-signature-guarantor'), 'click', () => guarantorPad?.clear());

  // Final submit gate
  on(form, 'submit', (e) => {
    let ok = true;

    byClass('phone-field').forEach((el) => {
      if (el.value && !PHONE_RE.test(el.value)) { el.reportValidity(); ok = false; }
    });

    if (rate) {
      // trigger validation
      rate.dispatchEvent(new Event('input', { bubbles: true }));
      if (!rate.checkValidity()) { rate.reportValidity(); ok = false; }
    }

    if (loanAmt) {
      if (!/^\d+$/.test(loanAmt.value)) {
        loanAmt.setCustomValidity('Please enter a valid whole number amount.');
        loanAmt.reportValidity();
        ok = false;
      } else {
        loanAmt.setCustomValidity('');
      }
    }

    if (term) {
      if (!/^\d+$/.test(term.value)) {
        term.setCustomValidity('Please enter a valid whole number of months.');
        term.reportValidity();
        ok = false;
      } else {
        term.setCustomValidity('');
      }
    }

    if (customerPad && customerPad.isEmpty()) { alert('Please provide the customer signature.'); ok = false; }
    if (guarantorPad && guarantorPad.isEmpty()) { alert('Please provide the guarantor signature.'); ok = false; }

    if (!ok) { e.preventDefault(); return; }

    const custHidden = document.getElementById('customer_signature');
    const guarHidden = document.getElementById('guarantor_signature');
    if (custHidden && customerPad) custHidden.value = customerPad.toDataURL();
    if (guarHidden && guarantorPad) guarHidden.value = guarantorPad.toDataURL();
  });
});
