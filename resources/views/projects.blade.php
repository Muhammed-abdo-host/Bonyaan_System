<x-layouts>
     <!-- PROJECTS VIEW SECTION -->
  <section id="view-projects" class="view-section active animated-fade py-5">
    <div class="container py-4">
      <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-3">
        <div>
          <span class="badge badge-gold mb-2">Projects</span>
          <h1 class="display-5 fw-bold text-met-navy m-0">Featured Masterpieces</h1>
        </div>

        <div class="d-flex align-items-center gap-2">
          <input type="text" id="project-search" class="form-control rounded-pill px-3" placeholder="Search project or city..." onkeyup="renderProjects(window.currentProjectFilter || 'all', this.value)" style="min-width: 250px;">
        </div>
      </div>

      <!-- Filter Buttons -->
      <div class="d-flex flex-wrap gap-2 mb-4">
        <button class="btn btn-sm btn-met-navy text-white px-3 filter-btn active" onclick="filterProjectsCategory('all', this)">All Works</button>
        <button class="btn btn-sm btn-outline-dark px-3 filter-btn" onclick="filterProjectsCategory('residential', this)">Residential</button>
        <button class="btn btn-sm btn-outline-dark px-3 filter-btn" onclick="filterProjectsCategory('commercial', this)">Commercial</button>
        <button class="btn btn-sm btn-outline-dark px-3 filter-btn" onclick="filterProjectsCategory('infrastructure', this)">Infrastructure</button>
      </div>

      <div class="row g-4" id="projects-grid">
        <!-- Dynamically rendered via JS -->
      </div>
    </div>
  </section>
</x-layouts>