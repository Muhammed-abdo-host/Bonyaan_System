@extends('components.layouts')

@section('content')
<section id="view-careers" class="view-section active animated-fade py-5">
    <div class="container py-4">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="badge badge-gold mb-2">Careers</span>
            <h1 class="display-5 fw-bold text-met-navy mb-3">Join Our Engineering Team</h1>
            <p class="lead text-muted">
                We're always looking for talented engineers, architects, and construction professionals
                to be part of Bonyaan's growing legacy.
            </p>
        </div>

        {{-- Open Positions --}}
        <div class="row g-4 mb-5">
            @foreach ([
                ['title' => 'Structural Engineer', 'dept' => 'Engineering', 'type' => 'Full-time', 'location' => 'Riyadh'],
                ['title' => 'Site Supervisor', 'dept' => 'Operations', 'type' => 'Full-time', 'location' => 'Dubai'],
                ['title' => 'Interior Designer', 'dept' => 'Design', 'type' => 'Full-time', 'location' => 'Riyadh'],
                ['title' => 'MEP Engineer', 'dept' => 'Engineering', 'type' => 'Full-time', 'location' => 'Riyadh'],
            ] as $job)
            <div class="col-md-6">
                <div class="glass-card p-4 h-100 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold text-met-navy mb-1">{{ $job['title'] }}</h5>
                        <div class="small text-muted">
                            <i class="bi bi-briefcase me-1"></i> {{ $job['dept'] }}
                            <span class="mx-2">•</span>
                            <i class="bi bi-geo-alt me-1"></i> {{ $job['location'] }}
                        </div>
                    </div>
                    <span class="badge bg-success">{{ $job['type'] }}</span>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Application Form --}}
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="glass-card p-4 p-md-5">
                    <h4 class="fw-bold text-met-navy mb-4">
                        <i class="bi bi-send-fill text-gold me-2"></i>
                        Apply Now
                    </h4>

                    <div id="career-alert" class="d-none"></div>

                    <form id="career-form" onsubmit="submitCareerForm(event)" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold" for="career-name">Full Name</label>
                                <input type="text" id="career-name" class="form-control" required placeholder="Your full name">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold" for="career-email">Email Address</label>
                                <input type="email" id="career-email" class="form-control" required placeholder="email@domain.com">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold" for="career-phone">Phone Number</label>
                                <input type="text" id="career-phone" class="form-control" required placeholder="+966 5x xxx xxxx">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold" for="career-position">Position Applying For</label>
                                <select id="career-position" class="form-select" required>
                                    <option value="">Select a position...</option>
                                    <option value="Structural Engineer">Structural Engineer</option>
                                    <option value="Site Supervisor">Site Supervisor</option>
                                    <option value="Interior Designer">Interior Designer</option>
                                    <option value="MEP Engineer">MEP Engineer</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold" for="career-cv">Upload CV / Resume</label>
                                <input type="file" id="career-cv" class="form-control" accept=".pdf,.doc,.docx" required>
                                <div class="form-text">PDF or Word document — max 10 MB.</div>
                            </div>

                            <div class="col-12 text-center mt-2">
                                <button type="submit" class="btn btn-met-navy text-white btn-lg px-5 fw-bold" id="career-submit-btn">
                                    <i class="bi bi-send me-2"></i> Submit Application
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
async function submitCareerForm(e) {
    e.preventDefault();

    const btn = document.getElementById('career-submit-btn');
    const alertBox = document.getElementById('career-alert');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...';

    const formData = new FormData();
    formData.append('name',     document.getElementById('career-name').value);
    formData.append('email',    document.getElementById('career-email').value);
    formData.append('phone',    document.getElementById('career-phone').value);
    formData.append('position', document.getElementById('career-position').value);
    formData.append('cv',       document.getElementById('career-cv').files[0]);

    try {
        const res = await fetch('/careers/apply', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: formData,
        });

        const data = await res.json();

        if (res.ok) {
            alertBox.className = 'alert alert-success';
            alertBox.textContent = data.message;
            document.getElementById('career-form').reset();
        } else {
            const errors = Object.values(data.errors || {}).flat().join(' ');
            alertBox.className = 'alert alert-danger';
            alertBox.textContent = errors || data.message || 'Something went wrong.';
        }
    } catch {
        alertBox.className = 'alert alert-danger';
        alertBox.textContent = 'Network error. Please try again.';
    }

    alertBox.classList.remove('d-none');
    btn.disabled = false;
    btn.innerHTML = '<i class="bi bi-send me-2"></i> Submit Application';
}
</script>
@endsection