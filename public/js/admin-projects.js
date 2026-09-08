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

// Maps a project's status to the Bootstrap badge class + label shown
// in the admin CMS table.
const PROJECT_STATUS_BADGES = {
  pending: { label: 'Pending Approval', className: 'bg-warning text-dark' },
  ongoing: { label: 'Ongoing', className: 'bg-info text-dark' },
  completed: { label: 'Completed', className: 'bg-success' },
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
          No project requests yet.
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

    const statusInfo = PROJECT_STATUS_BADGES[project.status] || {
      label: escapeHtml(project.status || 'Unknown'),
      className: 'bg-secondary',
    };

    const acceptButton = project.status === 'pending'
      ? `
        <button
          type="button"
          class="btn btn-sm btn-success"
          onclick="acceptCMSProject(${project.id})"
          title="Accept this project and move it to Ongoing"
        >
          <i class="bi bi-check-lg"></i> Accept
        </button>
      `
      : '';

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

        <td class="small">${escapeHtml(project.client)}</td>

        <td>
          <span class="badge ${statusInfo.className}">
            ${statusInfo.label}
          </span>
        </td>

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
          <div class="d-flex gap-1">
            ${acceptButton}

            <button
              type="button"
              class="btn btn-sm btn-outline-danger"
              onclick="deleteCMSProject(${project.id})"
              title="Delete / reject this project"
            >
              <i class="bi bi-trash"></i>
            </button>
          </div>
        </td>
      </tr>
    `;
  }).join('');
}

window.acceptCMSProject = async function (id) {
  const confirmed = await confirmAction(
    'Accept this project? It will move to "Ongoing" and become visible in the client\'s tracker.'
  );

  if (!confirmed) return;

  try {
    const response = await fetch(`/admin/projects/${id}`, {
      method: 'PATCH',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        'X-CSRF-TOKEN': csrfHeader(),
      },
      body: JSON.stringify({ status: 'ongoing' }),
    });

    const data = await response.json();

    if (!response.ok) {
      throw new Error(data.message || 'Could not accept project.');
    }

    showToast?.(data.message || 'Project accepted and moved to Ongoing.');

    await fetchAndRenderProjects();
  } catch (error) {
    console.error('Could not accept project:', error);

    showToast?.(
      error.message || 'Could not accept the project.',
      'error'
    );
  }
};

window.deleteCMSProject = async function (id) {
  const confirmed = await confirmAction('Delete this project permanently?');

  if (!confirmed) return;

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
  if (document.getElementById('cms-projects-body')) {
    fetchAndRenderProjects();
  }
});