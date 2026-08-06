@extends('frontend.layouts.app')

@section('title', 'Sign Up — Handball Hub')

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <h1>Create Account</h1>
        <p class="auth-subtitle">Join Handball Hub to follow your favorite teams and leagues.</p>

        <!-- Auth Navigation Tabs -->
        <div class="auth-tabs">
            <a href="{{ route('login') }}" class="auth-tab">Sign In</a>
            <a href="{{ route('register') }}" class="auth-tab active">Sign Up</a>
        </div>

        @if($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Sign Up Form -->
        <form action="{{ route('register') }}" method="POST" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="signup-name" class="form-label">Full Name</label>
                <input 
                    type="text" 
                    id="signup-name" 
                    name="name" 
                    class="form-control" 
                    placeholder="Enter your full name" 
                    value="{{ old('name') }}" 
                    required 
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="signup-email" class="form-label">Email</label>
                <input 
                    type="email" 
                    id="signup-email" 
                    name="email" 
                    class="form-control" 
                    placeholder="Enter your email" 
                    value="{{ old('email') }}" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="signup-password" class="form-label">Password</label>
                <input 
                    type="password" 
                    id="signup-password" 
                    name="password" 
                    class="form-control" 
                    placeholder="Create a password" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="signup-password-confirm" class="form-label">Confirm Password</label>
                <input 
                    type="password" 
                    id="signup-password-confirm" 
                    name="password_confirmation" 
                    class="form-control" 
                    placeholder="Confirm your password" 
                    required
                >
            </div>

            <button type="submit" class="btn-submit">Sign Up</button>
        </form>

        <!-- Divider -->
        <div class="auth-divider">or</div>

        <!-- Google Sign In -->
        <button type="button" class="btn-google">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
            Continue with Google
        </button>
    </div>
</div>
@endsection
