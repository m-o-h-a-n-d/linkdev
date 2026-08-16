@extends('frontend.layouts.app')

@section('title', 'Sign In — Handball Hub')

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <h1>Sign In</h1>
        <p class="auth-subtitle">Follow clubs, save fixtures and keep your profile up to date.</p>

        <!-- Auth Navigation Tabs -->
        <div class="auth-tabs">
            <a href="{{ route('login') }}" class="auth-tab active">Sign In</a>
            <a href="{{ route('register') }}" class="auth-tab">Sign Up</a>
        </div>

        @if(session('status'))
            <div class="alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Sign In Form -->
        <form action="{{ route('login') }}" method="POST" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="signin-email" class="form-label">Email</label>
                <input 
                    type="email" 
                    id="signin-email" 
                    name="email" 
                    class="form-control" 
                    placeholder="Enter your email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="signin-password" class="form-label">Password</label>
                <input 
                    type="password" 
                    id="signin-password" 
                    name="password" 
                    class="form-control" 
                    placeholder="Enter your password" 
                    required
                >
            </div>

            <div class="form-group form-options" style="flex-direction: row !important; justify-content: space-between !important; align-items: center !important; margin-bottom: 0.5rem;">
                <label style="display: inline-flex; align-items: center; gap: 8px; font-size: 0.9rem; cursor: pointer; color: #94a3b8; margin: 0;">
                    <input type="checkbox" name="remember" id="remember" value="1" {{ old('remember') ? 'checked' : '' }} style="width: 16px; height: 16px; cursor: pointer;">
                    Remember Me
                </label>
                <a href="{{ route('password.request') }}" style="font-size: 0.9rem; color: #ea580c; text-decoration: none;">Forgot Password?</a>
            </div>

            <button type="submit" class="btn-submit">Sign In</button>
        </form>
    </div>
</div>
@endsection
