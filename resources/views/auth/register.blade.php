@extends('layouts.app')

@section('title', 'Create Account — Velyora')

@section('content')
<section class="page-header">
    <div class="container">
        <div class="page-header-content">
            <h1>Create Account</h1>
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span>/</span>
                <span>Register</span>
            </nav>
        </div>
    </div>
</section>

<main>
<section class="register-page">
    <div class="container">
        <div class="register-wrapper">
            
            <!-- Left Showcase Panel -->
            <div class="register-showcase">
                <div class="showcase-glow"></div>
                <div class="showcase-content">
                    <span class="showcase-eyebrow">JOIN VELYORA</span>
                    <h2>Elevate Your Shopping Experience.</h2>
                    <p>Unlock exclusive collections, seamless checkout, and personalized recommendations tailored to your style.</p>
                    
                    <div class="feature-glass-card">
                        <div class="glass-icon">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div class="glass-text">
                            <strong>Premium Benefits</strong>
                            <span>Free shipping, early access to sales, and hassle-free returns.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Panel -->
            <div class="register-form-area">
                <div class="register-heading">
                    <h2>Sign Up</h2>
                    <p>Already a member? <a href="{{ route('login') }}">Log in here</a></p>
                </div>

                <div class="modern-social-login">
                    <button type="button" class="social-btn"><i class="bi bi-google"></i> Google</button>
                    <button type="button" class="social-btn"><i class="bi bi-apple"></i> Apple</button>
                </div>

                <div class="form-divider">
                    <span>OR CONTINUE WITH EMAIL</span>
                </div>

                @if (isset($errors) && $errors->any())
                    <div class="alert alert-danger" role="alert" style="font-size: 13px; border-radius: var(--radius-sm);">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form class="velyora-register-form" action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="form-field">
                        <label>Full Name</label>
                        <div class="input-wrapper">
                            <i class="bi bi-person"></i>
                            <input type="text" name="fullname" value="{{ old('fullname') }}" placeholder="e.g. John Doe" required>
                        </div>
                    </div>

                    <div class="form-field">
                        <label>Email Address</label>
                        <div class="input-wrapper">
                            <i class="bi bi-envelope"></i>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="hello@example.com" required>
                        </div>
                    </div>

                    <div class="form-row-split">
                        <div class="form-field">
                            <label>Password</label>
                            <div class="input-wrapper">
                                <i class="bi bi-lock"></i>
                                <input type="password" name="password" placeholder="Create password" required>
                            </div>
                        </div>
                        <div class="form-field">
                            <label>Confirm</label>
                            <div class="input-wrapper">
                                <i class="bi bi-shield-lock"></i>
                                <input type="password" name="confirm_password" placeholder="Repeat password" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-field">
                        <label>Country</label>
                        <div class="input-wrapper">
                            <i class="bi bi-globe"></i>
                            <select name="country" required>
                                <option value="" disabled {{ old('country') ? '' : 'selected' }}>Select location</option>
                                <option value="PK" {{ old('country') === 'PK' ? 'selected' : '' }}>Pakistan</option>
                                <option value="US" {{ old('country') === 'US' ? 'selected' : '' }}>United States</option>
                                <option value="UK" {{ old('country') === 'UK' ? 'selected' : '' }}>United Kingdom</option>
                                <option value="CA" {{ old('country') === 'CA' ? 'selected' : '' }}>Canada</option>
                                <option value="AU" {{ old('country') === 'AU' ? 'selected' : '' }}>Australia</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-agreements">
                        <label class="custom-check">
                            <input type="checkbox" name="terms" required {{ old('terms') ? 'checked' : '' }}>
                            <span class="check-box"></span>
                            <span class="check-text">I agree to the <a href="#">Terms</a> and <a href="#">Privacy Policy</a>.</span>
                        </label>
                        <label class="custom-check">
                            <input type="checkbox" name="promotions" {{ old('promotions') ? 'checked' : '' }}>
                            <span class="check-box"></span>
                            <span class="check-text">Send me exclusive offers and promotions.</span>
                        </label>
                    </div>

                    <button type="submit" class="submit-btn">
                        Create Account <i class="bi bi-arrow-right"></i>
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>
</main>
@endsection
