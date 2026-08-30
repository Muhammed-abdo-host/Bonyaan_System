// project_MET - Premier Construction & Contracting Web System
// Vanilla JavaScript Application Engine for Multi-Page Website (English Only)

const state = {
  adminSubView: 'overview',
  activeRole: localStorage.getItem('met_active_role') || 'gm',
  estimatorPreset: null,

  // Projects Mock DB
  projects: [
    {
      id: "PRJ-8820",
      title: "Al-Mansoor Luxury Towers",
      category: "residential",
      status: "Under Construction",
      client: "Al-Mansoor Real Estate",
      location: "Riyadh, Financial District",
      area: 28500,
      floors: 18,
      duration: "24 Months",
      budget: "$14.5M",
      completion: 68,
      image: "https://dubaipaths.com/images/large/al-mansoor-tiger-tower-aerial-view.webp",
      description: "A high-density 18-story residential luxury complex featuring smart home automation, underground parking, and glass curtain wall finishes."
    },
    {
      id: "PRJ-9041",
      title: "Apex Financial Center & Mall",
      category: "commercial",
      status: "Completed",
      client: "Apex Global Properties",
      location: "Dubai Marina",
      area: 45000,
      floors: 12,
      duration: "30 Months",
      budget: "$28.0M",
      completion: 100,
      image: "https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80",
      description: "Iconic commercial headquarters with integrated retail mall, atrium skylight, and post-tension concrete framing."
    },
    {
      id: "PRJ-7650",
      title: "Green Valley Eco-Villas",
      category: "residential",
      status: "Completed",
      client: "Private Investor Consortium",
      location: "Jeddah Coast",
      area: 12400,
      floors: 3,
      duration: "14 Months",
      budget: "$6.8M",
      completion: 100,
      image: "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80",
      description: "Suburban sustainable luxury villas featuring solar microgrids, infinity pools, and zero-carbon thermal insulation."
    },
    {
      id: "PRJ-6112",
      title: "Metro Central Logistics Highway & Hub",
      category: "infrastructure",
      status: "Under Construction",
      client: "Ministry of Transport",
      location: "Eastern Highway Zone",
      area: 120000,
      floors: 2,
      duration: "36 Months",
      budget: "$42.0M",
      completion: 45,
      image: "https://images.unsplash.com/photo-1590496793929-36417d3117de?auto=format&fit=crop&w=800&q=80",
      description: "Heavy infrastructure industrial zone featuring heavy load concrete paving, automated warehousing, and toll bridge engineering."
    }
  ],

  // CRM Leads Mock DB
  leads: [
    {
      id: "LEAD-101",
      name: "Eng. Hassan Al-Otaibi",
      email: "h.otaibi@futurecorp.com",
      phone: "+966 50 123 4567",
      location: "Riyadh North",
      projectType: "Commercial Complex",
      area: "5,400 sq.m",
      budget: "$3.5M - $5.0M",
      status: "New",
      assignedTo: "Sales Rep - Omar S.",
      date: "2026-08-02",
      notes: "Requires preliminary engineering calculation for 5 floors office structure."
    },
    {
      id: "LEAD-102",
      name: "Dr. Mona Al-Husseini",
      email: "mona.h@healthgroup.sa",
      phone: "+966 55 987 6543",
      location: "Jeddah Corniche",
      projectType: "Private Villa Estate",
      area: "1,800 sq.m",
      budget: "$1.2M - $2.0M",
      status: "Under Review",
      assignedTo: "Sales Rep - Sarah M.",
      date: "2026-07-29",
      notes: "Land area is ready for excavation. Client requested smart home finishing tier."
    },
    {
      id: "LEAD-103",
      name: "Sami K. Al-Zahrani",
      email: "s.zahrani@zahrani-holdings.com",
      phone: "+966 54 222 3344",
      location: "Dammam Port Industrial",
      projectType: "Industrial Warehouse",
      area: "15,000 sq.m",
      budget: "$8.0M - $10.0M",
      status: "Contracted",
      assignedTo: "General Manager",
      date: "2026-07-15",
      notes: "Contract signed for heavy steel construction phase."
    }
  ],

  // Site Updates Stream
  siteUpdates: [
    {
      id: 1,
      date: "2026-08-01",
      title: "14th Floor Concrete Pouring Completed",
      stage: "Skeleton Structure",
      engineer: "Eng. Mahmoud R. (Senior Site Supervisor)",
      photo: "https://i.pinimg.com/1200x/d7/7b/c1/d77bc1e1ec127bb59b3c3018729d2643.jpg",
      notes: "Structural integrity tests passed 100%. Next phase is exterior glass curtain installation."
    },
    {
      id: 2,
      date: "2026-07-20",
      title: "MEP Electrical & HVAC Ductwork Inspection",
      stage: "MEP Engineering",
      engineer: "Eng. Ahmed K. (MEP Lead)",
      photo: "https://images.unsplash.com/photo-1581094794329-c8112a89af12?auto=format&fit=crop&w=600&q=80",
      notes: "Main distribution boards and riser conduits approved by municipality inspector."
    }
  ],

  // HR Applicants & Job Postings
  applicants: [
    { id: "APP-501", name: "Fahad Al-Dossary", job: "Senior Structural Engineer", exp: "8 Years", email: "f.dossary@gmail.com", status: "Interviewed", cvName: "CV_Fahad_Structural.pdf" },
    { id: "APP-502", name: "Karim Mostafa", job: "Site Civil Supervisor", exp: "5 Years", email: "k.mostafa@yahoo.com", status: "Pending Review", cvName: "Resume_Karim_Civil.pdf" }
  ]
};

// Toast Notification Manager
function showToast(message, type = 'success') {
  const container = document.getElementById('toast-container');
  if (!container) return;

  const toast = document.createElement('div');
  toast.className = `d-flex align-items-center justify-content-between p-3 rounded-3 shadow-lg border text-white animated-fade ${
    type === 'error' ? 'bg-danger border-danger-subtle' :
    type === 'info' ? 'bg-primary border-primary-subtle' :
    'bg-met-navy border-warning'
  }`;
  toast.style.minWidth = '320px';
  toast.style.maxWidth = '450px';

  toast.innerHTML = `
    <div class="d-flex align-items-center gap-2">
      <i class="bi ${type === 'error' ? 'bi-exclamation-triangle-fill text-white' : type === 'info' ? 'bi-info-circle-fill text-info' : 'bi-check-circle-fill text-gold'} fs-5"></i>
      <span class="fw-medium small">${message}</span>
    </div>
    <button type="button" class="btn-close btn-close-white ms-2" onclick="this.parentElement.remove()"></button>
  `;

  container.appendChild(toast);
  setTimeout(() => {
    if (toast.parentElement) toast.remove();
  }, 4000);
}

// Active Navbar Item Highlighter
function updateActiveNav() {
  const path = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.met-navbar .nav-link').forEach(link => {
    const href = link.getAttribute('href');
    if (href) {
      const linkFile = href.split('/').pop();
      if (linkFile === path || (path === '' && linkFile === 'index.html')) {
        link.classList.add('active');
      } else {
        link.classList.remove('active');
      }
    }
  });
}

// Multi-Page Navigation Helper Function
function navigate(pageId) {
  const pageMap = {
    home: 'index.html',
    about: 'about.html',
    services: 'services.html',
    projects: 'projects.html',
    estimator: 'estimator.html',
    quote: 'quote.html',
    blog: 'blog.html',
    contact: 'contact.html',
    client: 'client.html',
    admin: 'admin.html'
  };

  if (pageMap[pageId]) {
    window.location.href = pageMap[pageId];
  } else if (pageId.endsWith('.html')) {
    window.location.href = pageId;
  } else {
    window.location.href = 'index.html';
  }
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
  if (subViewId === 'hr') renderHRManager();
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

// Cost Estimator Real-Time Engine
function calculateCost() {
  const estAreaEl = document.getElementById('est-area');
  if (!estAreaEl) return;

  const area = parseInt(estAreaEl.value || 450, 10);
  const floors = parseInt(document.getElementById('est-floors')?.value || 2, 10);
  const buildingType = document.querySelector('input[name="est-type"]:checked')?.value || 'villa';
  const finishingTier = document.querySelector('input[name="est-tier"]:checked')?.value || 'deluxe';

  const baseRates = { villa: 600, office: 800, mall: 950, warehouse: 420 };
  const finishingMultipliers = { standard: 1.0, deluxe: 1.35, ultra: 1.75 };

  let extrasTotal = 0;
  if (document.getElementById('est-extra-pool')?.checked) extrasTotal += 35000;
  if (document.getElementById('est-extra-smart')?.checked) extrasTotal += 25000;
  if (document.getElementById('est-extra-solar')?.checked) extrasTotal += 20000;
  if (document.getElementById('est-extra-landscape')?.checked) extrasTotal += 15000;

  const baseCostPerSqM = (baseRates[buildingType] || 600) * (finishingMultipliers[finishingTier] || 1.35);
  const floorMultiplier = 1 + ((floors - 1) * 0.05);
  const areaCost = area * baseCostPerSqM * floorMultiplier;

  const totalCost = Math.round(areaCost + extrasTotal);
  const costPerSqM = Math.round(totalCost / area);
  const estMonths = Math.max(6, Math.round(4 + (floors * 1.5) + (area > 2000 ? 4 : 0)));

  // Update UI Elements safely
  if (document.getElementById('est-area-val')) document.getElementById('est-area-val').innerText = `${area.toLocaleString()} m²`;
  if (document.getElementById('est-floors-val')) document.getElementById('est-floors-val').innerText = `${floors} Floors`;
  if (document.getElementById('est-output-total')) document.getElementById('est-output-total').innerText = `$${totalCost.toLocaleString()}`;
  if (document.getElementById('est-output-sqm')) document.getElementById('est-output-sqm').innerText = `~ $${costPerSqM.toLocaleString()} / m²`;
  if (document.getElementById('est-output-months')) document.getElementById('est-output-months').innerText = `${estMonths} Months`;

  if (document.getElementById('est-breakdown-struct')) document.getElementById('est-breakdown-struct').innerText = `$${Math.round(totalCost * 0.40).toLocaleString()}`;
  if (document.getElementById('est-breakdown-finishes')) document.getElementById('est-breakdown-finishes').innerText = `$${Math.round(totalCost * 0.45).toLocaleString()}`;
  if (document.getElementById('est-breakdown-mep')) document.getElementById('est-breakdown-mep').innerText = `$${Math.round(totalCost * 0.15).toLocaleString()}`;

  state.estimatorPreset = { area, floors, buildingType, finishingTier, totalCost, costPerSqM, estMonths };
}

// Transfer Estimate to Quote Page
function applyEstimateToQuote() {
  calculateCost();
  if (state.estimatorPreset) {
    localStorage.setItem('met_estimator_preset', JSON.stringify(state.estimatorPreset));
  }
  window.location.href = 'quote.html';
}

// Check for Transferred Estimate on Quote Page Load
function checkQuotePreset() {
  const alertBox = document.getElementById('quote-preset-alert');
  const presetRaw = localStorage.getItem('met_estimator_preset');
  if (presetRaw) {
    try {
      const preset = JSON.parse(presetRaw);
      if (document.getElementById('quote-area')) document.getElementById('quote-area').value = `${preset.area} sq.m`;
      if (document.getElementById('quote-budget')) document.getElementById('quote-budget').value = `$${preset.totalCost.toLocaleString()}`;
      if (document.getElementById('quote-notes')) document.getElementById('quote-notes').value = `Pre-calculated estimate: ${preset.floors} floors, ${preset.finishingTier} tier. Estimated duration: ${preset.estMonths} months.`;
      if (alertBox) alertBox.style.display = 'flex';
      localStorage.removeItem('met_estimator_preset');
    } catch(e) {}
  }
}

// Submit Quote Request Form
function submitQuoteForm(e) {
  e.preventDefault();
  const recaptcha = document.getElementById('quote-recaptcha');
  if (recaptcha && !recaptcha.checked) {
    alert("Please check the reCAPTCHA verification box.");
    return;
  }

  const newLead = {
    id: `LEAD-${Math.floor(100 + Math.random() * 900)}`,
    name: document.getElementById('quote-name')?.value || "Client Inquiry",
    email: document.getElementById('quote-email')?.value || "client@email.com",
    phone: document.getElementById('quote-phone')?.value || "+966 50 000 0000",
    location: document.getElementById('quote-location')?.value || "Riyadh",
    projectType: document.getElementById('quote-type')?.value || "Residential Complex",
    area: document.getElementById('quote-area')?.value || '500 sq.m',
    budget: document.getElementById('quote-budget')?.value || '$2.0M',
    status: 'New',
    assignedTo: 'Sales Rep - Unassigned',
    date: new Date().toISOString().split('T')[0],
    notes: document.getElementById('quote-notes')?.value || ''
  };

  state.leads.unshift(newLead);
  showToast("Quote proposal request submitted successfully! Our engineers will contact you.");
  
  e.target.reset();
  if (document.getElementById('quote-preset-alert')) document.getElementById('quote-preset-alert').style.display = 'none';
  renderAdminOverview();
}

// Submit Direct Contact Form
function submitContactForm(e) {
  e.preventDefault();
  const recaptcha = document.getElementById('contact-recaptcha');
  if (recaptcha && !recaptcha.checked) {
    alert("Please verify reCAPTCHA before submitting.");
    return;
  }

  showToast("Message sent successfully to our engineering executive office!");
  e.target.reset();
}

// Projects Filter Helper
window.currentProjectFilter = 'all';
function filterProjectsCategory(cat, btnEl) {
  window.currentProjectFilter = cat;
  document.querySelectorAll('.filter-btn').forEach(b => {
    b.className = "btn btn-sm btn-outline-dark px-3 filter-btn";
  });
  if (btnEl) btnEl.className = "btn btn-sm btn-met-navy text-white px-3 filter-btn active";
  
  const searchVal = document.getElementById('project-search')?.value || '';
  renderProjects(cat, searchVal);
}

// Projects Portfolio Render
function renderProjects(filterCategory = 'all', searchQuery = '') {
  const container = document.getElementById('projects-grid');
  const homeContainer = document.getElementById('home-featured-projects');

  const filtered = state.projects.filter(p => {
    const matchCat = filterCategory === 'all' || p.category === filterCategory;
    const title = p.title;
    const matchSearch = title.toLowerCase().includes(searchQuery.toLowerCase()) || p.location.toLowerCase().includes(searchQuery.toLowerCase());
    return matchCat && matchSearch;
  });

  const cardsHtml = filtered.map(p => `
    <div class="col-lg-4 col-md-6">
      <div class="glass-card h-100 overflow-hidden d-flex flex-column justify-content-between">
        <div>
          <div class="position-relative overflow-hidden">
            <img src="${p.image}" alt="${p.title}" class="w-100 object-fit-cover" style="height: 220px;" />
            <span class="position-absolute top-0 start-0 m-3 badge ${p.status === 'Completed' ? 'bg-success' : 'bg-warning text-dark'}">
              ${p.status}
            </span>
            <span class="position-absolute bottom-0 end-0 m-3 badge bg-met-navy text-gold">
              ${p.completion}% Completed
            </span>
          </div>

          <div class="p-4">
            <div class="small text-gold fw-bold text-uppercase mb-1">${p.category}</div>
            <h5 class="fw-bold text-met-navy mb-2">${p.title}</h5>
            <p class="small text-muted mb-3 line-clamp-2">${p.description}</p>

            <div class="d-flex flex-column gap-1 small text-secondary mb-3">
              <div><i class="bi bi-building text-gold"></i> Client: <strong>${p.client}</strong></div>
              <div><i class="bi bi-geo-alt-fill text-gold"></i> Location: <strong>${p.location}</strong></div>
            </div>

            <div class="mb-3">
              <div class="d-flex justify-content-between small text-muted mb-1">
                <span>Site Progress</span>
                <span class="fw-bold">${p.completion}%</span>
              </div>
              <div class="progress" style="height: 6px;">
                <div class="progress-bar ${p.completion === 100 ? 'bg-success' : 'bg-warning'}" style="width: ${p.completion}%;"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="p-4 pt-0 border-top mt-auto">
          <div class="d-flex justify-content-between align-items-center pt-3">
            <span class="fw-bold text-met-navy fs-5">${p.budget}</span>
            <button class="btn btn-sm btn-outline-dark d-flex align-items-center gap-1" onclick="openProjectModal('${p.id}')">
              <i class="bi bi-eye"></i> Details
            </button>
          </div>
        </div>
      </div>
    </div>
  `).join('');

  if (container) container.innerHTML = cardsHtml;
  if (homeContainer) homeContainer.innerHTML = state.projects.slice(0, 3).map(p => `
    <div class="col-lg-4 col-md-6">
      <div class="glass-card h-100 overflow-hidden d-flex flex-column justify-content-between">
        <div>
          <img src="${p.image}" alt="${p.title}" class="w-100 object-fit-cover" style="height: 200px;" />
          <div class="p-4">
            <span class="badge bg-met-navy text-gold mb-2">${p.category}</span>
            <h5 class="fw-bold text-met-navy mb-2">${p.title}</h5>
            <p class="small text-muted mb-3 line-clamp-2">${p.description}</p>
          </div>
        </div>
        <div class="p-4 pt-0 border-top mt-auto">
          <div class="d-flex justify-content-between align-items-center pt-3">
            <span class="fw-bold text-met-navy">${p.budget}</span>
            <button class="btn btn-sm btn-outline-dark" onclick="openProjectModal('${p.id}')">Details</button>
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
  if (document.getElementById('kpi-leads-count')) document.getElementById('kpi-leads-count').innerText = state.leads.length;
  if (document.getElementById('kpi-sites-count')) document.getElementById('kpi-sites-count').innerText = state.projects.filter(p => p.status === 'Under Construction').length;
  if (document.getElementById('kpi-hr-count')) document.getElementById('kpi-hr-count').innerText = state.applicants.length;

  const tbody = document.getElementById('admin-overview-leads-body');
  if (tbody) {
    tbody.innerHTML = state.leads.slice(0, 4).map(l => `
      <tr>
        <td><div class="fw-bold">${l.name}</div><div class="small text-muted">${l.email}</div></td>
        <td class="small">${l.projectType}</td>
        <td class="small">${l.location}</td>
        <td class="fw-bold text-met-navy small">${l.budget}</td>
        <td>
          <span class="badge ${l.status === 'New' ? 'bg-danger' : l.status === 'Contracted' ? 'bg-success' : 'bg-warning text-dark'}">
            ${l.status}
          </span>
        </td>
      </tr>
    `).join('');
  }
}

// CMS Projects CRUD Table
function renderCMSProjects() {
  const tbody = document.getElementById('cms-projects-body');
  if (!tbody) return;

  tbody.innerHTML = state.projects.map(p => `
    <tr>
      <td class="fw-bold text-met-navy">${p.id}</td>
      <td>
        <div class="d-flex align-items-center gap-3">
          <img src="${p.image}" alt="" class="rounded-2 object-fit-cover" style="width: 50px; height: 40px;" />
          <div>
            <div class="fw-bold">${p.title}</div>
            <div class="small text-muted">${p.location}</div>
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
      <td class="fw-bold text-met-navy small">${p.budget}</td>
      <td>
        <button class="btn btn-sm btn-outline-danger" onclick="deleteCMSProject('${p.id}')">
          <i class="bi bi-trash"></i>
        </button>
      </td>
    </tr>
  `).join('');
}

function deleteCMSProject(id) {
  state.projects = state.projects.filter(p => p.id !== id);
  renderCMSProjects();
  renderProjects();
  showToast("Project deleted from CMS.", "info");
}

function addProjectCMS(e) {
  e.preventDefault();
  const newP = {
    id: `PRJ-${Math.floor(1000 + Math.random() * 9000)}`,
    title: document.getElementById('cms-title').value,
    category: document.getElementById('cms-category').value,
    status: 'Under Construction',
    client: document.getElementById('cms-client').value,
    location: document.getElementById('cms-location').value,
    area: parseInt(document.getElementById('cms-area').value, 10),
    floors: 3,
    duration: "18 Months",
    budget: document.getElementById('cms-budget').value,
    completion: parseInt(document.getElementById('cms-completion').value, 10),
    image: document.getElementById('cms-image').value || "https://images.unsplash.com/photo-1541888946425-d0fbb186a5b7?auto=format&fit=crop&w=800&q=80",
    description: document.getElementById('cms-desc').value
  };

  state.projects.unshift(newP);
  renderCMSProjects();
  renderProjects();
  showToast("New project published to CMS portfolio!");
  
  const modalEl = document.getElementById('addCMSModal');
  if (modalEl && typeof bootstrap !== 'undefined') {
    const modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) modal.hide();
  }
  e.target.reset();
}

// CRM Leads Table
function renderCRMLeads() {
  const tbody = document.getElementById('crm-leads-body');
  if (!tbody) return;

  tbody.innerHTML = state.leads.map(l => `
    <tr>
      <td class="fw-bold text-met-navy">${l.id}</td>
      <td>
        <div class="fw-bold">${l.name}</div>
        <div class="small text-muted"><i class="bi bi-envelope"></i> ${l.email}</div>
      </td>
      <td>
        <div class="small fw-semibold">${l.projectType}</div>
        <div class="small text-muted">${l.location} (${l.area})</div>
      </td>
      <td class="fw-bold text-met-navy small">${l.budget}</td>
      <td>
        <select class="form-select form-select-sm fw-semibold" onchange="updateLeadStatus('${l.id}', this.value)">
          <option value="New" ${l.status === 'New' ? 'selected' : ''}>New</option>
          <option value="Under Review" ${l.status === 'Under Review' ? 'selected' : ''}>Under Review</option>
          <option value="Contacted" ${l.status === 'Contacted' ? 'selected' : ''}>Contacted</option>
          <option value="Contracted" ${l.status === 'Contracted' ? 'selected' : ''}>Contracted</option>
          <option value="Cancelled" ${l.status === 'Cancelled' ? 'selected' : ''}>Cancelled</option>
        </select>
      </td>
      <td>
        <select class="form-select form-select-sm" onchange="assignLead('${l.id}', this.value)">
          <option value="Sales Rep - Unassigned" ${l.assignedTo === 'Sales Rep - Unassigned' ? 'selected' : ''}>Unassigned</option>
          <option value="Sales Rep - Omar S." ${l.assignedTo === 'Sales Rep - Omar S.' ? 'selected' : ''}>Sales Rep - Omar S.</option>
          <option value="Sales Rep - Sarah M." ${l.assignedTo === 'Sales Rep - Sarah M.' ? 'selected' : ''}>Sales Rep - Sarah M.</option>
          <option value="General Manager" ${l.assignedTo === 'General Manager' ? 'selected' : ''}>General Manager</option>
        </select>
      </td>
    </tr>
  `).join('');
}

function updateLeadStatus(id, newStatus) {
  const l = state.leads.find(item => item.id === id);
  if (l) l.status = newStatus;
  showToast(`Lead ${id} status updated to ${newStatus}`);
  renderAdminOverview();
}

function assignLead(id, repName) {
  const l = state.leads.find(item => item.id === id);
  if (l) l.assignedTo = repName;
  showToast(`Lead ${id} assigned to ${repName}`);
}

// Site Manager & Client Portal Stream Render
function renderSiteManager() {
  const container = document.getElementById('site-stream-grid');
  const clientGrid = document.getElementById('client-photo-stream');
  if (!container && !clientGrid) return;

  const html = state.siteUpdates.map(up => `
    <div class="col-md-6">
      <div class="glass-card overflow-hidden h-100">
        <img src="${up.photo}" alt="" class="w-100 object-fit-cover" style="height: 220px;" />
        <div class="p-4">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="badge bg-met-navy text-gold">${up.stage}</span>
            <span class="small text-muted">${up.date}</span>
          </div>
          <h5 class="fw-bold text-met-navy mb-2">${up.title}</h5>
          <p class="small text-muted mb-3">${up.notes}</p>
          <div class="small text-secondary fw-semibold border-top pt-2">
            Supervisor: ${up.engineer}
          </div>
        </div>
      </div>
    </div>
  `).join('');

  if (container) container.innerHTML = html;
  if (clientGrid) clientGrid.innerHTML = html;
}

function addSiteUpdate(e) {
  e.preventDefault();
  const created = {
    id: Date.now(),
    date: new Date().toISOString().split('T')[0],
    title: document.getElementById('site-title').value,
    stage: document.getElementById('site-stage').value,
    engineer: "Eng. Mahmoud R. (Senior Site Supervisor)",
    photo: document.getElementById('site-photo').value || "https://images.unsplash.com/photo-1541888946425-d0fbb186a5b7?auto=format&fit=crop&w=600&q=80",
    notes: document.getElementById('site-notes').value
  };

  state.siteUpdates.unshift(created);
  renderSiteManager();
  showToast("Site update published & synced to Client Portal!");
  
  const modalEl = document.getElementById('addSiteModal');
  if (modalEl && typeof bootstrap !== 'undefined') {
    const modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) modal.hide();
  }
  e.target.reset();
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
  const created = {
    id: `APP-${Math.floor(500 + Math.random() * 500)}`,
    name: document.getElementById('hr-app-name').value,
    email: document.getElementById('hr-app-email').value,
    job: document.getElementById('hr-app-job').value,
    exp: document.getElementById('hr-app-exp').value || '5 Years',
    status: 'Pending Review',
    cvName: 'Candidate_Resume.pdf'
  };

  state.applicants.unshift(created);
  renderHRManager();
  showToast("Application & CV submitted successfully!");
  
  const modalEl = document.getElementById('addHRModal');
  if (modalEl && typeof bootstrap !== 'undefined') {
    const modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) modal.hide();
  }
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
  calculateCost();
  checkQuotePreset();

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