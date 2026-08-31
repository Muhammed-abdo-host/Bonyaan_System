// Connects the admin dashboard's "CMS Portfolio Manager" table and
// "Add New Project" modal (originally mock data / a non-existent modal)
// to the real /admin/projects API.

function csrfHeader() {
  return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
}

async function fetchAndRenderProjects() {
  const tbody = document.getElementById('cms-projects-body');
  if (!tbody) return; // not on the admin page

  try {
    const res = await fetch('/admin/projects', { headers: { 'Accept': 'application/json' } });
    if (!res.ok) throw new Error(`Failed to load projects (${res.status})`);
    const projects = await res.json();

    // Keep app.js's other renderers (renderProjects on the public site,
    // renderAdminOverview KPIs) working by feeding real data into state.
    state.projects = projects.map(p => ({ ...p, status: 'Under Construction' }));

    renderCMSProjectsFromApi(projects);
    if (typeof renderAdminOverview === 'function') renderAdminOverview();
  } catch (err) {
    console.error('Could not load projects:', err);
    if (typeof showToast === 'function') showToast('Could not load projects from the server.', 'error');
  }
}

function renderCMSProjectsFromApi(projects) {
  const tbody = document.getElementById('cms-projects-body');
  if (!tbody) return;

  tbody.innerHTML = projects.map(p => `
    <tr>
      <td class="fw-bold text-met-navy">#${p.id}</td>
      <td>
        <div class="d-flex align-items-center gap-3">
          <img src="${p.image}" alt="" class="rounded-2 object-fit-cover" style="width: 50px; height: 40px;" />
          <div>
            <div class="fw-bold">${p.title}</div>
            <div class="small text-muted">${p.location || '—'}</div>
          </div>
        </div>
      </td>
      <td><span class="badge bg-met-navy text-gold">${p.category}</span></td>
      <td class="small">${p.client}</td>
      <td>
        <div class="d-flex align-items-center gap-2">
          <div class="progress flex-grow-1" style="height: 6px; min-width: 80px;">
            <div class="progress-bar bg-warning" style="width: ${p.completion}%;"></div>
          </div>
          <span class="small fw-bold">${p.completion}%</span>
        </div>
      </td>
      <td class="fw-bold text-met-navy small">${p.budget || '—'}</td>
      <td>
        <button class="btn btn-sm btn-outline-danger" onclick="deleteCMSProject(${p.id})">
          <i class="bi bi-trash"></i>
        </button>
      </td>
    </tr>
  `).join('');
}

// Populates the "Client" dropdown in the Add Project modal.
async function loadClientOptions() {
  const select = document.getElementById('cms-client');
  if (!select) return;

  try {
    const res = await fetch('/admin/clients', { headers: { 'Accept': 'application/json' } });
    if (!res.ok) throw new Error('Failed to load clients');
    const clients = await res.json();

    select.innerHTML = clients.length
      ? clients.map(c => `<option value="${c.id}">${c.name}</option>`).join('')
      : '<option value="">No client accounts found</option>';
  } catch (err) {
    console.error('Could not load clients:', err);
    select.innerHTML = '<option value="">Could not load clients</option>';
  }
}

// Overrides the mock version in app.js — now persists to the DB.
async function addProjectCMS(e) {
  e.preventDefault();

  const payload = {
    client_id: document.getElementById('cms-client')?.value,
    name: document.getElementById('cms-title')?.value,
    type: document.getElementById('cms-category')?.value,
    location: document.getElementById('cms-location')?.value,
    area: document.getElementById('cms-area')?.value,
    budget: document.getElementById('cms-budget')?.value,
    progress_percent: document.getElementById('cms-completion')?.value || 0,
    image: document.getElementById('cms-image')?.value,
    description: document.getElementById('cms-desc')?.value,
  };

  try {
    const res = await fetch('/admin/projects', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfHeader(),
      },
      body: JSON.stringify(payload),
    });

    const data = await res.json();
    if (!res.ok) throw new Error(data.message || 'Failed to save project');

    if (typeof showToast === 'function') showToast(data.message);

    const modalEl = document.getElementById('addCMSModal');
    if (modalEl && typeof bootstrap !== 'undefined') {
      const modal = bootstrap.Modal.getInstance(modalEl);
      if (modal) modal.hide();
    }
    e.target.reset();

    fetchAndRenderProjects();
  } catch (err) {
    console.error('Could not save project:', err);
    if (typeof showToast === 'function') showToast('Could not save the project. Please try again.', 'error');
  }
}

// Overrides the mock version in app.js — now actually deletes from the DB.
async function deleteCMSProject(id) {
  try {
    const res = await fetch(`/admin/projects/${id}`, {
      method: 'DELETE',
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfHeader(),
      },
    });

    if (!res.ok) throw new Error('Failed to delete project');
    const data = await res.json();

    if (typeof showToast === 'function') showToast(data.message, 'info');
    fetchAndRenderProjects();
  } catch (err) {
    console.error('Could not delete project:', err);
    if (typeof showToast === 'function') showToast('Could not delete the project.', 'error');
  }
}

document.addEventListener('DOMContentLoaded', () => {
  fetchAndRenderProjects();

  const modalEl = document.getElementById('addCMSModal');
  if (modalEl) {
    modalEl.addEventListener('show.bs.modal', loadClientOptions);
  }
});