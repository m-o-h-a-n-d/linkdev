<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Forgot Password | Admina Handball Management</title>

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
            line-height: 1.5;
        }

        /* Input Custom Styling */
        .input-group-custom {
            position: relative;
            margin-bottom: 24px;
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

        .form-control-login {
            background: #162238;
            border: 1px solid #1e293b;
            border-radius: 12px;
            height: 52px;
            padding-left: 50px;
            padding-right: 20px;
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
        }

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

        @media (max-width: 991px) {
            .login-illustration-side {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="login-split-container">

        <!-- LEFT SIDE: FORGOT PASSWORD VECTOR ILLUSTRATION -->
        <div class="login-illustration-side">
            <div class="illustration-wrapper">
                <svg class="illustration-svg-box" viewBox="0 0 600 500" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="20" y="20" width="560" height="460" rx="24" fill="#FFEDD5" opacity="0.6"/>
                    <circle cx="120" cy="120" r="70" fill="#FED7AA" opacity="0.6"/>
                    <circle cx="480" cy="380" r="90" fill="#FED7AA" opacity="0.6"/>

                    <!-- Big Lock Illustration -->
                    <rect x="210" y="220" width="180" height="170" rx="28" fill="#F97316" filter="drop-shadow(0px 12px 30px rgba(249, 115, 22, 0.25))"/>
                    <path d="M250 220 V160 C250 120, 350 120, 350 160 V220" stroke="#EA580C" stroke-width="24" stroke-linecap="round"/>
                    <circle cx="300" cy="290" r="16" fill="#ffffff"/>
                    <path d="M300 300 V340" stroke="#ffffff" stroke-width="12" stroke-linecap="round"/>

                    <!-- Floating Key Icon Badge -->
                    <circle cx="420" cy="180" r="38" fill="#ffffff" filter="drop-shadow(0px 8px 20px rgba(0,0,0,0.1))"/>
                    <path d="M405 180 C405 172, 412 165, 420 165 C428 165, 435 172, 435 180 C435 185, 432 190, 427 193 L427 200 L420 200 L420 193 C412 191, 405 186, 405 180 Z" fill="#F97316"/>

                    <!-- Envelope Badge -->
                    <circle cx="170" cy="320" r="32" fill="#ffffff" filter="drop-shadow(0px 8px 20px rgba(0,0,0,0.1))"/>
                    <path d="M152 310 H188 V330 H152 Z" fill="#F97316" rx="4"/>
                    <path d="M152 310 L170 322 L188 310" stroke="#ffffff" stroke-width="3"/>
                </svg>
            </div>
        </div>

        <!-- RIGHT SIDE: FORGOT PASSWORD FORM -->
        <div class="login-form-side">
            <div class="login-form-box">

                <!-- Logo Header -->
                <div class="brand-logo-wrap">
                    <div class="brand-logo-icon">
                        <i class="fas fa-key"></i>
                    </div>
                    <div class="brand-logo-text">Admina</div>
                </div>

                <!-- Form Titles -->
                <h2 class="login-title">Forgot Password?</h2>
                <p class="login-subtitle">No worries! Enter your registered email address below and we'll send you a 6-digit OTP verification code.</p>

                <!-- Forgot Password Form -->
                <form action="{{ route('admin.auth.verify-otp') }}" method="GET">

                    <!-- Email Input -->
                    <div class="input-group-custom">
                        <i class="far fa-envelope input-icon-left"></i>
                        <input type="email" class="form-control-login" placeholder="Enter your email address" required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-signin">
                        Send OTP Verification Code
                    </button>

                    <!-- Signup Link Footer -->
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
</body>
</html>
