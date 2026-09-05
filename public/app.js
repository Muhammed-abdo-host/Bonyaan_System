// project_MET - Premier Construction & Contracting Web System
// Vanilla JavaScript Application Engine for Multi-Page Website (English Only)

const state = {
  activeRole: localStorage.getItem('met_active_role') || 'gm',
  adminSubView: 'overview',
  currentPage: 'home',

  projects: [
    {
      id: 1,
      title: "Al Reem Tower Complex",
      category: "office",
      client: "Al Reem Development Co.",
      location: "Riyadh, KSA",
      area: 45000,
      budget: "$28M",
      completion: 100,
      image: "https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800",
      description: "A 32-story mixed-use office tower featuring sustainable glass facade systems and smart building automation."
    },
    {
      id: 2,
      title: "Marina Bay Villas",
      category: "villa",
      client: "Marina Bay Holdings",
      location: "Dubai, UAE",
      area: 12000,
      budget: "$15M",
      completion: 85,
      image: "https://images.unsplash.com/photo-1613977257363-707ba9348227?w=800",
      description: "Luxury waterfront villa community with 24 private residences, each featuring private pools and landscaped gardens."
    },
    {
      id: 3,
      title: "Grand Horizon Mall",
      category: "mall",
      client: "Horizon Retail Group",
      location: "Jeddah, KSA",
      area: 85000,
      budget: "$62M",
      completion: 60,
      image: "https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=800",
      description: "A premier retail and entertainment destination spanning 85,000 sq.m with over 200 retail outlets."
    },
    {
      id: 4,
      title: "Falcon Logistics Hub",
      category: "warehouse",
      client: "Falcon Supply Chain",
      location: "Dammam, KSA",
      area: 60000,
      budget: "$18M",
      completion: 100,
      image: "https://images.unsplash.com/photo-1553413077-190dd305871c?w=800",
      description: "State-of-the-art logistics and distribution facility with automated warehousing systems."
    }
  ],

  leads: [],

  siteUpdates: [],

  applicants: [
    { id: 'APP-101', name: 'Yousef Al-Amri', email: 'yousef@email.com', job: 'Structural Engineer', exp: '6 years', cvName: 'yousef_cv.pdf', status: 'Interviewed' },
    { id: 'APP-102', name: 'Layla Hassan', email: 'layla@email.com', job: 'Site Supervisor', exp: '4 years', cvName: 'layla_cv.pdf', status: 'Pending Review' }
  ],

  clients: [
    { id: 'CL-01', name: 'Al Reem Development Co.' },
    { id: 'CL-02', name: 'Marina Bay Holdings' },
    { id: 'CL-03', name: 'Horizon Retail Group' },
    { id: 'CL-04', name: 'Falcon Supply Chain' }
  ]
};

// Toast Notification Manager
function showToast(message, type = 'success') {
  const container = document.getElementById('toast-container');
  if (!container) return;

  const colors = {
    success: 'bg-success',
    error: 'bg-danger',
    info: 'bg-info',
  };

  const toast = document.createElement('div');
  toast.className = `toast align-items-center text-white ${colors[type] || colors.success} border-0 show mb-2`;
  toast.innerHTML = `
    <div class="d-flex">
      <div class="toast-body">${message}</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="this.closest('.toast').remove()"></button>
    </div>
  `;

  container.appendChild(toast);
  setTimeout(() => toast.remove(), 5000);
}

// Active Navbar Item Highlighter
function updateActiveNav() {
  const path = window.location.pathname;
  document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
    link.classList.remove('active');
    if (link.getAttribute('href') === path) {
      link.classList.add('active');
    }
  });
}

// Multi-Page Navigation Helper Function
function navigate(pageId) {
  state.currentPage = pageId;
  window.location.href = `${pageId}.html`;
}

// Sub-navigation for Admin Dashboard
function setAdminSubView(subViewId) {
  state.adminSubView = subViewId;
  document.querySelectorAll('.subview-section').forEach(el => el.classList.remove('active'));
  const target = document.getElementById(`admin-${subViewId}`);
  if (target) target.classList.add('active');

  document.querySelectorAll('#admin-pills button').forEach(btn => {
    if (btn.getAttribute('onclick')?.includes(`setAdminSubView('${subViewId}')`)) {
      btn.className = "btn btn-sm btn-met-navy text-white";
    } else {
      btn.className = "btn btn-sm btn-outline-secondary";
    }
  });

  if (subViewId === 'cms') renderCMSProjects();
  if (subViewId === 'crm') renderCRMLeads();
  if (subViewId === 'site') renderSiteManager();
  if (subViewId === 'hr' && typeof loadHrApplicants === 'function') loadHrApplicants();
  if (subViewId === 'messages' && typeof fetchAndRenderMessages === 'function') fetchAndRenderMessages();
}

// Role Context Switcher
function setRole(roleKey) {
  state.activeRole = roleKey;
  localStorage.setItem('met_active_role', roleKey);
  const roleNames = {
    gm: "General Manager",
    sales: "Sales Rep",
    supervisor: "Site Supervisor",
    editor: "Content Editor",
    client: "Client User"
  };
  const roleName = roleNames[roleKey] || "General Manager";
  const badge = document.getElementById('current-role-badge');
  if (badge) badge.innerText = roleName;
  showToast(`Role context switched to: ${roleName}`, "info");
}

// NOTE: The Cost Estimator engine, quote-transfer helper, quote-preset
// check, and the Quote/Contact form submit handlers used to be defined
// here as client-only mock implementations. They have been removed —
// the real, backend-connected versions now live in:
//   - public/js/estimator.js  (calculateCost / applyEstimateToQuote /
//     checkQuotePreset / submitQuoteForm — calls /estimator/calculate
//     and /quote/submit, with a real reCAPTCHA v3 token)
//   - public/js/contact.js    (submitContactForm — calls /contact/submit,
//     with a real reCAPTCHA v3 token)
// Keeping duplicate mock versions here was fragile: they relied on
// script load order to be silently overridden, referenced reCAPTCHA
// checkbox ids that no longer exist in the forms, and never talked to
// the backend at all. Do not re-add them here.

// Projects Filter Helper
window.currentProjectFilter = 'all';
function filterProjectsCategory(cat, btnEl) {
  window.currentProjectFilter = cat;
  document.querySelectorAll('.project-filter-btn').forEach(b => b.classList.remove('active'));
  if (btnEl) btnEl.classList.add('active');
  renderProjects(cat);
}

// Projects Portfolio Render
function renderProjects(filterCategory = 'all', searchQuery = '') {
  const grid = document.getElementById('projects-grid');
  if (!grid) return;

  let filtered = state.projects;
  if (filterCategory !== 'all') {
    filtered = filtered.filter(p => p.category === filterCategory);
  }
  if (searchQuery) {
    const q = searchQuery.toLowerCase();
    filtered = filtered.filter(p => p.title.toLowerCase().includes(q) || p.location.toLowerCase().includes(q));
  }

  if (!filtered.length) {
    grid.innerHTML = '<div class="col-12 text-center text-muted py-5">No projects match your criteria.</div>';
    return;
  }

  grid.innerHTML = filtered.map(p => `
    <div class="col-md-6 col-lg-4">
      <div class="glass-card h-100 overflow-hidden cursor-pointer" onclick="openProjectModal(${p.id})">
        <img src="${p.image}" class="w-100" style="height: 220px; object-fit: cover;" alt="${p.title}">
        <div class="p-3">
          <span class="badge badge-gold mb-2 text-capitalize">${p.category}</span>
          <h5 class="fw-bold text-met-navy mb-1">${p.title}</h5>
          <div class="small text-muted mb-2"><i class="bi bi-geo-alt"></i> ${p.location}</div>
          <div class="d-flex justify-content-between small">
            <span class="fw-semibold">${p.area.toLocaleString()} m²</span>
            <span class="fw-bold text-gold">${p.budget}</span>
          </div>
          <div class="progress mt-2" style="height: 6px;">
            <div class="progress-bar bg-met-navy" style="width: ${p.completion}%"></div>
          </div>
        </div>
      </div>
    </div>
  `).join('');
}

// Open Project Details Modal
function openProjectModal(projId) {
  const p = state.projects.find(item => item.id === projId);
  if (!p) return;

  if (document.getElementById('modal-proj-title')) document.getElementById('modal-proj-title').innerText = p.title;
  if (document.getElementById('modal-proj-img')) document.getElementById('modal-proj-img').src = p.image;
  if (document.getElementById('modal-proj-client')) document.getElementById('modal-proj-client').innerText = p.client;
  if (document.getElementById('modal-proj-location')) document.getElementById('modal-proj-location').innerText = p.location;
  if (document.getElementById('modal-proj-area')) document.getElementById('modal-proj-area').innerText = `${p.area.toLocaleString()} m²`;
  if (document.getElementById('modal-proj-desc')) document.getElementById('modal-proj-desc').innerText = p.description;

  const modalEl = document.getElementById('projectDetailModal');
  if (modalEl && typeof bootstrap !== 'undefined') {
    const bsModal = new bootstrap.Modal(modalEl);
    bsModal.show();
  }
}

// Render Admin Overview
function renderAdminOverview() {
  const leadsBody = document.getElementById('admin-overview-leads-body');
  const kpiLeads = document.getElementById('kpi-leads-count');
  const kpiSites = document.getElementById('kpi-sites-count');

  if (kpiLeads) kpiLeads.innerText = state.leads.length;
  if (kpiSites) kpiSites.innerText = state.projects.filter(p => p.completion < 100).length;

  if (leadsBody) {
    leadsBody.innerHTML = state.leads.slice(0, 5).map(l => `
      <tr>
        <td class="fw-bold">${l.name}</td>
        <td>${l.projectType}</td>
        <td>${l.location}</td>
        <td class="text-gold fw-bold">${l.budget}</td>
        <td><span class="badge bg-primary">${l.status}</span></td>
      </tr>
    `).join('') || '<tr><td colspan="5" class="text-center text-muted py-3">No inquiries yet.</td></tr>';
  }
}

// CMS Projects CRUD Table
function renderCMSProjects() {
  const tbody = document.getElementById('cms-projects-body');
  if (!tbody) return;

  tbody.innerHTML = state.projects.map(p => `
    <tr>
      <td class="fw-bold text-met-navy">#${p.id}</td>
      <td>${p.title}</td>
      <td>${p.client}</td>
      <td>${p.location}</td>
      <td>${p.area.toLocaleString()} m²</td>
      <td class="fw-bold text-gold">${p.budget}</td>
      <td>${p.completion}%</td>
      <td>
        <button class="btn btn-sm btn-outline-danger" onclick="deleteCMSProject(${p.id})">
          <i class="bi bi-trash"></i>
        </button>
      </td>
    </tr>
  `).join('');
}

function deleteCMSProject(id) {
  state.projects = state.projects.filter(p => p.id !== id);
  showToast('Project removed successfully.', 'info');
  renderCMSProjects();
  renderProjects();
}

function addProjectCMS(e) {
  e.preventDefault();
  const newProject = {
    id: Date.now(),
    title: document.getElementById('cms-title')?.value || 'Untitled Project',
    category: document.getElementById('cms-category')?.value || 'villa',
    client: document.getElementById('cms-client')?.value || 'Unassigned Client',
    location: document.getElementById('cms-location')?.value || '',
    area: parseInt(document.getElementById('cms-area')?.value || 0, 10),
    budget: document.getElementById('cms-budget')?.value || '$0',
    completion: parseInt(document.getElementById('cms-completion')?.value || 0, 10),
    image: document.getElementById('cms-image')?.value || 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800',
    description: document.getElementById('cms-description')?.value || ''
  };

  state.projects.unshift(newProject);
  showToast('Project added successfully!');
  e.target.reset();
  renderCMSProjects();
  renderProjects();
}

// CRM Leads Table
function renderCRMLeads() {
  const tbody = document.getElementById('crm-leads-body');
  if (!tbody) return;

  tbody.innerHTML = state.leads.map(l => `
    <tr>
      <td class="fw-bold text-met-navy">#${l.id}</td>
      <td>
        <div class="fw-bold">${l.name}</div>
        <div class="small text-muted"><i class="bi bi-envelope"></i> ${l.email}</div>
      </td>
      <td>
        <div class="small fw-semibold">${l.projectType}</div>
        <div class="small text-muted">${l.location || '—'} (${l.area})</div>
      </td>
      <td class="fw-bold text-met-navy small">${l.budget}</td>
      <td>
        <select class="form-select form-select-sm fw-semibold" onchange="updateLeadStatus(${l.id}, this.value)">
          <option value="new" ${l.status === 'new' ? 'selected' : ''}>New</option>
          <option value="contacted" ${l.status === 'contacted' ? 'selected' : ''}>Contacted</option>
          <option value="converted" ${l.status === 'converted' ? 'selected' : ''}>Converted</option>
          <option value="rejected" ${l.status === 'rejected' ? 'selected' : ''}>Rejected</option>
        </select>
     </td>
<td>${renderLeadAttachments ? renderLeadAttachments(l.attachments) : ''}</td>
<td class="small text-muted">${l.date}</td>
    </tr>
  `).join('');
}

function updateLeadStatus(id, newStatus) {
  const l = state.leads.find(item => item.id === id);
  if (l) l.status = newStatus;
  showToast(`Lead ${id} status updated to ${newStatus}`);
}

function assignLead(id, repName) {
  const l = state.leads.find(item => item.id === id);
  if (l) l.assignedTo = repName;
  showToast(`Lead ${id} assigned to ${repName}`);
}

// Site Manager & Client Portal Stream Render
function renderSiteManager() {
  const grid = document.getElementById('site-stream-grid');
  if (!grid) return;

  if (!state.siteUpdates.length) {
    grid.innerHTML = '<div class="col-12 text-center text-muted py-4">No site updates published yet.</div>';
    return;
  }

  grid.innerHTML = state.siteUpdates.map(u => `
    <div class="col-md-6 col-lg-4">
      <div class="glass-card h-100 overflow-hidden">
        <img src="${u.image}" class="w-100" style="height: 180px; object-fit: cover;" alt="${u.title}">
        <div class="p-3">
          <h6 class="fw-bold text-met-navy mb-1">${u.title}</h6>
          <div class="small text-muted mb-2">${u.projectName || ''}</div>
          <p class="small text-secondary mb-0">${u.notes || ''}</p>
        </div>
      </div>
    </div>
  `).join('');
}

function addSiteUpdate(e) {
  e.preventDefault();
  const newUpdate = {
    id: Date.now(),
    title: document.getElementById('site-title')?.value || 'Site Update',
    projectName: document.getElementById('site-project')?.selectedOptions?.[0]?.text || '',
    image: document.getElementById('site-image')?.value || 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=800',
    notes: document.getElementById('site-notes')?.value || ''
  };

  state.siteUpdates.unshift(newUpdate);
  showToast('Site update published successfully!');
  e.target.reset();
  renderSiteManager();
}

// HR Manager Render
function renderHRManager() {
  const tbody = document.getElementById('hr-applicants-body');
  if (!tbody) return;

  tbody.innerHTML = state.applicants.map(a => `
    <tr>
      <td class="fw-bold text-met-navy">${a.id}</td>
      <td><div class="fw-bold">${a.name}</div><div class="small text-muted">${a.email}</div></td>
      <td class="small fw-semibold">${a.job}</td>
      <td class="small">${a.exp}</td>
      <td>
        <button class="btn btn-sm btn-outline-secondary py-1" onclick="showToast('Downloading ${a.cvName}...', 'info')">
          <i class="bi bi-download"></i> ${a.cvName}
        </button>
      </td>
      <td>
        <select class="form-select form-select-sm fw-semibold" onchange="updateApplicantStatus('${a.id}', this.value)">
          <option value="Pending Review" ${a.status === 'Pending Review' ? 'selected' : ''}>Pending Review</option>
          <option value="Interviewed" ${a.status === 'Interviewed' ? 'selected' : ''}>Interviewed</option>
          <option value="Hired" ${a.status === 'Hired' ? 'selected' : ''}>Hired</option>
          <option value="Rejected" ${a.status === 'Rejected' ? 'selected' : ''}>Rejected</option>
        </select>
      </td>
    </tr>
  `).join('');
}

function updateApplicantStatus(id, newStatus) {
  const a = state.applicants.find(item => item.id === id);
  if (a) a.status = newStatus;
  showToast(`Applicant ${id} status updated to ${newStatus}`);
}

function addApplicant(e) {
  e.preventDefault();
  showToast('Application submitted successfully!');
  e.target.reset();
}

// Master Render All for current page context
function renderAllViews() {
  updateActiveNav();
  renderProjects();
  renderAdminOverview();
  renderCMSProjects();
  renderCRMLeads();
  renderSiteManager();
  renderHRManager();
  if (typeof calculateCost === 'function') calculateCost();
  if (typeof checkQuotePreset === 'function') checkQuotePreset();

  const roleBadge = document.getElementById('current-role-badge');
  const roleNames = {
    gm: "General Manager",
    sales: "Sales Rep",
    supervisor: "Site Supervisor",
    editor: "Content Editor",
    client: "Client User"
  };
  if (roleBadge) roleBadge.innerText = roleNames[state.activeRole] || "General Manager";
}

// Initialize on DOM Ready
document.addEventListener('DOMContentLoaded', () => {
  renderAllViews();
});