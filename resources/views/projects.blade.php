@extends('components.layouts')

@section('content')
  <!-- PROJECTS VIEW SECTION -->
  <section id="view-projects" class="view-section active animated-fade py-5">
    <div class="container py-4">
      <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
          <span class="badge badge-gold mb-2">Projects</span>
          <h1 class="display-5 fw-bold text-met-navy m-0">Featured Masterpieces</h1>
        </div>

        <!-- Search Form with Clickable Button -->
        <form class="d-flex align-items-center gap-2 m-0" onsubmit="event.preventDefault(); triggerProjectSearch();" style="max-width: 380px; width: 100%;">
          <div class="input-group shadow-sm">
            <span class="input-group-text bg-white border-end-0 text-muted">
              <i class="bi bi-search"></i>
            </span>
            <input 
              type="text" 
              id="project-search" 
              class="form-control border-start-0 ps-0" 
              placeholder="Search title, city (e.g. Riyadh)..." 
              oninput="triggerProjectSearch()"
            >
            <button class="btn btn-met-navy text-white px-3 fw-bold" type="submit">
              Search
            </button>
          </div>
        </form>
      </div>

      <!-- Filter Buttons Matching Database Categories -->
      <div class="d-flex flex-wrap gap-2 mb-4">
        <button class="btn btn-sm btn-met-navy text-white px-3 project-filter-btn active" onclick="applyProjectFilter('all', this)">
          All Works
        </button>
        <button class="btn btn-sm btn-outline-dark px-3 project-filter-btn" onclick="applyProjectFilter('villa', this)">
          Luxury Villas
        </button>
        <button class="btn btn-sm btn-outline-dark px-3 project-filter-btn" onclick="applyProjectFilter('office', this)">
          Commercial Offices
        </button>
        <button class="btn btn-sm btn-outline-dark px-3 project-filter-btn" onclick="applyProjectFilter('mall', this)">
          Retail & Malls
        </button>
        <button class="btn btn-sm btn-outline-dark px-3 project-filter-btn" onclick="applyProjectFilter('warehouse', this)">
          Logistics & Warehouses
        </button>
      </div>

      <div class="row g-4" id="projects-grid">
        <!-- Dynamically rendered via JS -->
      </div>
    </div>
  </section>

   <script>
    // دالة البحث الذكي: تبحث في كل المشاريع تلقائياً عند الكتابة
    function triggerProjectSearch() {
      const searchInput = document.getElementById('project-search');
      const query = searchInput ? searchInput.value.trim() : '';

      // لو المستخدم كتب نص بحث، نرجّع الفلتر تلقائياً لـ All Works عشان يظهر المشروع فوراً
      if (query.length > 0) {
        window.currentProjectFilter = 'all';
        document.querySelectorAll('.project-filter-btn').forEach(b => {
          b.classList.remove('active', 'btn-met-navy', 'text-white');
          b.classList.add('btn-outline-dark');
        });
        const allBtn = document.querySelector('.project-filter-btn');
        if (allBtn) {
          allBtn.classList.remove('btn-outline-dark');
          allBtn.classList.add('active', 'btn-met-navy', 'text-white');
        }
      }

      const category = window.currentProjectFilter || 'all';
      renderProjects(category, query);
    }

    // دالة الفلترة: عند الضغط على تصنيف معين
    function applyProjectFilter(category, btnEl) {
      window.currentProjectFilter = category;
      document.querySelectorAll('.project-filter-btn').forEach(b => {
        b.classList.remove('active', 'btn-met-navy', 'text-white');
        b.classList.add('btn-outline-dark');
      });

      if (btnEl) {
        btnEl.classList.remove('btn-outline-dark');
        btnEl.classList.add('active', 'btn-met-navy', 'text-white');
      }

      const searchInput = document.getElementById('project-search');
      const query = searchInput ? searchInput.value.trim() : '';
      renderProjects(category, query);
    }
  </script>
@endsection