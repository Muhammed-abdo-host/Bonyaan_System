@extends('components.layouts')

@section('content')
<section id="view-admin" class="view-section active animated-fade py-5">
    <div class="container py-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div>
                <span class="badge badge-gold mb-2">Admin Dashboard</span>
                <h1 class="display-6 fw-bold text-met-navy m-0">
                    Executive Operations Dashboard
                </h1>
            </div>

            <div class="btn-group" id="admin-pills">
                <button class="btn btn-sm btn-met-navy text-white" onclick="setAdminSubView('overview')">Overview</button>
                <button class="btn btn-sm btn-outline-secondary" onclick="setAdminSubView('cms')">CMS Portfolio</button>
                <button class="btn btn-sm btn-outline-secondary" onclick="setAdminSubView('crm')">CRM Leads</button>
                <button class="btn btn-sm btn-outline-secondary" onclick="setAdminSubView('site')">Site Tracker</button>
                <button class="btn btn-sm btn-outline-secondary" onclick="setAdminSubView('hr')">HR & Jobs</button>
                <button class="btn btn-sm btn-outline-secondary" onclick="setAdminSubView('messages')">Contact Messages</button>
                <button class="btn btn-sm btn-outline-secondary" onclick="setAdminSubView('blog')">Blog & News</button>
                <button class="btn btn-sm btn-outline-secondary" onclick="setAdminSubView('roles')">RBAC Roles</button>
            </div>
        </div>

        <div id="admin-overview" class="subview-section active">
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="glass-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small text-muted">Active Quote Inquiries</div>
                                <h2 class="display-6 fw-bold text-met-navy m-0" id="kpi-leads-count">0</h2>
                            </div>
                            <div class="bg-primary text-white rounded-3 p-3 fs-3">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="glass-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small text-muted">Construction Sites</div>
                                <h2 class="display-6 fw-bold text-met-navy m-0" id="kpi-sites-count">0</h2>
                            </div>
                            <div class="bg-warning text-dark rounded-3 p-3 fs-3">
                                <i class="bi bi-building"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="glass-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small text-muted">Career Applicants</div>
                                <h2 class="display-6 fw-bold text-met-navy m-0" id="kpi-hr-count">0</h2>
                            </div>
                            <div class="bg-success text-white rounded-3 p-3 fs-3">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="glass-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small text-muted">New Contact Messages</div>
                                <h2 class="display-6 fw-bold text-met-navy m-0" id="kpi-messages-count">0</h2>
                            </div>
                            <div class="bg-info text-white rounded-3 p-3 fs-3">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card p-4">
                <h5 class="fw-bold text-met-navy mb-3">Recent Inbound Quote Inquiries</h5>

                <div class="table-responsive">
                    <table class="table custom-table align-middle">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Target Budget</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody id="admin-overview-leads-body"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="admin-cms" class="subview-section">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold text-met-navy m-0">Portfolio CMS Manager</h4>

                <button
                    type="button"
                    class="btn btn-met-gold btn-sm fw-bold"
                    onclick="toggleCMSProjectForm()"
                >
                    <i class="bi bi-plus-lg"></i>
                    Add New Project
                </button>
            </div>

            <div id="addCMSProjectPanel" class="glass-card p-4 mb-4 d-none">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-met-navy m-0">Add New Project</h5>

                    <button
                        type="button"
                        class="btn-close"
                        aria-label="Close"
                        onclick="toggleCMSProjectForm(false)"
                    ></button>
                </div>

                <form id="add-project-form" onsubmit="addProjectCMS(event)">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold" for="cms-title">Project Title</label>
                            <input type="text" id="cms-title" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold" for="cms-category">Category</label>

                            <select id="cms-category" class="form-select" required>
                                <option value="villa">Villa</option>
                                <option value="office">Office</option>
                                <option value="mall">Mall</option>
                                <option value="warehouse">Warehouse</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold" for="cms-client">Client</label>

                            <select id="cms-client" class="form-select" required>
                                <option value="">Loading clients...</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold" for="cms-location">Location</label>
                            <input type="text" id="cms-location" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold" for="cms-area">Area (sq.m)</label>
                            <input type="number" id="cms-area" class="form-control" min="1" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold" for="cms-budget">Budget</label>
                            <input type="text" id="cms-budget" class="form-control" placeholder="$1.2M">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold" for="cms-completion">Completion %</label>

                            <input
                                type="number"
                                id="cms-completion"
                                class="form-control"
                                min="0"
                                max="100"
                                value="0"
                            >
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold" for="cms-image">Image URL</label>
                            <input type="url" id="cms-image" class="form-control" placeholder="https://...">
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold" for="cms-description">Description</label>
                            <textarea id="cms-description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="col-12 d-flex justify-content-end gap-2">
                            <button
                                type="button"
                                class="btn btn-outline-secondary"
                                onclick="toggleCMSProjectForm(false)"
                            >
                                Cancel
                            </button>

                            <button type="submit" class="btn btn-met-gold fw-bold">
                                Save Project
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="glass-card p-3">
                <div class="table-responsive">
                    <table class="table custom-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Project</th>
                                <th>Client</th>
                                <th>Location</th>
                                <th>Area</th>
                                <th>Budget</th>
                                <th>Completion</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody id="cms-projects-body"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="admin-blog" class="subview-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-met-navy m-0">Blog & News Manager</h4>

        <button
            type="button"
            class="btn btn-met-gold btn-sm fw-bold"
            onclick="toggleBlogPostForm()"
        >
            <i class="bi bi-plus-lg"></i>
            Add New Article
        </button>
    </div>

    <div id="addBlogPostPanel" class="glass-card p-4 mb-4 d-none">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold text-met-navy m-0">Add New Article</h5>

            <button
                type="button"
                class="btn-close"
                aria-label="Close"
                onclick="toggleBlogPostForm(false)"
            ></button>
        </div>

        <form id="add-blog-form" onsubmit="addBlogPost(event)">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label small fw-bold" for="blog-title">Title</label>
                    <input type="text" id="blog-title" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-bold" for="blog-category">Category</label>
                    <input type="text" id="blog-category" class="form-control" placeholder="Engineering">
                </div>

                <div class="col-12">
                    <label class="form-label small fw-bold" for="blog-image">Cover Image URL</label>
                    <input type="text" id="blog-image" class="form-control" placeholder="https://...">
                </div>

                <div class="col-12">
                    <label class="form-label small fw-bold" for="blog-excerpt">Excerpt (short summary)</label>
                    <input type="text" id="blog-excerpt" class="form-control" maxlength="500">
                </div>

                <div class="col-12">
                    <label class="form-label small fw-bold" for="blog-content">Content</label>
                    <textarea id="blog-content" class="form-control" rows="6" required></textarea>
                </div>

                <div class="col-12 form-check ps-4">
                    <input type="checkbox" class="form-check-input" id="blog-published" checked>
                    <label class="form-check-label small fw-bold" for="blog-published">Publish immediately</label>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-met-gold fw-bold w-100">Save Article</button>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table custom-table align-middle">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>

            <tbody id="blog-posts-body"></tbody>
        </table>
    </div>
</div>

        <div id="admin-crm" class="subview-section">
            <h4 class="fw-bold text-met-navy mb-3">CRM & Proposal Inquiries Manager</h4>

            <div class="glass-card p-3">
                <div class="table-responsive">
                    <table class="table custom-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Client Contact</th>
                                <th>Project Details</th>
                                <th>Budget</th>
                                <th>Status</th>
                                <th>Attachments</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody id="crm-leads-body"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="admin-site" class="subview-section">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold text-met-navy m-0">
                    Construction Site Inspection Tracker
                </h4>

                <button
                    type="button"
                    class="btn btn-met-gold btn-sm fw-bold"
                    onclick="toggleSiteUpdateForm()"
                >
                    <i class="bi bi-camera-fill"></i>
                    Publish Site Update
                </button>
            </div>

            <div id="addSiteUpdatePanel" class="glass-card p-4 mb-4 d-none">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-met-navy m-0">Publish Site Update</h5>

                    <button
                        type="button"
                        class="btn-close"
                        aria-label="Close"
                        onclick="toggleSiteUpdateForm(false)"
                    ></button>
                </div>

                <form id="add-site-update-form" onsubmit="addSiteUpdate(event)">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold" for="site-project">Project</label>

                            <select id="site-project" class="form-select" required>
                                <option value="">Loading projects...</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold" for="site-title">Update Title</label>
                            <input type="text" id="site-title" class="form-control" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold" for="site-image">Photo URL</label>
                            <input type="url" id="site-image" class="form-control" placeholder="https://...">
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold" for="site-notes">Inspection Notes</label>
                            <textarea id="site-notes" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="col-12 d-flex justify-content-end gap-2">
                            <button
                                type="button"
                                class="btn btn-outline-secondary"
                                onclick="toggleSiteUpdateForm(false)"
                            >
                                Cancel
                            </button>

                            <button type="submit" class="btn btn-met-gold fw-bold">
                                Publish Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row g-4" id="site-stream-grid"></div>
        </div>

        <div id="admin-hr" class="subview-section">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold text-met-navy m-0">HR Job Applicants & Resumes</h4>

                <button
                    type="button"
                    class="btn btn-met-gold btn-sm fw-bold"
                    disabled
                    title="HR management will be added in a later phase."
                >
                    <i class="bi bi-person-plus-fill"></i>
                    Add Candidate
                </button>
            </div>

            <div class="glass-card p-3">
                <div class="table-responsive">
                    <table class="table custom-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Candidate</th>
                                <th>Applied Position</th>
                                <th>Experience</th>
                                <th>CV File</th>
                                <th>Recruitment Stage</th>
                            </tr>
                        </thead>

                        <tbody id="hr-applicants-body"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="admin-messages" class="subview-section">
            <h4 class="fw-bold text-met-navy mb-3">Contact Messages</h4>

            <div class="glass-card p-3">
                <div class="table-responsive">
                    <table class="table custom-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Sender</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody id="messages-body"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="admin-roles" class="subview-section">
            <h4 class="fw-bold text-met-navy mb-3">
                Role-Based Access Control (RBAC) Switcher
            </h4>

            <div class="glass-card p-4">
                <p class="text-muted">
                    Select an active user role context to simulate permission boundaries across the system:
                </p>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 border rounded-3 text-center cursor-pointer bg-light" onclick="setRole('gm')">
                            <i class="bi bi-person-badge-fill text-gold fs-2"></i>
                            <h6 class="fw-bold mt-2 mb-1">General Manager</h6>
                            <span class="small text-muted">Full System Access & Financial Approvals</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-3 border rounded-3 text-center cursor-pointer bg-light" onclick="setRole('sales')">
                            <i class="bi bi-briefcase-fill text-primary fs-2"></i>
                            <h6 class="fw-bold mt-2 mb-1">Sales Rep</h6>
                            <span class="small text-muted">CRM Leads & Proposal Management</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-3 border rounded-3 text-center cursor-pointer bg-light" onclick="setRole('supervisor')">
                            <i class="bi bi-tools text-warning fs-2"></i>
                            <h6 class="fw-bold mt-2 mb-1">Site Supervisor</h6>
                            <span class="small text-muted">Publish Site Photos & Inspection Stream</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-3 border rounded-3 text-center cursor-pointer bg-light" onclick="setRole('editor')">
                            <i class="bi bi-pencil-square text-info fs-2"></i>
                            <h6 class="fw-bold mt-2 mb-1">Content Editor</h6>
                            <span class="small text-muted">Portfolio CMS & News Publisher</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-3 border rounded-3 text-center cursor-pointer bg-light" onclick="setRole('client')">
                            <i class="bi bi-person-heart text-danger fs-2"></i>
                            <h6 class="fw-bold mt-2 mb-1">Client User</h6>
                            <span class="small text-muted">Client Portal Workspace Only</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Message Detail Modal -->
    <div class="modal fade" id="contactMessageModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content glass-card p-0 border-0 overflow-hidden">
                <div class="modal-header bg-met-navy text-white">
                    <h5 class="modal-title fw-bold" id="cm-modal-subject">Message Subject</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="small text-muted">From</div>
                            <div class="fw-bold text-met-navy" id="cm-modal-from">-</div>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted">Received</div>
                            <div class="fw-semibold" id="cm-modal-date">-</div>
                        </div>
                    </div>

                    <span class="badge bg-secondary mb-3" id="cm-modal-status-badge">new</span>

                    <p class="text-secondary" id="cm-modal-body" style="white-space: pre-wrap;"></p>
                </div>
                <div class="modal-footer bg-light">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
// ===== HR MODULE =====

async function loadHrApplicants() {
    const tbody = document.getElementById('hr-applicants-body');
    const kpi   = document.getElementById('kpi-hr-count');
    tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4"><span class="spinner-border spinner-border-sm"></span> Loading...</td></tr>';

    try {
        const res  = await fetch('/admin/hr/applicants');
        const data = await res.json();

        if (kpi) kpi.textContent = data.length;

        if (!data.length) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4">No applicants yet.</td></tr>';
            return;
        }

        tbody.innerHTML = data.map(a => `
            <tr>
                <td class="text-muted small">#${a.id}</td>
                <td>
                    <div class="fw-bold">${a.name}</div>
                    <div class="small text-muted">${a.email}</div>
                    <div class="small text-muted">${a.phone}</div>
                </td>
                <td>${a.position}</td>
                <td class="text-muted small">${a.date}</td>
                <td>
                    ${a.cv_url
                        ? `<a href="${a.cv_url}" class="btn btn-sm btn-outline-primary" target="_blank"><i class="bi bi-download me-1"></i>CV</a>`
                        : '<span class="text-muted small">No CV</span>'}
                </td>
                <td>
                    <select class="form-select form-select-sm" onchange="updateApplicantStatus(${a.id}, this.value)" style="min-width:130px;">
                        ${['new','reviewing','interview','hired','rejected'].map(s =>
                            `<option value="${s}" ${a.status === s ? 'selected' : ''}>${s.charAt(0).toUpperCase() + s.slice(1)}</option>`
                        ).join('')}
                    </select>
                </td>
            </tr>
        `).join('');

    } catch (err) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center text-danger py-4">Failed to load applicants.</td></tr>';
    }
}

async function updateApplicantStatus(id, status) {
    await fetch(`/admin/hr/applicants/${id}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ status }),
    });
}

// تأكد إن loadHrApplicants بتتستدعى لما الـ HR tab يتفتح
// لو عندك function زي setAdminSubView، أضف جواها:
// if (view === 'hr') loadHrApplicants();
// وكمان استدعيها في أول تحميل الصفحة لتحديث الـ KPI:
document.addEventListener('DOMContentLoaded', () => {
    loadHrApplicants();
});
</script>
@endsection