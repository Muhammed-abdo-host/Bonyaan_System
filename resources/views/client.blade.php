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
      </div>
    </div>

    @forelse ($projects as $project)
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
    @empty
    <div class="glass-card p-5 text-center">
      <i class="bi bi-building fs-1 text-gold"></i>

      <h4 class="fw-bold text-met-navy mt-3">
        No projects assigned yet
      </h4>

      <p class="text-muted mb-0">
        Your account has not been linked to a project yet. Please contact Bonyaan support.
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