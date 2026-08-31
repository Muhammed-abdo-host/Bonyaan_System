@extends('components.layouts')

@section('content')
<section id="view-contact" class="view-section active animated-fade py-5">
    <div class="container py-4">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="badge badge-gold mb-2">Contact Us</span>
            <h1 class="display-5 fw-bold text-met-navy mb-3">
                Get in Touch with Our Executive Office
            </h1>
            <p class="lead text-muted">
                Our engineering team is ready to discuss your structural blueprint or schedule a site inspection.
            </p>
        </div>

        <div class="row g-5">
            <div class="col-lg-5">
                <div class="glass-card p-4 mb-4">
                    <h5 class="fw-bold text-met-navy mb-3">
                        <i class="bi bi-geo-alt-fill text-gold me-2"></i>
                        Headquarters - Riyadh
                    </h5>
                    <p class="small text-muted mb-2">
                        King Fahd Financial Road, Tower 4, 12th Floor, Riyadh, Saudi Arabia
                    </p>
                    <div class="small fw-semibold">
                        <i class="bi bi-telephone text-gold me-2"></i>
                        +6048 2722 4400
                    </div>
                </div>

                <div class="glass-card p-4 mb-4">
                    <h5 class="fw-bold text-met-navy mb-3">
                        <i class="bi bi-geo-alt-fill text-gold me-2"></i>
                        Dubai Regional Hub
                    </h5>
                    <p class="small text-muted mb-2">
                        Dubai Marina Plaza, Suite 1804, Dubai, United Arab Emirates
                    </p>
                    <div class="small fw-semibold">
                        <i class="bi bi-telephone text-gold me-2"></i>
                        +971 4 300 8000
                    </div>
                </div>

                <div class="glass-card p-4">
                    <h5 class="fw-bold text-met-navy mb-3">
                        <i class="bi bi-clock-fill text-gold me-2"></i>
                        Working Hours
                    </h5>
                    <p class="small text-muted m-0">
                        Sunday - Thursday: 8:00 AM - 6:00 PM<br>
                        Saturday: 9:00 AM - 2:00 PM
                    </p>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="glass-card p-4 p-md-5">
                    <h4 class="fw-bold text-met-navy mb-4">Send a Direct Message</h4>

                    <form id="contact-form" onsubmit="submitContactForm(event)">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold" for="contact-name">Your Name</label>
                                <input
                                    type="text"
                                    id="contact-name"
                                    class="form-control"
                                    required
                                    placeholder="Full Name"
                                >
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold" for="contact-email">Your Email</label>
                                <input
                                    type="email"
                                    id="contact-email"
                                    class="form-control"
                                    required
                                    placeholder="email@domain.com"
                                >
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold" for="contact-subject">Subject</label>
                                <input
                                    type="text"
                                    id="contact-subject"
                                    class="form-control"
                                    required
                                    placeholder="Inquiry about general contracting..."
                                >
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold" for="contact-message">Message</label>
                                <textarea
                                    id="contact-message"
                                    class="form-control"
                                    rows="5"
                                    required
                                    placeholder="Describe your project inquiry or engineering requirement..."
                                ></textarea>
                            </div>

                            <div class="col-12 d-flex justify-content-center">
                                <div class="form-check p-3 bg-light rounded-3 border d-inline-flex align-items-center gap-2">
                                    <input
                                        class="form-check-input m-0"
                                        type="checkbox"
                                        id="contact-recaptcha"
                                    >
                                    <label class="form-check-label small m-0" for="contact-recaptcha">
                                        I verify that I am sending a legitimate inquiry.
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <button
                                    type="submit"
                                    class="btn btn-met-navy text-white btn-lg px-5 fw-bold"
                                >
                                    Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection