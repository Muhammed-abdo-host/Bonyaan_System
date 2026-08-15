<x-layouts>
    <!-- CLIENT PORTAL VIEW SECTION -->
  <section id="view-client" class="view-section active animated-fade py-5">
    <div class="container py-4">
      <div class="glass-card p-4 mb-4 bg-met-navy text-white">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
          <div>
            <span class="badge badge-gold mb-2">Client Portal</span>
            <h2 class="fw-bold text-white m-0">Welcome back, Eng. Tariq Al-Mansoor</h2>
            <div class="small text-white-50 mt-1">Al-Mansoor Luxury Towers - Project #PRJ-8820</div>
          </div>
          <button class="btn btn-met-gold" onclick="showToast('Site manager engineer notified for callback.', 'info')">
            <i class="bi bi-chat-dots-fill"></i> Contact Supervisor
          </button>
        </div>
      </div>

      <!-- Project Milestone Progress Bar -->
      <div class="glass-card p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <h5 class="fw-bold text-met-navy m-0">Overall Site Progress</h5>
          <span class="badge bg-success fs-6">68% Handed Phase</span>
        </div>
        <div class="progress mb-3" style="height: 12px;">
          <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width: 68%;"></div>
        </div>
        <div class="row text-center g-2 small text-muted">
          <div class="col-3 text-success fw-bold">✓ Excavation (100%)</div>
          <div class="col-3 text-success fw-bold">✓ Skeleton Structure (100%)</div>
          <div class="col-3 text-primary fw-bold">▶ MEP & Ductwork (65%)</div>
          <div class="col-3 text-secondary">⏳ Finishes & Handover (10%)</div>
        </div>
      </div>

      <div class="row g-4">
        <!-- Site Inspection Photo Stream -->
        <div class="col-lg-7">
          <h4 class="fw-bold text-met-navy mb-3">Live Site Inspection Stream</h4>
          <div class="row g-3" id="client-photo-stream">
            <!-- Dynamically synced via JS -->
          </div>
        </div>

        <!-- Payment Schedule & Invoices Table -->
        <div class="col-lg-5">
          <h4 class="fw-bold text-met-navy mb-3">Financial Payment Schedule</h4>
          <div class="glass-card p-3">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr class="small text-muted">
                  <th>Milestone</th>
                  <th>Amount</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="small">
                <tr>
                  <td>1. Foundation Pouring</td>
                  <td class="fw-bold">$2.5M</td>
                  <td><span class="badge bg-success">Paid</span></td>
                  <td><button class="btn btn-sm btn-link p-0 text-dark" onclick="showToast('Downloading Inv-01.pdf', 'info')"><i class="bi bi-download"></i></button></td>
                </tr>
                <tr>
                  <td>2. Skeleton Complete</td>
                  <td class="fw-bold">$4.0M</td>
                  <td><span class="badge bg-success">Paid</span></td>
                  <td><button class="btn btn-sm btn-link p-0 text-dark" onclick="showToast('Downloading Inv-02.pdf', 'info')"><i class="bi bi-download"></i></button></td>
                </tr>
                <tr>
                  <td>3. MEP & Glazing</td>
                  <td class="fw-bold">$3.5M</td>
                  <td><span class="badge bg-warning text-dark">Due Now</span></td>
                  <td><button class="btn btn-sm btn-met-gold py-0 px-2" onclick="showToast('Payment gateway opened.', 'success')">Pay</button></td>
                </tr>
                <tr>
                  <td>4. Final Handover</td>
                  <td class="fw-bold">$4.5M</td>
                  <td><span class="badge bg-secondary">Pending</span></td>
                  <td><i class="bi bi-lock text-muted"></i></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>  
</x-layouts>