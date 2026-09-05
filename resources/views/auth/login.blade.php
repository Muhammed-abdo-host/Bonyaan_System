@extends('components.layouts')

@section('content')
<section class="py-5 animated-fade" style="min-height: 80vh; display: flex; align-items: center;">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-7 col-lg-5">
                <div class="glass-card p-4 p-sm-5">
                    <div class="text-center mb-4">
                        <span class="badge badge-gold mb-2">Secure Access</span>
                        <h2 class="fw-bold text-met-navy mb-1">Welcome Back</h2>
                        <p class="small text-muted mb-0">Sign in to access your Bonyaan Portal or Admin Dashboard.</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-3 small py-2 px-3 mb-4 d-flex align-items-center gap-2">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <div>{{ $errors->first() }}</div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-met-navy">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control border-start-0 ps-0" placeholder="name@bonyaan.test" value="{{ old('email') }}" required autofocus>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-met-navy">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label small text-muted cursor-pointer" for="remember">Remember me</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-met-gold w-100 py-2.5 fw-bold d-flex align-items-center justify-content-center gap-2 shadow-sm">
                            <i class="bi bi-box-arrow-in-right"></i> Sign In
                        </button>
                    </form>

                    
                </div>
            </div>
        </div>
    </div>
</section>
@endsection