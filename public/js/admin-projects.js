function csrfHeader() {
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

window.toggleCMSProjectForm = async function (forceOpen = null) {
  const panel = document.getElementById('addCMSProjectPanel');

  if (!panel) return;

  const shouldOpen = forceOpen === null
    ? panel.classList.contains('d-none')
    : forceOpen;

  panel.classList.toggle('d-none', !shouldOpen);

  if (shouldOpen) {
    await loadClientOptions();

    panel.scrollIntoView({
      behavior: 'smooth',
      block: 'start',
    });
  }
};

async function fetchAndRenderProjects() {
  const tbody = document.getElementById('cms-projects-body');

  if (!tbody) return;

  try {
    const response = await fetch('/admin/projects', {
      headers: { Accept: 'application/json' },
    });

    if (!response.ok) {
      throw new Error(`Failed to load projects (${response.status})`);
    }

    const projects = await response.json();

    if (typeof state !== 'undefined') {
      state.projects = projects.map((project) => ({
        ...project,
        status: 'Under Construction',
      }));
    }

    renderCMSProjectsFromApi(projects);

    if (typeof renderAdminOverview === 'function') {
      renderAdminOverview();
    }
  } catch (error) {
    console.error('Could not load projects:', error);

    showToast?.('Could not load projects from the server.', 'error');
  }
}

function renderCMSProjectsFromApi(projects) {
  const tbody = document.getElementById('cms-projects-body');

  if (!tbody) return;

  if (!projects.length) {
    tbody.innerHTML = `
      <tr>
        <td colspan="7" class="text-center text-muted py-4">
          No projects have been added yet.
        </td>
      </tr>
    `;

    return;
  }

  tbody.innerHTML = projects.map((project) => {
    const image = project.image
      ? `
        <img
          src="${escapeHtml(project.image)}"
          alt="${escapeHtml(project.title)}"
          class="rounded-2 object-fit-cover"
          style="width: 50px; height: 40px;"
        >
      `
      : `
        <div
          class="bg-light text-muted rounded-2 d-flex align-items-center justify-content-center"
          style="width: 50px; height: 40px;"
        >
          <i class="bi bi-building"></i>
        </div>
      `;

    return `
      <tr>
        <td class="fw-bold text-met-navy">#${project.id}</td>

        <td>
          <div class="d-flex align-items-center gap-3">
            ${image}

            <div>
              <div class="fw-bold">${escapeHtml(project.title)}</div>

              <div class="small text-muted">
                ${escapeHtml(project.location || '—')}
              </div>
            </div>
          </div>
        </td>

        <td>
          <span class="badge bg-met-navy text-gold">
            ${escapeHtml(project.category)}
          </span>
        </td>

        <td class="small">${escapeHtml(project.client)}</td>

        <td>
          <div class="d-flex align-items-center gap-2">
            <div
              class="progress flex-grow-1"
              style="height: 6px; min-width: 80px;"
            >
              <div
                class="progress-bar bg-warning"
                style="width: ${Number(project.completion) || 0}%;"
              ></div>
            </div>

            <span class="small fw-bold">
              ${Number(project.completion) || 0}%
            </span>
          </div>
        </td>

        <td class="fw-bold text-met-navy small">
          ${escapeHtml(project.budget || '—')}
        </td>

        <td>
          <button
            type="button"
            class="btn btn-sm btn-outline-danger"
            onclick="deleteCMSProject(${project.id})"
            title="Delete project"
          >
            <i class="bi bi-trash"></i>
          </button>
        </td>
      </tr>
    `;
  }).join('');
}

async function loadClientOptions() {
  const select = document.getElementById('cms-client');

  if (!select) return;

  select.innerHTML = '<option value="">Loading clients...</option>';

  try {
    const response = await fetch('/admin/clients', {
      headers: { Accept: 'application/json' },
    });

    if (!response.ok) {
      throw new Error('Failed to load clients');
    }

    const clients = await response.json();

    select.innerHTML = clients.length
      ? `
        <option value="">Select a client...</option>
        ${clients.map((client) => `
          <option value="${client.id}">
            ${escapeHtml(client.name)} — ${escapeHtml(client.email)}
          </option>
        `).join('')}
      `
      : '<option value="">No client accounts found</option>';
  } catch (error) {
    console.error('Could not load clients:', error);

    select.innerHTML = '<option value="">Could not load clients</option>';

    showToast?.('Could not load client accounts.', 'error');
  }
}

window.addProjectCMS = async function (event) {
  event.preventDefault();

  const form = event.target;
  const submitButton = form.querySelector('button[type="submit"]');
  const originalText = submitButton?.innerText || '';

  const payload = {
    client_id: document.getElementById('cms-client')?.value || '',
    name: document.getElementById('cms-title')?.value || '',
    type: document.getElementById('cms-category')?.value || '',
    location: document.getElementById('cms-location')?.value || '',
    area: document.getElementById('cms-area')?.value || '',
    budget: document.getElementById('cms-budget')?.value || '',
    progress_percent: document.getElementById('cms-completion')?.value || 0,
    image: document.getElementById('cms-image')?.value || '',
    description: document.getElementById('cms-desc')?.value || '',
  };

  if (submitButton) {
    submitButton.disabled = true;
    submitButton.innerText = 'Publishing...';
  }

  try {
    const response = await fetch('/admin/projects', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        'X-CSRF-TOKEN': csrfHeader(),
      },
      body: JSON.stringify(payload),
    });

    const data = await response.json();

    if (!response.ok) {
      const validationErrors = Object.values(data.errors || {})
        .flat()
        .join('\n');

      throw new Error(
        validationErrors || data.message || 'Could not save the project.'
      );
    }

    showToast?.(data.message || 'Project published successfully.');

    form.reset();
    toggleCMSProjectForm(false);

    await fetchAndRenderProjects();
  } catch (error) {
    console.error('Could not save project:', error);

    showToast?.(
      error.message || 'Could not save the project. Please try again.',
      'error'
    );
  } finally {
    if (submitButton) {
      submitButton.disabled = false;
      submitButton.innerText = originalText;
    }
  }
};

window.deleteCMSProject = async function (id) {
  if (!window.confirm('Delete this project permanently?')) {
    return;
  }

  try {
    const response = await fetch(`/admin/projects/${id}`, {
      method: 'DELETE',
      headers: {
        Accept: 'application/json',
        'X-CSRF-TOKEN': csrfHeader(),
      },
    });

    const data = await response.json();

    if (!response.ok) {
      throw new Error(data.message || 'Could not delete project.');
    }

    showToast?.(data.message || 'Project deleted successfully.');

    await fetchAndRenderProjects();
  } catch (error) {
    console.error('Could not delete project:', error);

    showToast?.(
      error.message || 'Could not delete the project.',
      'error'
    );
  }
};

document.addEventListener('DOMContentLoaded', () => {
  fetchAndRenderProjects();
});