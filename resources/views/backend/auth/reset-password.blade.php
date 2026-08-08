<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Create New Password | Admina Handball Management</title>

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
            max-width: 440px;
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
            margin-bottom: 28px;
            line-height: 1.5;
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

        /* Password Strength Bar */
        .password-strength-box {
            margin-bottom: 24px;
        }

        .strength-bar-bg {
            height: 6px;
            border-radius: 3px;
            background: #162238;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .strength-bar-fill {
            height: 100%;
            width: 75%;
            background: linear-gradient(90deg, #ea580c, #f97316);
            border-radius: 3px;
            transition: width 0.3s ease;
        }

        .strength-rules-text {
            font-size: 12px;
            color: #94a3b8;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .strength-rules-text span {
            display: inline-flex;
            align-items: center;
        }

        .strength-rules-text i {
            font-size: 10px;
            margin-right: 4px;
        }

        /* Submit Button */
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
        .signup-footer-text {
            text-align: center;
            font-size: 14px;
            color: #94a3b8;
            margin-top: 32px;
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

        .signup-footer-text a {
            color: #ef4444;
            font-weight: 700;
            text-decoration: none;
            margin-left: 4px;
        }

        .signup-footer-text a:hover {
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

        <!-- LEFT SIDE: RESET PASSWORD VECTOR ILLUSTRATION -->
        <div class="login-illustration-side">
            <div class="illustration-wrapper">
                <svg class="illustration-svg-box" viewBox="0 0 600 500" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="20" y="20" width="560" height="460" rx="24" fill="#E9D5FF" opacity="0.6"/>
                    <circle cx="120" cy="120" r="70" fill="#D8B4FE" opacity="0.6"/>
                    <circle cx="480" cy="380" r="90" fill="#D8B4FE" opacity="0.6"/>

                    <!-- Security Shield Illustration -->
                    <path d="M300 110 L420 160 V270 C420 350, 300 410, 300 410 C300 410, 180 350, 180 270 V160 Z" fill="#9333EA" filter="drop-shadow(0px 12px 30px rgba(147, 51, 234, 0.25))"/>
                    <path d="M300 130 L395 173 V265 C395 330, 300 380, 300 380 Z" fill="#A855F7" opacity="0.5"/>

                    <!-- Inner Lock on Shield -->
                    <rect x="260" y="230" width="80" height="75" rx="14" fill="#ffffff"/>
                    <path d="M275 230 V205 C275 188, 325 188, 325 205 V230" stroke="#ffffff" stroke-width="10" stroke-linecap="round"/>
                    <circle cx="300" cy="262" r="8" fill="#9333EA"/>
                    <path d="M300 268 V285" stroke="#9333EA" stroke-width="5" stroke-linecap="round"/>

                    <!-- Floating Stars -->
                    <circle cx="150" cy="240" r="28" fill="#ffffff" filter="drop-shadow(0px 8px 20px rgba(0,0,0,0.1))"/>
                    <path d="M150 226 L154 236 L164 240 L154 244 L150 254 L146 244 L136 240 L146 236 Z" fill="#9333EA"/>
                </svg>
            </div>
        </div>

        <!-- RIGHT SIDE: RESET PASSWORD FORM -->
        <div class="login-form-side">
            <div class="login-form-box">

                <!-- Logo Header -->
                <div class="brand-logo-wrap">
                    <div class="brand-logo-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="brand-logo-text">Admina</div>
                </div>

                <!-- Form Titles -->
                <h2 class="login-title">Create New Password</h2>
                <p class="login-subtitle">Your new password must be strong and different from previous passwords.</p>

                <!-- Reset Password Form -->
                <form action="{{ route('admin.dashboard.index') }}" method="GET">

                    <!-- New Password Input -->
                    <div class="input-group-custom">
                        <i class="fas fa-lock input-icon-left"></i>
                        <input type="password" id="newPasswordInput" class="form-control-login" placeholder="Enter new password" required>
                        <i class="far fa-eye input-icon-right" id="toggleNewPasswordBtn"></i>
                    </div>

                    <!-- Confirm New Password Input -->
                    <div class="input-group-custom">
                        <i class="fas fa-check-double input-icon-left"></i>
                        <input type="password" id="confirmPasswordInput" class="form-control-login" placeholder="Confirm new password" required>
                        <i class="far fa-eye input-icon-right" id="toggleConfirmPasswordBtn"></i>
                    </div>

                    <!-- Password Strength Meter -->
                    <div class="password-strength-box">
                        <div class="strength-bar-bg">
                            <div class="strength-bar-fill" id="strengthBarFill"></div>
                        </div>
                        <div class="strength-rules-text">
                            <span class="text-success"><i class="fas fa-check-circle"></i> Min 8 Chars</span>
                            <span class="text-success"><i class="fas fa-check-circle"></i> 1 Uppercase</span>
                            <span class="text-success"><i class="fas fa-check-circle"></i> 1 Number</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-signin">
                        Reset Password & Sign In
                    </button>

                    <!-- Back to Login Footer -->
                    <div class="signup-footer-text">
                        Remembered your password? <a href="{{ route('admin.auth.login') }}">Back to Sign In</a>
                    </div>

                </form>

            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function setupToggle(btnId, inputId) {
                const btn = document.getElementById(btnId);
                const input = document.getElementById(inputId);
                if (btn && input) {
                    btn.addEventListener('click', function () {
                        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                        input.setAttribute('type', type);
                        this.classList.toggle('fa-eye');
                        this.classList.toggle('fa-eye-slash');
                    });
                }
            }

            setupToggle('toggleNewPasswordBtn', 'newPasswordInput');
            setupToggle('toggleConfirmPasswordBtn', 'confirmPasswordInput');
        });
    </script>
</body>
</html>
