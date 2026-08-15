<x-layouts>
    
  <!-- REQUEST QUOTE VIEW SECTION -->
  <section id="view-quote" class="view-section active animated-fade py-5">
    <div class="container py-4">
      <div class="text-center max-w-700 mx-auto mb-5">
        <span class="badge badge-gold mb-2">Request Quote</span>
        <h1 class="display-5 fw-bold text-met-navy mb-3">Request an Official Project Proposal</h1>
        <p class="lead text-muted">Provide your project specifications and engineering drawings to receive a detailed cost analysis.</p>
      </div>

      <div class="row justify-content-center">
        <div class="col-lg-9">
          <div class="glass-card p-4 p-md-5">
            
            <div id="quote-preset-alert" class="alert alert-info border-info d-flex align-items-center gap-2 mb-4" style="display: none;">
              <i class="bi bi-info-circle-fill fs-5 text-info"></i>
              <div>Your pre-calculated estimate from the Cost Estimator has been automatically transferred into the proposal parameters below!</div>
            </div>

            <form onsubmit="submitQuoteForm(event)">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Full Name</label>
                  <input type="text" id="quote-name" class="form-control" required placeholder="Eng. Tariq Al-Mansoor">
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-bold">Email Address</label>
                  <input type="email" id="quote-email" class="form-control" required placeholder="tariq@mansoor.com">
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-bold">Phone Number</label>
                  <input type="tel" id="quote-phone" class="form-control" required placeholder="+966 50 123 4567">
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-bold">Project Location / City</label>
                  <input type="text" id="quote-location" class="form-control" required placeholder="Riyadh, Financial District">
                </div>

                <div class="col-md-4">
                  <label class="form-label fw-bold">Project Category</label>
                  <select id="quote-type" class="form-select">
                    <option value="Residential Luxury Complex">Residential Luxury Complex</option>
                    <option value="Commercial Office Tower">Commercial Office Tower</option>
                    <option value="Private Villa Estate">Private Villa Estate</option>
                    <option value="Industrial Warehouse">Industrial Warehouse</option>
                  </select>
                </div>

                <div class="col-md-4">
                  <label class="form-label fw-bold">Built-Up Area</label>
                  <input type="text" id="quote-area" class="form-control" placeholder="e.g. 1,200 sq.m">
                </div>

                <div class="col-md-4">
                  <label class="form-label fw-bold">Target Budget</label>
                  <input type="text" id="quote-budget" class="form-control" placeholder="e.g. $1.5M - $2.0M">
                </div>

                <div class="col-12">
                  <label class="form-label fw-bold">Upload Blueprint / CAD Drawings (PDF, DWG, ZIP)</label>
                  <input type="file" class="form-control">
                  <div class="form-text">Max file size: 50MB. Allowed extensions: .pdf, .dwg, .zip</div>
                </div>

                <div class="col-12">
                  <label class="form-label fw-bold">Project Details & Specific Requirements</label>
                  <textarea id="quote-notes" class="form-control" rows="4" placeholder="Mention any specific finishing preferences, site access constraints, or timelines..."></textarea>
                </div>

                <div class="col-12 my-3">
                  <div class="form-check p-3 bg-light rounded-3 border">
                    <input class="form-check-input" type="checkbox" id="quote-recaptcha">
                    <label class="form-check-label small" for="quote-recaptcha">
                      I am not a robot (Protected by reCAPTCHA v3)
                    </label>
                  </div>
                </div>

                <div class="col-12">
                  <button type="submit" class="btn btn-met-gold btn-lg w-100 fw-bold">
                    Submit Proposal Request
                  </button>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</x-layouts>