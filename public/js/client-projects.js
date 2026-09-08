function csrfHeaderForClientProjects() {
  return document
    .querySelector('meta[name="csrf-token"]')
    ?.getAttribute('content');
}

window.toggleClientProjectForm = function (forceOpen = null) {
  const panel = document.getElementById('clientProjectRequestPanel');

  if (!panel) return;

  const shouldOpen = forceOpen === null
    ? panel.classList.contains('d-none')
    : forceOpen;

  panel.classList.toggle('d-none', !shouldOpen);

  if (shouldOpen) {
    panel.scrollIntoView({
      behavior: 'smooth',
      block: 'start',
    });
  }
};

window.submitClientProjectRequest = async function (event) {
  event.preventDefault();

  const form = event.target;
  const submitButton = form.querySelector('button[type="submit"]');
  const originalText = submitButton?.innerText || '';

  const payload = {
    name: document.getElementById('cpr-name')?.value || '',
    type: document.getElementById('cpr-type')?.value || '',
    location: document.getElementById('cpr-location')?.value || '',
    area: document.getElementById('cpr-area')?.value || '',
    floors: document.getElementById('cpr-floors')?.value || 1,
    budget: document.getElementById('cpr-budget')?.value || '',
    description: document.getElementById('cpr-description')?.value || '',
  };

  if (submitButton) {
    submitButton.disabled = true;
    submitButton.innerText = 'Submitting...';
  }

  try {
    const response = await fetch('/client/projects', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        'X-CSRF-TOKEN': csrfHeaderForClientProjects(),
      },
      body: JSON.stringify(payload),
    });

    const data = await response.json();

    if (!response.ok) {
      const validationErrors = Object.values(data.errors || {})
        .flat()
        .join('\n');

      throw new Error(
        validationErrors || data.message || 'Could not submit the project request.'
      );
    }

    showToast?.(data.message || 'Project request submitted successfully.');

    form.reset();
    toggleClientProjectForm(false);

    // Reload so the new "Pending" project card appears in the list below.
    window.location.reload();
  } catch (error) {
    console.error('Could not submit project request:', error);

    showToast?.(
      error.message || 'Could not submit the request. Please try again.',
      'error'
    );
  } finally {
    if (submitButton) {
      submitButton.disabled = false;
      submitButton.innerText = originalText;
    }
  }
};