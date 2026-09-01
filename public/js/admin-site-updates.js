function getCsrfToken() {
  return document
    .querySelector('meta[name="csrf-token"]')
    ?.getAttribute('content');
}

function escapeHtml(value) {
  return String(value ?? '').replace(/[&<>"']/g, (character) => ({
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;',
  }[character]));
}

function phaseLabel(phase) {
  return {
    excavation: 'Excavation',
    structure: 'Structure',
    mep: 'MEP',
    finishing: 'Finishing',
  }[phase] || phase;
}

window.toggleSiteUpdateForm = async function (forceOpen = null) {
  const panel = document.getElementById('addSiteUpdatePanel');

  if (!panel) return;

  const shouldOpen = forceOpen === null
    ? panel.classList.contains('d-none')
    : forceOpen;

  panel.classList.toggle('d-none', !shouldOpen);

  if (shouldOpen) {
    await loadSiteProjects();

    panel.scrollIntoView({
      behavior: 'smooth',
      block: 'start',
    });
  }
};

async function loadSiteProjects() {
  const select = document.getElementById('site-project');

  if (!select) return;

  select.innerHTML = '<option value="">Loading projects...</option>';

  try {
    const response = await fetch('/admin/projects', {
      headers: { Accept: 'application/json' },
    });

    if (!response.ok) {
      throw new Error('Could not load projects.');
    }

    const projects = await response.json();

    select.innerHTML = projects.length
      ? `
        <option value="">Select a project...</option>
        ${projects.map((project) => `
          <option value="${project.id}">
            ${escapeHtml(project.title)} — ${escapeHtml(project.client)}
          </option>
        `).join('')}
      `
      : '<option value="">No projects found. Add a project first.</option>';
  } catch (error) {
    console.error('Site project loading error:', error);

    select.innerHTML = '<option value="">Could not load projects</option>';

    showToast?.('Could not load projects for the site update.', 'error');
  }
}

function renderSiteManager(updates) {
  const container = document.getElementById('site-stream-grid');

  if (!container) return;

  if (!updates.length) {
    container.innerHTML = `
      <div class="col-12">
        <div class="alert alert-light border mb-0">
          No site updates have been published yet.
        </div>
      </div>
    `;

    return;
  }

  container.innerHTML = updates.map((update) => `
    <div class="col-md-6 col-xl-4">
      <div class="glass-card overflow-hidden h-100">
        ${
          update.image_url
            ? `
              <img
                src="${escapeHtml(update.image_url)}"
                alt="${escapeHtml(update.title)}"
                class="w-100"
                style="height: 210px; object-fit: cover;"
              >
            `
            : `
              <div
                class="d-flex align-items-center justify-content-center bg-light text-muted"
                style="height: 210px;"
              >
                <i class="bi bi-camera fs-1"></i>
              </div>
            `
        }

        <div class="p-3">
          <div class="d-flex justify-content-between gap-2 mb-2">
            <span class="badge bg-secondary">
              ${phaseLabel(update.phase)}
            </span>

            <span class="small text-muted">
              ${escapeHtml(update.date)}
            </span>
          </div>

          <div class="small text-muted mb-1">
            ${escapeHtml(update.project_name)}
          </div>

          <h5 class="fw-bold text-met-navy mb-2">
            ${escapeHtml(update.title)}
          </h5>

          ${
            update.description
              ? `
                <p class="small text-muted mb-3">
                  ${escapeHtml(update.description)}
                </p>
              `
              : ''
          }

          <button
            type="button"
            class="btn btn-sm btn-outline-danger"
            onclick="deleteSiteUpdate(${update.id})"
          >
            <i class="bi bi-trash"></i>
            Delete
          </button>
        </div>
      </div>
    </div>
  `).join('');
}

async function fetchAndRenderSiteUpdates() {
  try {
    const response = await fetch('/admin/site-updates', {
      headers: { Accept: 'application/json' },
    });

    if (!response.ok) {
      throw new Error('Could not load site updates.');
    }

    renderSiteManager(await response.json());
  } catch (error) {
    console.error('Site update loading error:', error);

    showToast?.('Could not load site updates.', 'error');
  }
}

window.publishSiteUpdate = async function (event) {
  event.preventDefault();

  const form = event.target;
  const submitButton = form.querySelector('button[type="submit"]');
  const originalText = submitButton?.innerText || '';
  const image = document.getElementById('site-image')?.files?.[0];

  const formData = new FormData();

  formData.append(
    'project_id',
    document.getElementById('site-project')?.value || ''
  );

  formData.append(
    'title',
    document.getElementById('site-title')?.value || ''
  );

  formData.append(
    'description',
    document.getElementById('site-description')?.value || ''
  );

  formData.append(
    'phase',
    document.getElementById('site-phase')?.value || ''
  );

  if (image) {
    formData.append('image', image);
  }

  if (submitButton) {
    submitButton.disabled = true;
    submitButton.innerText = 'Publishing...';
  }

  try {
    const response = await fetch('/admin/site-updates', {
      method: 'POST',
      headers: {
        Accept: 'application/json',
        'X-CSRF-TOKEN': getCsrfToken(),
      },
      body: formData,
    });

    const data = await response.json();

    if (!response.ok) {
      const validationErrors = Object.values(data.errors || {})
        .flat()
        .join('\n');

      throw new Error(
        validationErrors || data.message || 'Could not publish site update.'
      );
    }

    showToast?.(data.message || 'Site update published successfully.');

    form.reset();
    toggleSiteUpdateForm(false);

    await fetchAndRenderSiteUpdates();
  } catch (error) {
    console.error('Site update publishing error:', error);

    showToast?.(
      error.message || 'Could not publish site update.',
      'error'
    );
  } finally {
    if (submitButton) {
      submitButton.disabled = false;
      submitButton.innerText = originalText;
    }
  }
};

window.deleteSiteUpdate = async function (id) {
  if (!window.confirm('Delete this site update permanently?')) {
    return;
  }

  try {
    const response = await fetch(`/admin/site-updates/${id}`, {
      method: 'DELETE',
      headers: {
        Accept: 'application/json',
        'X-CSRF-TOKEN': getCsrfToken(),
      },
    });

    const data = await response.json();

    if (!response.ok) {
      throw new Error(data.message || 'Could not delete site update.');
    }

    showToast?.(data.message || 'Site update deleted successfully.');

    await fetchAndRenderSiteUpdates();
  } catch (error) {
    console.error('Site update deletion error:', error);

    showToast?.(
      error.message || 'Could not delete site update.',
      'error'
    );
  }
};

document.addEventListener('DOMContentLoaded', () => {
  fetchAndRenderSiteUpdates();
});