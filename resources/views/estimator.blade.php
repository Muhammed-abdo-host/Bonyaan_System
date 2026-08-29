 @section('content')     <!-- COST ESTIMATOR VIEW SECTION -->
  <section id="view-estimator" class="view-section active animated-fade py-5">
    <div class="container py-4">
      <div class="text-center max-w-700 mx-auto mb-5">
        <span class="badge badge-gold mb-2">Cost Estimator</span>
        <h1 class="display-5 fw-bold text-met-navy mb-3">Interactive Construction Cost Estimator</h1>
        <p class="lead text-muted">Get an instant, reliable preliminary budget calculation for your building project in seconds.</p>
      </div>

      <div class="row g-5">
        <div class="col-lg-7">
          <div class="glass-card p-4">
            <!-- Area Slider -->
            <div class="mb-4">
              <label class="form-label fw-bold d-flex justify-content-between">
                <span>Total Built-Up Area (sq. meters):</span>
                <span class="text-gold fs-5 fw-bold" id="est-area-val">450 m²</span>
              </label>
              <input type="range" class="form-range" min="100" max="10000" step="50" value="450" id="est-area" oninput="calculateCost()">
            </div>

            <!-- Floors Slider -->
            <div class="mb-4">
              <label class="form-label fw-bold d-flex justify-content-between">
                <span>Number of Floors / Levels:</span>
                <span class="text-met-navy fs-5 fw-bold" id="est-floors-val">2 Floors</span>
              </label>
              <input type="range" class="form-range" min="1" max="30" step="1" value="2" id="est-floors" oninput="calculateCost()">
            </div>

            <!-- Category Radio Group -->
            <div class="mb-4">
              <label class="form-label fw-bold">Building Category:</label>
              <div class="row g-2">
                <div class="col-6 col-md-3">
                  <input type="radio" class="btn-check" name="est-type" id="type-villa" value="villa" checked onchange="calculateCost()">
                  <label class="btn btn-outline-dark w-100 py-2 text-center" for="type-villa">Villa</label>
                </div>
                <div class="col-6 col-md-3">
                  <input type="radio" class="btn-check" name="est-type" id="type-office" value="office" onchange="calculateCost()">
                  <label class="btn btn-outline-dark w-100 py-2 text-center" for="type-office">Office</label>
                </div>
                <div class="col-6 col-md-3">
                  <input type="radio" class="btn-check" name="est-type" id="type-mall" value="mall" onchange="calculateCost()">
                  <label class="btn btn-outline-dark w-100 py-2 text-center" for="type-mall">Mall/Retail</label>
                </div>
                <div class="col-6 col-md-3">
                  <input type="radio" class="btn-check" name="est-type" id="type-warehouse" value="warehouse" onchange="calculateCost()">
                  <label class="btn btn-outline-dark w-100 py-2 text-center" for="type-warehouse">Warehouse</label>
                </div>
              </div>
            </div>

            <!-- Finishing Tier Radio Group -->
            <div class="mb-4">
              <label class="form-label fw-bold">Finishing Level:</label>
              <div class="row g-2">
                <div class="col-4">
                  <input type="radio" class="btn-check" name="est-tier" id="tier-standard" value="standard" onchange="calculateCost()">
                  <label class="btn btn-outline-secondary w-100 py-2 text-center" for="tier-standard">Standard</label>
                </div>
                <div class="col-4">
                  <input type="radio" class="btn-check" name="est-tier" id="tier-deluxe" value="deluxe" checked onchange="calculateCost()">
                  <label class="btn btn-outline-secondary w-100 py-2 text-center" for="tier-deluxe">Deluxe</label>
                </div>
                <div class="col-4">
                  <input type="radio" class="btn-check" name="est-tier" id="tier-ultra" value="ultra" onchange="calculateCost()">
                  <label class="btn btn-outline-secondary w-100 py-2 text-center" for="tier-ultra">Ultra Luxury</label>
                </div>
              </div>
            </div>

            <!-- Extra Features -->
            <div class="mb-3">
              <label class="form-label fw-bold">Extra Features & Systems:</label>
              <div class="row g-3">
                <div class="col-6">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="est-extra-pool" onchange="calculateCost()">
                    <label class="form-check-label small" for="est-extra-pool">Infinity Swimming Pool (+ $35k)</label>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="est-extra-smart" onchange="calculateCost()">
                    <label class="form-check-label small" for="est-extra-smart">Smart Home Automation (+ $25k)</label>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="est-extra-solar" onchange="calculateCost()">
                    <label class="form-check-label small" for="est-extra-solar">Solar Microgrid (+ $20k)</label>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="est-extra-landscape" onchange="calculateCost()">
                    <label class="form-check-label small" for="est-extra-landscape">Landscape & Hardscape (+ $15k)</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Output Breakdown Card -->
        <div class="col-lg-5">
          <div class="glass-card-dark p-4 rounded-4 shadow-lg h-100 d-flex flex-column justify-content-between">
            <div>
              <div class="badge badge-gold mb-3">Instant Benchmark</div>
              <div class="text-white-50 small mb-1">Estimated Total Cost</div>
              <h2 class="display-5 fw-bold text-gold mb-3" id="est-output-total">$0</h2>

              <div class="row g-2 mb-4">
                <div class="col-6">
                  <div class="p-3 rounded-3 bg-dark border border-secondary">
                    <div class="small text-white-50">Cost per sq. meter</div>
                    <div class="fw-bold text-white fs-6" id="est-output-sqm">$0 / m²</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="p-3 rounded-3 bg-dark border border-secondary">
                    <div class="small text-white-50">Estimated Timeline</div>
                    <div class="fw-bold text-white fs-6" id="est-output-months">0 Months</div>
                  </div>
                </div>
              </div>

              <!-- Cost Breakdown Items -->
              <h6 class="fw-bold text-white mb-3">Budget Allocation Breakdown</h6>
              <div class="mb-3">
                <div class="d-flex justify-content-between small text-white-50 mb-1">
                  <span>Structure & Civil Works (40%)</span>
                  <span class="fw-bold text-white" id="est-breakdown-struct">$0</span>
                </div>
                <div class="progress" style="height: 6px;"><div class="progress-bar bg-warning" style="width: 40%;"></div></div>
              </div>

              <div class="mb-3">
                <div class="d-flex justify-content-between small text-white-50 mb-1">
                  <span>Finishes & Interior (45%)</span>
                  <span class="fw-bold text-white" id="est-breakdown-finishes">$0</span>
                </div>
                <div class="progress" style="height: 6px;"><div class="progress-bar bg-info" style="width: 45%;"></div></div>
              </div>

              <div class="mb-4">
                <div class="d-flex justify-content-between small text-white-50 mb-1">
                  <span>MEP, Engineering & Permits (15%)</span>
                  <span class="fw-bold text-white" id="est-breakdown-mep">$0</span>
                </div>
                <div class="progress" style="height: 6px;"><div class="progress-bar bg-success" style="width: 15%;"></div></div>
              </div>
            </div>

            <button class="btn btn-met-gold w-100 py-3 fw-bold" onclick="applyEstimateToQuote()">
              Request Official Proposal using this Estimate
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection