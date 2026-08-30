@extends('components.layouts') {{-- لو عندك layout رئيسي، وإلا احذف السطر ده وحط <html> عادي --}}
@section('content')

<!-- ADMIN DASHBOARD VIEW SECTION -->
<section id="view-admin" class="view-section active animated-fade py-5">
  <div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
      <div>
        <span class="badge badge-gold mb-2">Admin Dashboard</span>
        <h1 class="display-6 fw-bold text-met-navy m-0">Executive Operations Dashboard</h1>
      </div>

      <!-- Navigation Subview Pills -->
      <div class="btn-group" id="admin-pills">
        <button class="btn btn-sm btn-met-navy text-white" onclick="setAdminSubView('overview')">Overview</button>
        <button class="btn btn-sm btn-outline-secondary" onclick="setAdminSubView('cms')">CMS Portfolio</button>
        <button class="btn btn-sm btn-outline-secondary" onclick="setAdminSubView('crm')">CRM Leads</button>
        <button class="btn btn-sm btn-outline-secondary" onclick="setAdminSubView('site')">Site Tracker</button>
        <button class="btn btn-sm btn-outline-secondary" onclick="setAdminSubView('hr')">HR & Jobs</button>
        <button class="btn btn-sm btn-outline-secondary" onclick="setAdminSubView('roles')">RBAC Roles</button>
      </div>
    </div>

    <!-- Subview 1: Admin Overview -->
    <div id="admin-overview" class="subview-section active">
      <div class="row g-4 mb-4">
        <div class="col-md-4">
          <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <div class="small text-muted">Active Quote Inquiries</div>
                <h2 class="display-6 fw-bold text-met-navy m-0" id="kpi-leads-count">3</h2>
              </div>
              <div class="bg-primary text-white rounded-3 p-3 fs-3"><i class="bi bi-file-earmark-text"></i></div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <div class="small text-muted">Construction Sites</div>
                <h2 class="display-6 fw-bold text-met-navy m-0" id="kpi-sites-count">2</h2>
              </div>
              <div class="bg-warning text-dark rounded-3 p-3 fs-3"><i class="bi bi-building"></i></div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <div class="small text-muted">Career Applicants</div>
                <h2 class="display-6 fw-bold text-met-navy m-0" id="kpi-hr-count">2</h2>
              </div>
              <div class="bg-success text-white rounded-3 p-3 fs-3"><i class="bi bi-people"></i></div>
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
            <tbody id="admin-overview-leads-body">
              <!-- JS inserted -->
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Subview 2: CMS Portfolio Manager -->
    <div id="admin-cms" class="subview-section">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-met-navy m-0">Portfolio CMS Manager</h4>
        <button class="btn btn-met-gold btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addCMSModal">
          <i class="bi bi-plus-lg"></i> Add New Project
        </button>
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
            <tbody id="cms-projects-body">
              <!-- JS inserted -->
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Subview 3: CRM Leads -->
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
                <th>Date</th>
              </tr>
            </thead>
            <tbody id="crm-leads-body">
              <!-- JS inserted -->
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Subview 4: Site Progress Stream -->
    <div id="admin-site" class="subview-section">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-met-navy m-0">Construction Site Inspection Tracker</h4>
        <button class="btn btn-met-gold btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addSiteModal">
          <i class="bi bi-camera-fill"></i> Publish Site Update
        </button>
      </div>

      <div class="row g-4" id="site-stream-grid">
        <!-- JS inserted -->
      </div>
    </div>

    <!-- Subview 5: HR & Recruitment -->
    <div id="admin-hr" class="subview-section">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-met-navy m-0">HR Job Applicants & Resumes</h4>
        <button class="btn btn-met-gold btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addHRModal">
          <i class="bi bi-person-plus-fill"></i> Add Candidate
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
            <tbody id="hr-applicants-body">
              <!-- JS inserted -->
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Subview 6: RBAC Roles Matrix -->
    <div id="admin-roles" class="subview-section">
      <h4 class="fw-bold text-met-navy mb-3">Role-Based Access Control (RBAC) Switcher</h4>
      <div class="glass-card p-4">
        <p class="text-muted">Select an active user role context to simulate permission boundaries across the system:</p>
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