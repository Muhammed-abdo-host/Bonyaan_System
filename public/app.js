// project_MET - Premier Construction & Contracting Web System
// Vanilla JavaScript Application Engine for Multi-Page Website (English Only)

const state = {
  activeRole: localStorage.getItem('met_active_role') || 'gm',
  adminSubView: 'overview',
  currentPage: 'home',

  // NOTE: This mock array is still used by the PUBLIC "/projects" portfolio
  // page's client-side filter/search (see renderProjects, applyProjectFilter
  // in projects.blade.php). It is NOT used anywhere in the admin dashboard
  // anymore — the admin CMS/CRM/Site Tracker tabs are fully backed by the
  // real database via admin-projects.js / admin-leads.js / admin-site-updates.js.
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

  // Still read by renderAdminOverview()'s "Active Quote Inquiries" KPI.
  // That KPI isn't wired to the real /admin/leads API yet — tracked as a
  // separate, known follow-up item, out of scope for this fix.
  leads: [],
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

  // Each tab is backed by its own real, database-driven fetch function
  // (defined in admin-projects.js / admin-leads.js / admin-site-updates.js /
  // the inline <script> in adminbanal.blade.php / admin-messages.js /
  // admin-blog.js). We re-fetch every time the tab is opened so the data
  // is always fresh — never a locally cached mock array.
  if (subViewId === 'cms' && typeof fetchAndRenderProjects === 'function') fetchAndRenderProjects();
  if (subViewId === 'crm' && typeof fetchAndRenderLeads === 'function') fetchAndRenderLeads();
  if (subViewId === 'site' && typeof fetchAndRenderSiteUpdates === 'function') fetchAndRenderSiteUpdates();
  if (subViewId === 'hr' && typeof loadHrApplicants === 'function') loadHrApplicants();
  if (subViewId === 'messages' && typeof fetchAndRenderMessages === 'function') fetchAndRenderMessages();
  if (subViewId === 'blog' && typeof fetchAndRenderBlogPosts === 'function') fetchAndRenderBlogPosts();
}

// Role Context Switcher


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

// NOTE: The admin CMS Portfolio, CRM Leads, Site Tracker, and HR Manager
// mock render functions (renderCMSProjects / addProjectCMS / deleteCMSProject /
// renderCRMLeads / updateLeadStatus / assignLead / renderSiteManager /
// addSiteUpdate / renderHRManager / updateApplicantStatus / addApplicant)
// used to live here, driven by local mock arrays (state.projects for the
// CMS table, state.leads, state.siteUpdates, state.applicants).
//
// They have been removed. Every admin tab is now backed by the real
// database through its own dedicated file, and re-fetched fresh each time
// its tab is opened (see setAdminSubView above):
//   - CMS Portfolio  -> public/js/admin-projects.js   (fetchAndRenderProjects)
//   - CRM Leads      -> public/js/admin-leads.js      (fetchAndRenderLeads)
//   - Site Tracker   -> public/js/admin-site-updates.js (fetchAndRenderSiteUpdates)
//   - HR & Jobs      -> inline <script> in adminbanal.blade.php (loadHrApplicants)
//   - Contact Msgs   -> public/js/admin-messages.js   (fetchAndRenderMessages)
//   - Blog & News    -> public/js/admin-blog.js       (fetchAndRenderBlogPosts)
//
// Keeping the old mock versions here was the root cause of a real bug:
// both the mock function AND the real fetch function targeted the exact
// same table (e.g. #cms-projects-body), so every time an admin re-opened
// a tab, the mock version silently overwrote the real, database-driven
// data with static demo rows. Do not re-add mock versions of these
// functions here — always fetch from the real /admin/* endpoints.

// Projects Filter Helper
window.currentProjectFilter = 'all';
function filterProjectsCategory(cat, btnEl) {
  window.currentProjectFilter = cat;
  document.querySelectorAll('.project-filter-btn').forEach(b => b.classList.remove('active'));
  if (btnEl) btnEl.classList.add('active');
  renderProjects(cat);
}

// Projects Portfolio Render (PUBLIC "/projects" page only — uses the mock
// state.projects array above, unrelated to the admin dashboard).
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

// Open Project Details Modal (public portfolio page only)
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

// Render Admin Overview (KPI cards on the "Overview" tab only)
function renderAdminOverview() {
  const leadsBody = document.getElementById('admin-overview-leads-body');
  const kpiLeads = document.getElementById('kpi-leads-count');

  if (kpiLeads) kpiLeads.innerText = state.leads.length;

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

// Master Render All for current page context
function renderAllViews() {
  updateActiveNav();
  renderProjects();
  renderAdminOverview();
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