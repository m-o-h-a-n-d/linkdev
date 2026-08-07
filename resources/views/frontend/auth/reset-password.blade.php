@extends('frontend.layouts.app')

@section('title', 'Reset Password — Handball Hub')

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <div style="text-align: center; margin-bottom: 20px;">
            <div style="display: inline-flex; width: 64px; height: 64px; background: rgba(16, 185, 129, 0.1); border: 2px solid #10b981; border-radius: 50%; align-items: center; justify-content: center; color: #10b981; font-size: 28px;">
                🔒
            </div>
        </div>

        <h1>Reset Password</h1>
        <p class="auth-subtitle">Create a secure new password for your account.</p>

        @if(session('status'))
            <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid #10b981; color: #10b981; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.88rem; text-align: center;">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; color: #ef4444; padding: 14px; border-radius: 8px; margin-bottom: 20px; font-size: 0.88rem;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST" class="auth-form">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="reset-email" class="form-label">Email Address</label>
                <input 
                    type="email" 
                    id="reset-email" 
                    name="email" 
                    class="form-control" 
                    placeholder="name@example.com" 
                    value="{{ old('email', $email) }}" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="reset-password" class="form-label">New Password</label>
                <input 
                    type="password" 
                    id="reset-password" 
                    name="password" 
                    class="form-control" 
                    placeholder="Minimum 8 characters" 
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="reset-password-confirm" class="form-label">Confirm New Password</label>
                <input 
                    type="password" 
                    id="reset-password-confirm" 
                    name="password_confirmation" 
                    class="form-control" 
                    placeholder="Repeat new password" 
                    required
                >
            </div>

            <button type="submit" class="btn-submit" style="background: var(--accent-orange, #ea580c); color: #fff; border: none; padding: 14px; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: background 0.2s;">
                Update Password & Login &rarr;
            </button>
        </form>

        <div style="margin-top: 2rem; text-align: center;">
            <a href="{{ route('login') }}" style="font-size: 0.9rem; color: var(--accent-orange, #ea580c); text-decoration: none; font-weight: 600;">
                &larr; Back to Sign In
            </a>
        </div>
    </div>
</div>
@endsection
