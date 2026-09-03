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

  const preset = window.appliedEstimate || null;
  const formData = new FormData();

  formData.append('name', document.getElementById('quote-name')?.value || '');
  formData.append('email', document.getElementById('quote-email')?.value || '');
  formData.append('phone', document.getElementById('quote-phone')?.value || '');
  formData.append('location', document.getElementById('quote-location')?.value || '');
  formData.append('type', preset?.type || document.getElementById('quote-type')?.value || '');
  formData.append('area', preset?.area || '');
  formData.append('floors', preset?.floors || '');
  formData.append('tier', preset?.tier || '');
  formData.append('budget', document.getElementById('quote-budget')?.value || '');
  formData.append('notes', document.getElementById('quote-notes')?.value || '');

  (preset?.extras || []).forEach((extra) => {
    formData.append('extras[]', extra);
  });

  const attachments = document.getElementById('quote-attachments')?.files || [];

  for (const file of attachments) {
    formData.append('attachments[]', file);
  }

  const submitBtn = e.target.querySelector('button[type="submit"]');
  const originalLabel = submitBtn?.innerText || '';

  if (submitBtn) {
    submitBtn.disabled = true;
    submitBtn.innerText = 'Submitting...';
  }

  try {
    const recaptchaToken = await getRecaptchaToken('quote_submit');
    formData.append('recaptcha_token', recaptchaToken || '');

    const res = await fetch('/quote/submit', {
      method: 'POST',
      headers: {
        Accept: 'application/json',
        'X-CSRF-TOKEN': getCsrfToken(),
      },
      body: formData,
    });

    const data = await res.json();

    if (!res.ok) {
      const errors = Object.values(data.errors || {})
        .flat()
        .join('\n');

      throw new Error(errors || data.message || 'Submission failed');
    }

    showToast?.(data.message || 'Quote request submitted successfully!');

    e.target.reset();
    document.getElementById('quote-preset-alert')?.style.setProperty('display', 'none');
    window.appliedEstimate = null;
  } catch (err) {
    console.error('Quote submit error:', err);
    showToast?.(err.message || 'Something went wrong while submitting.', 'error');
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