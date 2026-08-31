function getCsrfToken() {
  return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
}

window.submitContactForm = async function (event) {
  event.preventDefault();

  const recaptcha = document.getElementById('contact-recaptcha');

  if (!recaptcha?.checked) {
    showToast?.('Please complete the verification checkbox.', 'error');
    return;
  }

  const form = event.target;
  const submitButton = form.querySelector('button[type="submit"]');
  const originalText = submitButton?.innerText || '';

  if (submitButton) {
    submitButton.disabled = true;
    submitButton.innerText = 'Sending...';
  }

  try {
    const response = await fetch('/contact/submit', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken(),
      },
      body: JSON.stringify({
        name: document.getElementById('contact-name')?.value || '',
        email: document.getElementById('contact-email')?.value || '',
        subject: document.getElementById('contact-subject')?.value || '',
        message: document.getElementById('contact-message')?.value || '',
      }),
    });

    const data = await response.json();

    if (!response.ok) {
      const errors = Object.values(data.errors || {}).flat().join('\n');
      throw new Error(errors || data.message || 'Could not send message.');
    }

    showToast?.(data.message);
    form.reset();
  } catch (error) {
    console.error('Contact form error:', error);
    showToast?.(error.message || 'Could not send message.', 'error');
  } finally {
    if (submitButton) {
      submitButton.disabled = false;
      submitButton.innerText = originalText;
    }
  }
};