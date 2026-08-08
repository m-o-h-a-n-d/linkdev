<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sign In | Admina Handball Management</title>

    <!-- Google Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #070c14;
            color: #cbd5e1;
        }

        .login-split-container {
            min-height: 100vh;
            display: flex;
        }

        /* Left Side Illustration Area */
        .login-illustration-side {
            background: radial-gradient(circle at center, #0e1626 0%, #070c14 100%);
            border-right: 1px solid #1e293b;
            flex: 1.1;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 40px;
            overflow: hidden;
        }

        .illustration-wrapper {
            max-width: 520px;
            width: 100%;
            text-align: center;
            position: relative;
        }

        /* SVG Vector Illustration */
        .illustration-svg-box {
            width: 100%;
            height: auto;
            max-height: 480px;
        }

        /* Right Side Form Area */
        .login-form-side {
            flex: 1;
            background: #0e1626;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 40px;
        }

        .login-form-box {
            max-width: 420px;
            width: 100%;
        }

        /* Logo Header */
        .brand-logo-wrap {
            display: flex;
            align-items: center;
            margin-bottom: 32px;
        }

        .brand-logo-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 20px;
            margin-right: 12px;
            box-shadow: 0 6px 18px rgba(234, 88, 12, 0.4);
        }

        .brand-logo-text {
            font-size: 28px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.5px;
        }

        .login-title {
            font-size: 26px;
            font-weight: 700;
            color: #f8fafc;
            margin-bottom: 6px;
        }

        .login-subtitle {
            font-size: 14px;
            color: #94a3b8;
            margin-bottom: 32px;
        }

        /* Input Custom Styling */
        .input-group-custom {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group-custom .input-icon-left {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 15px;
            z-index: 5;
        }

        .input-group-custom .input-icon-right {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 15px;
            cursor: pointer;
            z-index: 5;
        }

        .form-control-login {
            background: #162238;
            border: 1px solid #1e293b;
            border-radius: 12px;
            height: 52px;
            padding-left: 50px;
            padding-right: 50px;
            font-size: 14px;
            color: #ffffff;
            width: 100%;
            transition: all 0.2s ease;
        }

        .form-control-login:focus {
            background: #162238;
            border-color: #ea580c;
            box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.2);
            color: #ffffff;
            outline: none;
        }

        /* Checkbox & Forgot Password */
        .remember-forgot-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
            font-size: 14px;
        }

        .remember-checkbox {
            display: flex;
            align-items: center;
            color: #94a3b8;
            cursor: pointer;
            margin: 0;
        }

        .remember-checkbox input {
            margin-right: 8px;
            width: 16px;
            height: 16px;
            accent-color: #ea580c;
            cursor: pointer;
        }

        .forgot-password-link {
            color: #f97316;
            font-weight: 600;
            text-decoration: none;
        }

        .forgot-password-link:hover {
            color: #ea580c;
            text-decoration: underline;
        }

        /* Sign In Button */
        .btn-signin {
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            height: 52px;
            font-size: 15px;
            font-weight: 600;
            width: 100%;
            box-shadow: 0 4px 18px rgba(234, 88, 12, 0.4);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-signin:hover {
            background: linear-gradient(135deg, #c2410c 0%, #9a3412 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 24px rgba(234, 88, 12, 0.55);
        }

        /* Divider Line */
        .divider-line {
            display: flex;
            align-items: center;
            text-align: center;
            color: #64748b;
            font-size: 13px;
            margin: 28px 0 24px 0;
        }

        .divider-line::before, .divider-line::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #1e293b;
        }

        .divider-line span {
            padding: 0 14px;
        }

        /* Social Login Buttons */
        .social-buttons-row {
            display: flex;
            gap: 16px;
            margin-bottom: 32px;
        }

        .btn-social {
            flex: 1;
            background: #162238;
            border: 1px solid #1e293b;
            border-radius: 12px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
            color: #e2e8f0;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-social:hover {
            background: #1e293b;
            border-color: #ea580c;
            text-decoration: none;
            color: #ffffff;
        }

        .btn-social i {
            font-size: 16px;
            margin-right: 8px;
        }

        .signup-footer-text {
            text-align: center;
            font-size: 14px;
            color: #94a3b8;
        }

        .signup-footer-text a {
            color: #f97316;
            font-weight: 700;
            text-decoration: none;
            margin-left: 4px;
        }

        .signup-footer-text a:hover {
            color: #ea580c;
            text-decoration: underline;
        }

        @media (max-width: 991px) {
            .login-illustration-side {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="login-split-container">

        <!-- LEFT SIDE: VECTOR ILLUSTRATION (MATCHING SCREENSHOT) -->
        <div class="login-illustration-side">
            <div class="illustration-wrapper">
                <svg class="illustration-svg-box" viewBox="0 0 600 500" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Background Soft Elements -->
                    <rect x="20" y="20" width="560" height="460" rx="24" fill="#EBF0FF" opacity="0.5"/>
                    <circle cx="100" cy="100" r="60" fill="#DBE5FF" opacity="0.6"/>
                    <circle cx="500" cy="400" r="80" fill="#DBE5FF" opacity="0.6"/>

                    <!-- Park Bench Illustration -->
                    <path d="M120 340 H480 V355 H120 Z" fill="#64748B"/>
                    <path d="M140 355 V440 H160 V355 Z" fill="#475569"/>
                    <path d="M440 355 V440 H460 V355 Z" fill="#475569"/>
                    <path d="M130 280 H470 V320 H130 Z" fill="#94A3B8"/>
                    <path d="M150 220 V340" stroke="#475569" stroke-width="8"/>
                    <path d="M450 220 V340" stroke="#475569" stroke-width="8"/>

                    <!-- Street Lamp -->
                    <path d="M90 120 V440" stroke="#475569" stroke-width="6"/>
                    <path d="M75 120 H105 L90 90 Z" fill="#334155"/>
                    <circle cx="90" cy="130" r="14" fill="#FDE047"/>

                    <!-- Floating Login Screen Card behind Person -->
                    <rect x="230" y="110" width="220" height="280" rx="16" fill="#ffffff" filter="drop-shadow(0px 10px 25px rgba(37, 99, 235, 0.15))"/>
                    <rect x="230" y="110" width="220" height="280" rx="16" fill="#C7D2FE" opacity="0.4"/>
                    
                    <circle cx="340" cy="160" r="28" fill="#ffffff"/>
                    <circle cx="340" cy="152" r="12" fill="#93C5FD"/>
                    <path d="M320 180 C320 168, 360 168, 360 180 Z" fill="#93C5FD"/>

                    <rect x="260" y="210" width="160" height="26" rx="13" fill="#ffffff"/>
                    <circle cx="273" cy="223" r="6" fill="#93C5FD"/>
                    <rect x="260" y="250" width="160" height="26" rx="13" fill="#ffffff"/>
                    <circle cx="273" cy="263" r="6" fill="#93C5FD"/>

                    <rect x="260" y="295" width="160" height="32" rx="16" fill="#2563EB"/>
                    <rect x="310" y="307" width="60" height="8" rx="4" fill="#ffffff"/>

                    <!-- Checkmark Badge -->
                    <circle cx="180" cy="160" r="30" fill="#3B82F6"/>
                    <path d="M168 160 L176 168 L192 152" stroke="#ffffff" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>

                    <!-- Potted Plant -->
                    <path d="M480 390 L490 440 H530 L540 390 Z" fill="#2563EB"/>
                    <path d="M495 390 C480 340, 520 320, 510 390 Z" fill="#1E293B"/>
                    <path d="M515 390 C500 330, 550 310, 530 390 Z" fill="#334155"/>

                    <!-- Sitting Person with Tablet -->
                    <!-- Legs -->
                    <path d="M210 340 L260 410 L280 410" stroke="#1E293B" stroke-width="14" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M190 340 L230 420 L250 420" stroke="#334155" stroke-width="14" stroke-linecap="round" stroke-linejoin="round"/>
                    <!-- Shoes -->
                    <ellipse cx="285" cy="412" rx="12" ry="6" fill="#0F172A"/>
                    <ellipse cx="255" cy="422" rx="12" ry="6" fill="#0F172A"/>
                    <!-- Body -->
                    <path d="M180 270 L210 340 H160 Z" fill="#2563EB"/>
                    <!-- Arms holding tablet -->
                    <path d="M185 270 L220 300 L200 310" stroke="#2563EB" stroke-width="10" stroke-linecap="round"/>
                    <rect x="210" y="295" width="30" height="22" rx="4" fill="#94A3B8" transform="rotate(-15 210 295)"/>
                    <!-- Head & Hair -->
                    <circle cx="180" cy="240" r="18" fill="#FDBA74"/>
                    <path d="M165 235 C165 215, 195 215, 195 235 C195 242, 165 242, 165 235 Z" fill="#1E293B"/>
                </svg>
            </div>
        </div>

        <!-- RIGHT SIDE: SIGN IN FORM (MATCHING SCREENSHOT) -->
        <div class="login-form-side">
            <div class="login-form-box">

                <!-- Logo Header -->
                <div class="brand-logo-wrap">
                    <div class="brand-logo-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="brand-logo-text">Admina</div>
                </div>

                <!-- Form Titles -->
                <h2 class="login-title">Sign In to your Account</h2>
                <p class="login-subtitle">Welcome back! please enter your detail</p>

                <!-- Login Form -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #10b981; color: #fff; border: none; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px;">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.auth.login') }}" method="POST">
                    @csrf

                    <!-- Email Input -->
                    <div class="input-group-custom">
                        <i class="far fa-envelope input-icon-left"></i>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control-login @error('email') is-invalid @enderror" placeholder="Email" required>
                    </div>
                    @error('email')
                        <div class="text-danger small mb-3" style="margin-top: -12px;">{{ $message }}</div>
                    @enderror

                    <!-- Password Input with Toggle Eye -->
                    <div class="input-group-custom">
                        <i class="fas fa-lock input-icon-left"></i>
                        <input type="password" name="password" id="passwordInput" class="form-control-login @error('password') is-invalid @enderror" placeholder="Password" required>
                        <i class="far fa-eye input-icon-right" id="togglePasswordBtn"></i>
                    </div>
                    @error('password')
                        <div class="text-danger small mb-3" style="margin-top: -12px;">{{ $message }}</div>
                    @enderror

                    <!-- Remember Me & Forgot Password -->
                    <div class="remember-forgot-row">
                        <label class="remember-checkbox">
                            <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                            <span>Remember me</span>
                        </label>
                        <a href="{{ route('admin.auth.forgot-password') }}" class="forgot-password-link">Forgot Password?</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-signin">
                        Sign In
                    </button>

                </form>

            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePasswordBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('passwordInput');

            if (togglePasswordBtn && passwordInput) {
                togglePasswordBtn.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
</body>
</html>
