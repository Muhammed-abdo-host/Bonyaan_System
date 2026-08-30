// Bonyaan Cost Estimator - Backend-connected version.
// Overrides the mock/localStorage versions of these same function names
// defined in app.js. Load this file AFTER app.js in the layout.

function getCsrfToken() {
  return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
}

function readEstimatorForm() {
  const area = parseInt(document.getElementById('est-area')?.value || 450, 10);
  const floors = parseInt(document.getElementById('est-floors')?.value || 2, 10);
  const type = document.querySelector('input[name="est-type"]:checked')?.value || 'villa';
  const tier = document.querySelector('input[name="est-tier"]:checked')?.value || 'deluxe';

  const extras = [];
  if (document.getElementById('est-extra-pool')?.checked) extras.push('pool');
  if (document.getElementById('est-extra-smart')?.checked) extras.push('smart');
  if (document.getElementById('est-extra-solar')?.checked) extras.push('solar');
  if (document.getElementById('est-extra-landscape')?.checked) extras.push('landscape');

  return { area, floors, type, tier, extras };
}

function formatMoney(n) {
  return `$${Number(n).toLocaleString()}`;
}

let calcDebounceTimer = null;
function calculateCost() {
  clearTimeout(calcDebounceTimer);
  calcDebounceTimer = setTimeout(runCalculateCost, 150);
}

async function runCalculateCost() {
  const form = readEstimatorForm();

  if (document.getElementById('est-area-val')) {
    document.getElementById('est-area-val').innerText = `${form.area.toLocaleString()} m²`;
  }
  if (document.getElementById('est-floors-val')) {
    document.getElementById('est-floors-val').innerText = `${form.floors} Floors`;
  }

  try {
    const res = await fetch('/estimator/calculate', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken(),
      },
      body: JSON.stringify(form),
    });

    if (!res.ok) throw new Error(`Estimate request failed (${res.status})`);
    const data = await res.json();

    window.lastEstimate = { ...form, ...data };

    if (document.getElementById('est-output-total')) document.getElementById('est-output-total').innerText = formatMoney(data.total);
    if (document.getElementById('est-output-sqm')) document.getElementById('est-output-sqm').innerText = `~ ${formatMoney(data.cost_per_sqm)} / m²`;
    if (document.getElementById('est-output-months')) document.getElementById('est-output-months').innerText = `${data.estimated_months} Months`;
    if (document.getElementById('est-breakdown-struct')) document.getElementById('est-breakdown-struct').innerText = formatMoney(data.breakdown.structure);
    if (document.getElementById('est-breakdown-finishes')) document.getElementById('est-breakdown-finishes').innerText = formatMoney(data.breakdown.finishes);
    if (document.getElementById('est-breakdown-mep')) document.getElementById('est-breakdown-mep').innerText = formatMoney(data.breakdown.mep);
  } catch (err) {
    console.error('Estimator error:', err);
    if (typeof showToast === 'function') showToast('Could not calculate estimate. Please try again.', 'error');
  }
}

function applyEstimateToQuote() {
  if (window.lastEstimate) {
    localStorage.setItem('met_estimator_preset', JSON.stringify(window.lastEstimate));
  }
  window.location.href = '/quote';
}

function checkQuotePreset() {
  const alertBox = document.getElementById('quote-preset-alert');
  const presetRaw = localStorage.getItem('met_estimator_preset');
  if (!presetRaw) return;

  try {
    const preset = JSON.parse(presetRaw);
    if (document.getElementById('quote-area')) document.getElementById('quote-area').value = `${preset.area} sq.m`;
    if (document.getElementById('quote-budget')) document.getElementById('quote-budget').value = formatMoney(preset.total);
    if (document.getElementById('quote-notes')) {
      document.getElementById('quote-notes').value =
        `Pre-calculated estimate: ${preset.floors} floors, ${preset.tier} tier. Estimated duration: ${preset.estimated_months} months.`;
    }
    if (alertBox) alertBox.style.display = 'flex';

    window.appliedEstimate = preset;
    localStorage.removeItem('met_estimator_preset');
  } catch (err) {
    console.error('Could not parse saved estimate:', err);
  }
}

async function submitQuoteForm(e) {
  e.preventDefault();

  const recaptcha = document.getElementById('quote-recaptcha');
  if (recaptcha && !recaptcha.checked) {
    alert('Please check the reCAPTCHA verification box.');
    return;
  }

  const preset = window.appliedEstimate || null;

  const payload = {
    name: document.getElementById('quote-name')?.value || '',
    email: document.getElementById('quote-email')?.value || '',
    phone: document.getElementById('quote-phone')?.value || '',
    location: document.getElementById('quote-location')?.value || '',
    type: preset?.type || null,
    area: preset?.area || null,
    floors: preset?.floors || null,
    tier: preset?.tier || null,
    extras: preset?.extras || [],
    budget: document.getElementById('quote-budget')?.value || '',
    notes: document.getElementById('quote-notes')?.value || '',
  };

  const submitBtn = e.target.querySelector('button[type="submit"]');
  const originalLabel = submitBtn ? submitBtn.innerText : '';
  if (submitBtn) {
    submitBtn.disabled = true;
    submitBtn.innerText = 'Submitting...';
  }

  try {
    const res = await fetch('/quote/submit', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken(),
      },
      body: JSON.stringify(payload),
    });

    const data = await res.json();
    if (!res.ok) throw new Error(data.message || 'Submission failed');

    if (typeof showToast === 'function') {
      showToast(data.message || 'Quote proposal request submitted successfully!');
    } else {
      alert(data.message || 'Quote proposal request submitted successfully!');
    }

    e.target.reset();
    if (document.getElementById('quote-preset-alert')) {
      document.getElementById('quote-preset-alert').style.display = 'none';
    }
    window.appliedEstimate = null;
  } catch (err) {
    console.error('Quote submit error:', err);
    if (typeof showToast === 'function') {
      showToast('Something went wrong while submitting. Please try again.', 'error');
    } else {
      alert('Something went wrong while submitting. Please try again.');
    }
  } finally {
    if (submitBtn) {
      submitBtn.disabled = false;
      submitBtn.innerText = originalLabel;
    }
  }
}

document.addEventListener('DOMContentLoaded', () => {
  if (document.getElementById('est-area')) runCalculateCost();
  if (document.getElementById('quote-preset-alert')) checkQuotePreset();
});