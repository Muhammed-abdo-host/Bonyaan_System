@extends('components.layouts') {{-- لو عندك layout رئيسي، وإلا احذف السطر ده وحط <html> عادي --}}

@section('content')     <!-- HOME VIEW SECTION -->
  <section id="view-home" class="view-section active animated-fade">
    <!-- Hero Section -->
    <div class="hero-wrapper py-5">
      <div class="container py-5">
        <div class="row align-items-center g-5">
          <div class="col-lg-7">
            <div class="badge badge-gold mb-3 d-inline-flex align-items-center gap-2 px-3 py-2 fs-6">
              <i class="bi bi-patch-check-fill text-gold fs-5"></i> ISO 9001:2015 Premier Certified Contracting
            </div>
            <h1 class="hero-title mb-4">
              Building Tomorrow's Landmarks Today
            </h1>
            <p class="hero-subtitle mb-4">
              Over 24 years of engineering innovation, turnkey construction, and architectural mastery delivering iconic residential & commercial projects.
            </p>
            <div class="d-flex flex-wrap align-items-center gap-3">
              <a class="btn btn-met-gold btn-lg d-flex align-items-center gap-2 shadow" href="estimator.html">
                <i class="bi bi-calculator-fill"></i>
                <span>Calculate Construction Cost</span>
              </a>
              <a class="btn btn-met-outline btn-lg d-flex align-items-center gap-2" href="projects.html">
                <span>Explore Projects</span>
                <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>

          <!-- Hero Quick Estimator Overlay Card -->
          <div class="col-lg-5">
            <div class="glass-card-dark p-4 rounded-4 shadow-lg border border-secondary">
              <div class="d-flex align-items-center gap-2 mb-3 text-gold">
                <i class="bi bi-calculator fs-4"></i>
                <h5 class="m-0 text-white fw-bold">Instant Cost Teaser</h5>
              </div>
              <p class="small text-white-50 mb-4">Select building parameters to benchmark preliminary estimation.</p>
              
              <div class="mb-3">
                <label class="form-label small text-light">Building Category</label>
                <select class="form-select bg-dark text-white border-secondary" id="heroBuildType">
                  <option value="villa">Luxury Residential Villa</option>
                  <option value="office">Commercial Office Tower</option>
                  <option value="mall">Retail Center & Mall</option>
                  <option value="warehouse">Industrial Logistics Hub</option>
                </select>
              </div>

              <div class="mb-4">
                <label class="form-label small text-light d-flex justify-content-between">
                  <span>Built-Up Area</span>
                  <span class="text-gold fw-bold" id="heroAreaLabel">450 m²</span>
                </label>
                <input type="range" class="form-range" min="100" max="5000" step="50" value="450" id="heroAreaSlider" oninput="document.getElementById('heroAreaLabel').innerText = this.value + ' m²'" />
              </div>

              <a class="btn btn-met-gold w-100 py-2.5 fw-bold text-center text-decoration-none d-block" href="estimator.html">
                Calculate Full Budget Breakdown
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Stats Counter Bar -->
    <div class="bg-met-navy py-5 shadow position-relative z-2">
      <div class="container">
        <div class="row g-4">
          <div class="col-6 col-md-3">
            <div class="stat-box">
              <div class="stat-number">350+</div>
              <div class="small text-light fw-semibold">Completed Projects</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="stat-box">
              <div class="stat-number">280+</div>
              <div class="small text-light fw-semibold">Satisfied Clients</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="stat-box">
              <div class="stat-number">24+</div>
              <div class="small text-light fw-semibold">Years of Experience</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="stat-box">
              <div class="stat-number">85+</div>
              <div class="small text-light fw-semibold">Expert Engineers</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Corporate Summary -->
    <div class="py-5 bg-light">
      <div class="container py-4">
        <div class="row align-items-center g-5">
          <div class="col-lg-6">
            <div class="position-relative">
              <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=800&q=80" alt="Construction Site" class="img-fluid rounded-4 shadow-lg" />
              <div class="position-absolute bottom-0 start-0 bg-met-navy text-white p-4 rounded-4 shadow-lg d-none d-md-block" style="transform: translate(20px, 20px); max-width: 280px;">
                <div class="d-flex align-items-center gap-2 text-gold mb-2">
                  <i class="bi bi-award-fill fs-4"></i>
                  <span class="fw-bold fs-5">24+ Years</span>
                </div>
                <div class="small text-white-50">Structural Rigor and Architectural Distinction across EMEA region.</div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <span class="badge badge-gold mb-2">About Us</span>
            <h2 class="display-6 fw-bold text-met-navy mb-4">Constructing Legacy with Precision & Integrity</h2>
            <p class="lead text-muted mb-4">Founded in 2002, Bonyaan has evolved into a premier full-service contracting powerhouse. We combine modern engineering technology, ISO-certified quality control, and sustainable practices.</p>
            
            <div class="row g-3 mb-4">
              <div class="col-6">
                <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-gold"></i> <span class="fw-semibold">ISO 9001:2015 Certified</span></div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-gold"></i> <span class="fw-semibold">BIM 3D Modeling</span></div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-gold"></i> <span class="fw-semibold">Turnkey Handover</span></div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-gold"></i> <span class="fw-semibold">24/7 Client Portal</span></div>
              </div>
            </div>

            <a class="btn btn-met-navy btn-lg text-white d-inline-flex align-items-center gap-2" href="about.html">
              <span>Learn More About Us</span>
              <i class="bi bi-chevron-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Featured Services Section -->
    <div class="py-5 bg-white">
      <div class="container py-4">
        <div class="text-center max-w-700 mx-auto mb-5">
          <span class="badge badge-gold mb-2">Services</span>
          <h2 class="display-6 fw-bold text-met-navy mb-3">Comprehensive Construction Solutions</h2>
          <p class="text-muted">From conceptual blueprint design to turnkey handover, we offer full-spectrum engineering services.</p>
        </div>

        <div class="row g-4">
          <div class="col-lg-4 col-md-6">
            <div class="service-card">
              <div class="service-icon-box"><i class="bi bi-building"></i></div>
              <h5 class="fw-bold mb-3">General Contracting & Skeleton</h5>
              <p class="text-muted small mb-4">Heavy civil construction, concrete structures, steel framing, and commercial complexes.</p>
              <a class="btn btn-link text-decoration-none text-gold p-0 fw-bold d-flex align-items-center gap-1" href="services.html">
                Explore Details <i class="bi bi-chevron-right"></i>
              </a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <div class="service-card">
              <div class="service-icon-box"><i class="bi bi-paint-bucket"></i></div>
              <h5 class="fw-bold mb-3">Turnkey Interior & Exterior Finishes</h5>
              <p class="text-muted small mb-4">Luxury marble work, high-end cladding, smart lighting, and bespoke architectural finishing.</p>
              <a class="btn btn-link text-decoration-none text-gold p-0 fw-bold d-flex align-items-center gap-1" href="services.html">
                Explore Details <i class="bi bi-chevron-right"></i>
              </a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <div class="service-card">
              <div class="service-icon-box"><i class="bi bi-gear-wide-connected"></i></div>
              <h5 class="fw-bold mb-3">Engineering Supervision & MEP</h5>
              <p class="text-muted small mb-4">Strict quality assurance, HVAC, electrical grids, safety compliance, and site inspection.</p>
              <a class="btn btn-link text-decoration-none text-gold p-0 fw-bold d-flex align-items-center gap-1" href="services.html">
                Explore Details <i class="bi bi-chevron-right"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Featured Projects Gallery Preview -->
    <div class="py-5 bg-light">
      <div class="container py-4">
        <div class="d-flex flex-wrap align-items-end justify-content-between mb-4 gap-3">
          <div>
            <span class="badge badge-gold mb-2">Projects</span>
            <h2 class="display-6 fw-bold text-met-navy m-0">Featured Masterpieces</h2>
          </div>
          <a class="btn btn-outline-dark fw-bold text-decoration-none" href="projects.html">
            View All Portfolio <i class="bi bi-arrow-right"></i>
          </a>
        </div>

        <div class="row g-4" id="home-featured-projects">
          <!-- Dynamic insertion by JS -->
        </div>
      </div>
    </div>

    <!-- Client Testimonials -->
    <div class="py-5 bg-white">
      <div class="container py-4">
        <div class="text-center max-w-700 mx-auto mb-5">
          <h2 class="display-6 fw-bold text-met-navy mb-3">What Our Clients Say</h2>
          <p class="text-muted">Trusted by real estate developers, government entities, and private investors.</p>
        </div>

        <div class="row g-4">
          <div class="col-md-6">
            <div class="glass-card p-4 h-100">
              <div class="text-gold mb-3"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
              <p class="fst-italic text-secondary mb-4">"Bonyaan delivered our 14-story residential tower 2 months ahead of schedule with flawless finishing quality."</p>
              <div class="d-flex align-items-center gap-3 border-top pt-3">
                <div class="bg-met-navy text-gold rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 48px; height: 48px;">TM</div>
                <div>
                  <h6 class="fw-bold m-0">Eng. Tariq Al-Mansoor</h6>
                  <span class="small text-muted">CEO, Al-Mansoor Real Estate</span>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="glass-card p-4 h-100">
              <div class="text-gold mb-3"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
              <p class="fst-italic text-secondary mb-4">"Their online client portal allowed us to inspect daily site progress photos and financial milestones seamlessly."</p>
              <div class="d-flex align-items-center gap-3 border-top pt-3">
                <div class="bg-met-navy text-gold rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 48px; height: 48px;">SJ</div>
                <div>
                  <h6 class="fw-bold m-0">Sarah Jenkins</h6>
                  <span class="small text-muted">Director, Horizon Developments</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection