@extends('components.layouts')

@section('content')
<div class="hero-wrapper d-flex align-items-center justify-content-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="text-center mb-4">
                    <span class="badge badge-gold mb-3">Secure Access</span>
                    <h2 class="fw-bold text-white">Welcome Back</h2>
                    <p class="text-white-50 small">Sign in to manage your Bonyaan account</p>
                </div>

                <div class="glass-card p-4 p-md-5">
                    @if ($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif

                    <form method="POST" action="{{ route('login.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <!-- تم إضافة text-dark أو text-secondary هنا -->
                            <label class="form-label fw-semibold text-dark">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                        </div>
                        <div class="mb-3">
                            <!-- تم إضافة text-dark هنا -->
                            <label class="form-label fw-semibold text-dark">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-check mb-4">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <!-- تم إضافة text-dark هنا كمان -->
                            <label class="form-check-label small text-dark" for="remember">Remember me</label>
                        </div>
                        <button type="submit" class="btn btn-met-gold w-100">Sign In</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection