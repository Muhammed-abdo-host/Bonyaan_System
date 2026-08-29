@extends('components.layouts') {{-- لو عندك layout رئيسي، وإلا احذف السطر ده وحط <html> عادي --}}
@section('content')
     <!-- ABOUT VIEW SECTION -->
  <section id="view-about" class="view-section active animated-fade py-5">
    <div class="container py-4">
      <div class="text-center max-w-700 mx-auto mb-5">
        <span class="badge badge-gold mb-2">About Us</span>
        <h1 class="display-5 fw-bold text-met-navy mb-3">Constructing Legacy with Precision & Integrity</h1>
        <p class="lead text-muted">Founded in 2002, project_MET has evolved into a premier full-service contracting powerhouse.</p>
      </div>

      <!-- Core Values -->
      <div class="row g-4 mb-5">
        <div class="col-md-4">
          <div class="glass-card p-4 text-center">
            <i class="bi bi-shield-check text-gold fs-1 mb-3"></i>
            <h5 class="fw-bold text-met-navy">Uncompromising Quality</h5>
            <p class="small text-muted">ISO 9001:2015 certified quality controls ensure zero structural defect tolerances.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="glass-card p-4 text-center">
            <i class="bi bi-cpu text-gold fs-1 mb-3"></i>
            <h5 class="fw-bold text-met-navy">Advanced Technology</h5>
            <p class="small text-muted">BIM 3D modeling, automated drone inspections, and real-time client portal tracking.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="glass-card p-4 text-center">
            <i class="bi bi-hand-thumbs-up text-gold fs-1 mb-3"></i>
            <h5 class="fw-bold text-met-navy">Transparent Ethics</h5>
            <p class="small text-muted">Clear contracts, predictable financial milestones, and zero hidden costs.</p>
          </div>
        </div>
      </div>

      <!-- Executive Leadership -->
      <h3 class="fw-bold text-met-navy mb-4 text-center">Executive Leadership Team</h3>
      <div class="row g-4">
        <div class="col-md-3">
          <div class="glass-card overflow-hidden text-center p-3">
            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=400&q=80" alt="CEO" class="rounded-3 w-100 object-fit-cover mb-3" style="height: 220px;">
            <h6 class="fw-bold text-met-navy m-0">Eng. Faisal Al-Sabah</h6>
            <span class="small text-muted">Founder & CEO</span>
          </div>
        </div>
        <div class="col-md-3">
          <div class="glass-card overflow-hidden text-center p-3">
            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&q=80" alt="CTO" class="rounded-3 w-100 object-fit-cover mb-3" style="height: 220px;">
            <h6 class="fw-bold text-met-navy m-0">Eng. Rania Al-Khatib</h6>
            <span class="small text-muted">Chief Engineering Officer</span>
          </div>
        </div>
        <div class="col-md-3">
          <div class="glass-card overflow-hidden text-center p-3">
            <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=400&q=80" alt="Director" class="rounded-3 w-100 object-fit-cover mb-3" style="height: 220px;">
            <h6 class="fw-bold text-met-navy m-0">Eng. Mahmoud Rashad</h6>
            <span class="small text-muted">VP Project Operations</span>
          </div>
        </div>
        <div class="col-md-3">
          <div class="glass-card overflow-hidden text-center p-3">
            <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=400&q=80" alt="BIM Lead" class="rounded-3 w-100 object-fit-cover mb-3" style="height: 220px;">
            <h6 class="fw-bold text-met-navy m-0">Laila Mansour</h6>
            <span class="small text-muted">Head of BIM & Architecture</span>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection