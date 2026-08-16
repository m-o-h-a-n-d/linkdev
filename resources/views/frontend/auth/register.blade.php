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
    </div>
</div>
@endsection
