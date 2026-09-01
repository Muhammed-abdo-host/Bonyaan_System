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
                <button class="btn btn-sm btn-outline-secondary" onclick="setAdminSubView('roles')">RBAC Roles</button>
            </div>
        </div>

        <div id="admin-overview" class="subview-section active">
            <div class="row g-4 mb-4">
                <div class="col-md-4">
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

                <div class="col-md-4">
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

                <div class="col-md-4">
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
                            <label class="form-label small fw-bold" for="cms-desc">Description</label>
                            <textarea id="cms-desc" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                            <button
                                type="button"
                                class="btn btn-outline-secondary"
                                onclick="toggleCMSProjectForm(false)"
                            >
                                Cancel
                            </button>

                            <button type="submit" class="btn btn-met-gold fw-bold">
                                Publish Project
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
                                <th>Project Title & Location</th>
                                <th>Category</th>
                                <th>Client</th>
                                <th>Progress</th>
                                <th>Budget</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="cms-projects-body"></tbody>
                    </table>
                </div>
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

                <form id="add-site-update-form" onsubmit="publishSiteUpdate(event)">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold" for="site-project">Project</label>

                            <select id="site-project" class="form-select" required>
                                <option value="">Loading projects...</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold" for="site-phase">
                                Construction Phase
                            </label>

                            <select id="site-phase" class="form-select" required>
                                <option value="excavation">Excavation</option>
                                <option value="structure">Structure</option>
                                <option value="mep">MEP</option>
                                <option value="finishing">Finishing</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold" for="site-title">Update Title</label>

                            <input
                                type="text"
                                id="site-title"
                                class="form-control"
                                required
                                placeholder="Example: Ground-floor concrete pouring completed"
                            >
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold" for="site-description">
                                Description
                            </label>

                            <textarea
                                id="site-description"
                                class="form-control"
                                rows="4"
                                placeholder="Describe the work completed, next steps, and any important notes..."
                            ></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold" for="site-image">Site Photo</label>

                            <input
                                type="file"
                                id="site-image"
                                class="form-control"
                                accept=".jpg,.jpeg,.png,.webp"
                            >

                            <div class="form-text">
                                Optional. JPG, JPEG, PNG, or WEBP — maximum 5 MB.
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end gap-2 mt-3">
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
</section>
@endsection