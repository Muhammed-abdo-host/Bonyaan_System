<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🏗️</text></svg>" />
    <title>Bonyaan | Premier Construction & Contracting Web System</title>
    <meta name="description" content="Leading Construction, General Contracting, Finishes, and Architectural Engineering Firm. Calculate instant cost estimates and track real-time project progress." />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS & Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Custom Styling System -->
    <link rel="stylesheet" href="./styles.css">
</head>

<body>

    <!-- Top Header Contact Bar -->
    <div class="top-header py-2 d-none d-md-block">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-4">
                <span><i class="bi bi-telephone-fill text-gold me-1"></i> Call Us: +6048 2722 4400</span>
                <span><i class="bi bi-envelope-fill text-gold me-1"></i> Bonyaan@gmail.com</span>
            </div>

            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-met-navy-light text-gold border border-warning" id="current-role-badge">General Manager</span>
            </div>
        </div>
    </div>

    <!-- Primary Navigation Bar -->
    <nav class="navbar navbar-expand-lg sticky-top met-navbar">
        <div class="container">
            <a class="met-brand d-flex align-items-center gap-2" href="index.html">

            </a>

            <button class="navbar-toggler text-white border-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1">
                    <li class="nav-item"><a class="nav-link active" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/about">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="/services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="/projects">Projects</a></li>
                    <li class="nav-item"><a class="nav-link" href="/estimator">Cost Estimator</a></li>
                    <li class="nav-item"><a class="nav-link" href="/quote">Request Quote</a></li>
                    <li class="nav-item"><a class="nav-link" href="/blog">Blog & News</a></li>
                    <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>
                </ul
                <div class="d-flex align-items-center gap-2">
                    <a class="btn btn-sm btn-outline-warning text-white me-2" href="/client">
                        <i class="bi bi-person-workspace"></i> Client Portal
                    </a>
                    <a class="btn btn-met-gold btn-sm d-flex align-items-center gap-1" href="/adminbanal">
                        <i class="bi bi-speedometer2"></i> Admin Panel
                    </a>
                </div>
            </div>
        </div>
    </nav>


{{$slot}}
    <!-- FOOTER -->
    <footer class="bg-met-navy text-white pt-5 pb-4 border-top border-secondary">
        <div class="container">
            <div class="row g-4 mb-5">
                <div class="col-lg-4">
                    <a class="met-brand d-inline-flex align-items-center gap-2 mb-3" href="index.html">
                        <span>Bonyaan<span>
                    </a>
                    <p class="small text-white-50 mb-4">
                        Bonyaan is an industry-leading construction firm committed to structural integrity, futuristic design, and transparent client partnerships.
                    </p>
                    <div class="d-flex gap-3 text-gold fs-5">
                        <i class="bi bi-linkedin"></i>
                        <i class="bi bi-twitter-x"></i>
                        <i class="bi bi-facebook"></i>
                        <i class="bi bi-instagram"></i>
                    </div>
                </div>

                <div class="col-6 col-lg-2">
                    <h6 class="fw-bold text-gold mb-3">Quick Links</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2 text-white-50">
                        <li><a class="text-decoration-none text-white-50" href="index.html">Home</a></li>
                        <li><a class="text-decoration-none text-white-50" href="about.html">About Us</a></li>
                        <li><a class="text-decoration-none text-white-50" href="services.html">Services</a></li>
                        <li><a class="text-decoration-none text-white-50" href="projects.html">Projects</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-2">
                    <h6 class="fw-bold text-gold mb-3">Tools & Systems</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2 text-white-50">
                        <li><a class="text-decoration-none text-white-50" href="estimator.html">Cost Estimator</a></li>
                        <li><a class="text-decoration-none text-white-50" href="quote.html">Request Quote</a></li>
                        <li><a class="text-decoration-none text-white-50" href="client.html">Client Portal</a></li>
                        <li><a class="text-decoration-none text-white-50" href="admin.html">Admin Dashboard</a></li>
                    </ul>
                </div>

                <div class="col-lg-4">
                    <h6 class="fw-bold text-gold mb-3">Contact Information</h6>
                    <div class="small text-white-50 d-flex flex-column gap-2">
                        <div><i class="bi bi-geo-alt-fill text-gold me-2"></i> King Fahd Financial Road, Tower 4, Riyadh, Saudi Arabia</div>
                        <div><i class="bi bi-telephone-fill text-gold me-2"></i> +6048 2722 4400</div>
                        <div><i class="bi bi-envelope-fill text-gold me-2"></i> Bonyaan@gmail.com</div>
                    </div>
                </div>
            </div>

            <div class="border-top border-secondary pt-4 text-center small text-white-50">
                Bonyaan Contracting System. All rights reservedv &copy; 2026.
            </div>
        </div>
    </footer>

    <!-- Project Detail Modal -->
    <div class="modal fade" id="projectDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content glass-card p-0 border-0 overflow-hidden">
                <div class="modal-header bg-met-navy text-white">
                    <h5 class="modal-title fw-bold" id="modal-proj-title">Project Title</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <img id="modal-proj-img" src="" alt="" class="w-100 rounded-3 object-fit-cover mb-4" style="height: 300px;">

                    <div class="row g-3 mb-4 text-center">
                        <div class="col-4">
                            <div class="p-2 border rounded bg-light">
                                <div class="small text-muted">Client</div>
                                <div class="fw-bold text-met-navy" id="modal-proj-client">-</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 border rounded bg-light">
                                <div class="small text-muted">Location</div>
                                <div class="fw-bold text-met-navy" id="modal-proj-location">-</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 border rounded bg-light">
                                <div class="small text-muted">Built-Up Area</div>
                                <div class="fw-bold text-gold" id="modal-proj-area">-</div>
                            </div>
                        </div>
                    </div>

                    <p class="text-secondary" id="modal-proj-desc"></p>
                </div>
                <div class="modal-footer bg-light">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a class="btn btn-met-gold" href="quote.html">Request Similar Project</a>
                </div>
            </div>
        </div>
    </div>

    <!-- TOAST ALERTS WRAPPER CONTAINER -->
    <div id="toast-container" class="met-toast-wrapper"></div>

    <!-- JS DEPENDENCIES -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./app.js"></script>
</body>

</html>