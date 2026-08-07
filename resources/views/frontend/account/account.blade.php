@extends('frontend.layouts.app')

@section('title', 'My Account — Handball Hub')

@section('content')
<section class="account-section">
    <div class="container account-container">
        
        <h1 class="page-title">MY ACCOUNT</h1>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
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

        <!-- Account Profile Summary Header Card -->
        <div class="account-profile-card">
            <div class="avatar-box">
                {{ strtoupper(substr($user->name ?? 'M', 0, 1)) }}
            </div>
            <div class="profile-info">
                <div class="profile-name">{{ strtoupper($user->name ?? 'MOHANANKJSKA') }}</div>
                <div class="profile-email">{{ $user->email ?? 'mohabmohan800@gmail.com' }}</div>
            </div>
        </div>

        <!-- Account Settings Form -->
        <form action="{{ route('account.update') }}" method="POST" class="account-form">
            @csrf
            @method('PUT')

            <!-- Full Name -->
            <div class="form-group">
                <label for="name" class="form-label">FULL NAME</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-control" 
                    value="{{ old('name', $user->name ?? 'Mohanankjska') }}" 
                    required
                >
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">EMAIL ADDRESS</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control" 
                    value="{{ old('email', $user->email ?? '') }}" 
                    required
                >
            </div>

            <!-- Current Password -->
            <div class="form-group">
                <label for="current_password" class="form-label">CURRENT PASSWORD (REQUIRED TO CHANGE PASSWORD)</label>
                <input 
                    type="password" 
                    id="current_password" 
                    name="current_password" 
                    class="form-control" 
                    placeholder="Leave blank unless changing password"
                >
            </div>

            <!-- New Password -->
            <div class="form-group">
                <label for="password" class="form-label">NEW PASSWORD</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control" 
                    placeholder="Enter new password (minimum 8 characters)"
                >
            </div>

            <!-- Confirm New Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">CONFIRM NEW PASSWORD</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="form-control" 
                    placeholder="Confirm new password"
                >
            </div>

            <!-- Action Buttons -->
            <div class="account-actions">
                <button type="submit" class="btn-save">SAVE CHANGES</button>
                <button type="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn-signout">SIGN OUT</button>
            </div>
        </form>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

    </div>
</section>
@endsection
