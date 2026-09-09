@extends('components.layouts')

@section('content')
<section id="view-client" class="view-section active animated-fade py-5">
  <div class="container py-4">
    <div class="glass-card p-4 mb-4 bg-met-navy text-white">
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
          <span class="badge badge-gold mb-2">Client Portal</span>
          <h2 class="fw-bold text-white m-0">
            Welcome back, {{ auth()->user()->name }}
          </h2>
          <div class="small text-white-50 mt-1">
            View your construction projects and latest site updates.
          </div>
        </div>

        <button
          type="button"
          class="btn btn-met-gold fw-bold"
          onclick="toggleClientProjectForm()"
        >
          <i class="bi bi-plus-lg"></i>
          Request New Project
        </button>
      </div>
    </div>

    <div id="clientProjectRequestPanel" class="glass-card p-4 mb-4 d-none">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-met-navy m-0">Request a New Project</h5>

        <button
          type="button"
          class="btn-close"
          aria-label="Close"
          onclick="toggleClientProjectForm(false)"
        ></button>
      </div>

      <form id="client-project-request-form" onsubmit="submitClientProjectRequest(event)">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label small fw-bold" for="cpr-name">Project Title</label>
            <input type="text" id="cpr-name" class="form-control" required>
          </div>

          <div class="col-md-6">
            <label class="form-label small fw-bold" for="cpr-type">Project Type</label>

            <select id="cpr-type" class="form-select" required>
              <option value="villa">Villa</option>
              <option value="office">Office</option>
              <option value="mall">Mall</option>
              <option value="warehouse">Warehouse</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label small fw-bold" for="cpr-location">Location / City</label>
            <input type="text" id="cpr-location" class="form-control">
          </div>

          <div class="col-md-6">
            <label class="form-label small fw-bold" for="cpr-area">Built-Up Area (sq.m)</label>
            <input type="number" id="cpr-area" class="form-control" min="1" required>
          </div>

          <div class="col-md-6">
            <label class="form-label small fw-bold" for="cpr-floors">Number of Floors</label>
            <input type="number" id="cpr-floors" class="form-control" min="1" value="1">
          </div>

          <div class="col-md-6">
            <label class="form-label small fw-bold" for="cpr-budget">Target Budget</label>
            <input type="text" id="cpr-budget" class="form-control" placeholder="e.g. $1.5M - $2.0M">
          </div>

          <div class="col-12">
            <label class="form-label small fw-bold" for="cpr-description">Project Details & Requirements</label>
            <textarea id="cpr-description" class="form-control" rows="3"></textarea>
          </div>

          <div class="col-12 d-flex justify-content-end gap-2">
            <button
              type="button"
              class="btn btn-outline-secondary"
              onclick="toggleClientProjectForm(false)"
            >
              Cancel
            </button>

            <button type="submit" class="btn btn-met-gold fw-bold">
              Submit Request
            </button>
          </div>
        </div>
      </form>
    </div>

    @forelse ($projects as $project)

      @if ($project->status === 'pending')
      {{-- Pending projects: faded card, no progress tracker, no site updates. --}}
      <div class="glass-card p-4 mb-4" style="opacity: 0.65;">
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-2">
          <div>
            <span class="badge bg-primary mb-2">
              Project #{{ $project->id }}
            </span>

            <h3 class="fw-bold text-met-navy mb-1">
              {{ $project->name }}
            </h3>

            <div class="small text-muted">
              <i class="bi bi-geo-alt-fill text-gold me-1"></i>
              {{ $project->location ?: 'Location not specified' }}

              <span class="mx-2">•</span>

              {{ ucfirst($project->type) }}
            </div>
          </div>

          <span class="badge bg-secondary fs-6">
            <i class="bi bi-hourglass-split me-1"></i>
            Under Review
          </span>
        </div>

        <hr>

        <p class="text-muted mb-0">
          <i class="bi bi-info-circle me-1"></i>
          Your project request has been received and is currently under review by our team.
          You'll be able to track its progress here once it's accepted.
        </p>
      </div>
      @else
      {{-- Ongoing / Completed projects: full tracker + site updates. --}}
      <div class="glass-card p-4 mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-3">
          <div>
            <span class="badge bg-primary mb-2">
              Project #{{ $project->id }}
            </span>

            <h3 class="fw-bold text-met-navy mb-1">
              {{ $project->name }}
            </h3>

            <div class="small text-muted">
              <i class="bi bi-geo-alt-fill text-gold me-1"></i>
              {{ $project->location ?: 'Location not specified' }}

              <span class="mx-2">•</span>

              {{ ucfirst($project->type) }}
            </div>
          </div>

          <span class="badge {{ $project->status === 'completed' ? 'bg-success' : 'bg-warning text-dark' }} fs-6">
            {{ ucfirst($project->status) }}
          </span>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-2">
          <h5 class="fw-bold text-met-navy m-0">Overall Site Progress</h5>
          <span class="fw-bold text-success">
            {{ $project->progress_percent }}%
          </span>
        </div>

        <div
          class="progress mb-3"
          style="height: 12px;"
          role="progressbar"
          aria-valuenow="{{ $project->progress_percent }}"
          aria-valuemin="0"
          aria-valuemax="100">
          <div
            class="progress-bar bg-success progress-bar-striped progress-bar-animated"
            style="width: {{ $project->progress_percent }}%;"></div>
        </div>

        <div class="row g-3 small text-muted">
          <div class="col-md-4">
            <strong>Area:</strong>
            {{ number_format($project->area) }} sq.m
          </div>

          <div class="col-md-4">
            <strong>Floors:</strong>
            {{ $project->floors }}
          </div>

          <div class="col-md-4">
            <strong>Budget:</strong>
            {{ $project->budget ?: 'Not available' }}
          </div>
        </div>

        @if ($project->description)
        <hr>

        <p class="text-muted mb-0">
          {{ $project->description }}
        </p>
        @endif
      </div>

      <div class="mb-5">
        <h4 class="fw-bold text-met-navy mb-3">
          Latest Site Updates — {{ $project->name }}
        </h4>

        <div class="row g-3">
          @forelse ($project->siteUpdates as $update)
          <div class="col-md-6 col-lg-4">
            <div class="glass-card h-100 overflow-hidden">
              @if ($update->image_path)
              <img
                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($update->image_path) }}" class="img-fluid w-100"
                style="height: 190px; object-fit: cover;"
                alt="{{ $update->title }}">
              @else
              <div
                class="d-flex align-items-center justify-content-center bg-light text-muted"
                style="height: 190px;">
                <i class="bi bi-camera fs-1"></i>
              </div>
              @endif

              <div class="p-3">
                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                  <h6 class="fw-bold text-met-navy mb-0">
                    {{ $update->title }}
                  </h6>

                  <span class="badge bg-secondary">
                    {{ strtoupper($update->phase) }}
                  </span>
                </div>

                @if ($update->description)
                <p class="small text-muted mb-3">
                  {{ $update->description }}
                </p>
                @endif

                <div class="small text-muted">
                  <i class="bi bi-calendar3 me-1"></i>
                  {{ $update->created_at->format('d M Y') }}
                </div>
              </div>
            </div>
          </div>
          @empty
          <div class="col-12">
            <div class="alert alert-light border mb-0">
              No site updates have been published for this project yet.
            </div>
          </div>
          @endforelse
        </div>
      </div>
      @endif

    @empty
    <div class="glass-card p-5 text-center">
      <i class="bi bi-building fs-1 text-gold"></i>

      <h4 class="fw-bold text-met-navy mt-3">
        No projects yet
      </h4>

      <p class="text-muted mb-0">
        You haven't requested any project yet. Click "Request New Project" above to get started.
      </p>
    </div>
    @endforelse

    <div class="glass-card p-4">
      <h5 class="fw-bold text-met-navy mb-2">
        Financial Documents & Payments
      </h5>

      <p class="text-muted mb-0">
        This section will be activated when invoices and secure online payments are implemented.
      </p>
    </div>
  </div>
</section>
@endsection