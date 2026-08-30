@extends('components.layouts') {{-- لو عندك layout رئيسي، وإلا احذف السطر ده وحط <html> عادي --}}

@section('content') 
  <!-- BLOG VIEW SECTION -->
  <section id="view-blog" class="view-section active animated-fade py-5">
    <div class="container py-4">
      <div class="text-center max-w-700 mx-auto mb-5">
        <span class="badge badge-gold mb-2">Blog & News</span>
        <h1 class="display-5 fw-bold text-met-navy mb-3">Engineering Insights & Construction Tech</h1>
        <p class="lead text-muted">Stay updated with structural innovations, green building trends, and company milestones.</p>
      </div>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="glass-card overflow-hidden h-100">
            <img src="https://dubaipaths.com/images/large/al-mansoor-tiger-tower-aerial-view.webp" alt="Article 1" class="w-100 object-fit-cover" style="height: 200px;">
            <div class="p-4">
              <span class="badge bg-met-navy text-gold mb-2">Engineering</span>
              <h5 class="fw-bold text-met-navy mb-2">Post-Tension Concrete Slabs vs Conventional Concrete</h5>
              <p class="small text-muted mb-3">Discover how post-tensioning reduces slab thickness by 25% while expanding column-free spans.</p>
              <div class="small text-secondary border-top pt-2">Aug 01, 2026 • 5 min read</div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="glass-card overflow-hidden h-100">
            <img src="https://images.unsplash.com/photo-1590496793929-36417d3117de?auto=format&fit=crop&w=600&q=80" alt="Article 2" class="w-100 object-fit-cover" style="height: 200px;">
            <div class="p-4">
              <span class="badge bg-met-navy text-gold mb-2">BIM & Tech</span>
              <h5 class="fw-bold text-met-navy mb-2">Level 3 BIM Integration in Megaprojects</h5>
              <p class="small text-muted mb-3">How cloud-synced Building Information Modeling eliminates site clashes before concrete is poured.</p>
              <div class="small text-secondary border-top pt-2">Jul 24, 2026 • 7 min read</div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="glass-card overflow-hidden h-100">
            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600&q=80" alt="Article 3" class="w-100 object-fit-cover" style="height: 200px;">
            <div class="p-4">
              <span class="badge bg-met-navy text-gold mb-2">Sustainability</span>
              <h5 class="fw-bold text-met-navy mb-2">Zero-Carbon Thermal Insulation Standards</h5>
              <p class="small text-muted mb-3">Achieving LEED Gold certification for luxury residential estates in hyper-arid climates.</p>
              <div class="small text-secondary border-top pt-2">Jul 10, 2026 • 4 min read</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>   
@endsection