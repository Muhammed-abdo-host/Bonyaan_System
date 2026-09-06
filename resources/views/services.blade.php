@extends('components.layouts') {{-- لو عندك layout رئيسي، وإلا احذف السطر ده وحط <html> عادي --}}

@section('content')      <!-- SERVICES VIEW SECTION -->
  <section id="view-services" class="view-section active animated-fade py-5">
    <div class="container py-4">
      <div class="text-center max-w-700 mx-auto mb-5">
        <span class="badge badge-gold mb-2">Services</span>
        <h1 class="display-5 fw-bold text-met-navy mb-3">Comprehensive Construction Solutions</h1>
        <p class="lead text-muted">From conceptual blueprint design to turnkey handover, we offer full-spectrum engineering services.</p>
      </div>

      <div class="row g-4">
        <div class="col-lg-6">
          <div class="glass-card p-4 d-flex gap-4">
            <div class="service-icon-box flex-shrink-0"><i class="bi bi-building fs-2"></i></div>
            <div>
              <h4 class="fw-bold text-met-navy">General Contracting & Skeleton</h4>
              <p class="text-muted">Heavy civil construction, concrete structures, steel framing, and commercial complexes.</p>
              <ul class="small text-secondary ps-3">
                <li>Heavy reinforced concrete framing</li>
                <li>Post-tension slab engineering</li>
                <li>Steel structure fabrication</li>
              </ul>
              <a class="btn btn-sm btn-met-gold mt-2 text-decoration-none d-inline-block" href="estimator.html">Calculate Cost</a>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="glass-card p-4 d-flex gap-4">
            <div class="service-icon-box flex-shrink-0"><i class="bi bi-paint-bucket fs-2"></i></div>
            <div>
              <h4 class="fw-bold text-met-navy">Turnkey Interior & Exterior Finishes</h4>
              <p class="text-muted">Luxury marble work, high-end cladding, smart lighting, and bespoke architectural finishing.</p>
              <ul class="small text-secondary ps-3">
                <li>Italian marble & porcelain installation</li>
                <li>Smart automation & LED architectural grids</li>
                <li>Curtain glass facade cladding</li>
              </ul>
              <a class="btn btn-sm btn-met-gold mt-2 text-decoration-none d-inline-block" href="quote.html">Request Quote</a>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="glass-card p-4 d-flex gap-4">
            <div class="service-icon-box flex-shrink-0"><i class="bi bi-gear-wide-connected fs-2"></i></div>
            <div>
              <h4 class="fw-bold text-met-navy">Engineering Supervision & MEP</h4>
              <p class="text-muted">Strict quality assurance, HVAC, electrical grids, safety compliance, and site inspection.</p>
              <ul class="small text-secondary ps-3">
                <li>Central HVAC ductwork & chilled water lines</li>
                <li>High voltage distribution panels</li>
                <li>NFPA fire suppression networks</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="glass-card p-4 d-flex gap-4">
            <div class="service-icon-box flex-shrink-0"><i class="bi bi-compass fs-2"></i></div>
            <div>
              <h4 class="fw-bold text-met-navy">Architectural & Interior Design</h4>
              <p class="text-muted">BIM 3D modeling, structural engineering calculations, and aesthetic interior design.</p>
              <ul class="small text-secondary ps-3">
                <li>Autodesk Revit BIM Level 2 compliance</li>
                <li>Structural load analysis & seismic calculations</li>
                <li>3D VR architectural walkthroughs</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection