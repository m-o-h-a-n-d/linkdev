<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Verify OTP Code | Admina Handball Management</title>

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
            margin-bottom: 32px;
            line-height: 1.5;
        }

        /* OTP 6-Digit Inputs Grid */
        .otp-inputs-wrapper {
            display: flex;
            gap: 10px;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .otp-digit-input {
            width: 52px;
            height: 58px;
            border-radius: 12px;
            background: #162238;
            border: 1px solid #1e293b;
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            color: #ffffff;
            transition: all 0.2s ease;
        }

        .otp-digit-input:focus {
            background: #162238;
            border-color: #ea580c;
            box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.2);
            color: #ffffff;
            outline: none;
        }

        /* Resend Timer Text */
        .resend-timer-box {
            text-align: center;
            font-size: 14px;
            color: #94a3b8;
            margin-bottom: 28px;
        }

        .resend-timer-box a {
            color: #f97316;
            font-weight: 700;
            text-decoration: none;
        }

        .resend-timer-box a:hover {
            color: #ea580c;
            text-decoration: underline;
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

        <!-- LEFT SIDE: OTP VERIFICATION VECTOR ILLUSTRATION -->
        <div class="login-illustration-side">
            <div class="illustration-wrapper">
                <svg class="illustration-svg-box" viewBox="0 0 600 500" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="20" y="20" width="560" height="460" rx="24" fill="#DCFCE7" opacity="0.6"/>
                    <circle cx="120" cy="120" r="70" fill="#BBF7D0" opacity="0.6"/>
                    <circle cx="480" cy="380" r="90" fill="#BBF7D0" opacity="0.6"/>

                    <!-- Smartphone Verification Card -->
                    <rect x="220" y="100" width="160" height="300" rx="28" fill="#ffffff" stroke="#10B981" stroke-width="6" filter="drop-shadow(0px 12px 30px rgba(16, 185, 129, 0.2))"/>
                    <rect x="270" y="115" width="60" height="8" rx="4" fill="#E2E8F0"/>

                    <!-- Verification Code Boxes on Phone -->
                    <rect x="240" y="180" width="120" height="60" rx="12" fill="#F0FDF4" stroke="#10B981" stroke-width="2"/>
                    <text x="300" y="218" font-family="Inter, sans-serif" font-size="20" font-weight="700" fill="#059669" text-anchor="middle">5 • 8 • 2 • 4</text>

                    <!-- Green Checkmark Shield Badge -->
                    <circle cx="370" cy="270" r="36" fill="#10B981" filter="drop-shadow(0px 8px 20px rgba(16, 185, 129, 0.4))"/>
                    <path d="M356 270 L366 280 L384 260" stroke="#ffffff" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>

                    <!-- Mail Envelope Badge -->
                    <circle cx="170" cy="220" r="34" fill="#ffffff" filter="drop-shadow(0px 8px 20px rgba(0,0,0,0.1))"/>
                    <path d="M152 210 H188 V230 H152 Z" fill="#10B981" rx="4"/>
                    <path d="M152 210 L170 222 L188 210" stroke="#ffffff" stroke-width="3"/>
                </svg>
            </div>
        </div>

        <!-- RIGHT SIDE: VERIFY OTP FORM -->
        <div class="login-form-side">
            <div class="login-form-box">

                <!-- Logo Header -->
                <div class="brand-logo-wrap">
                    <div class="brand-logo-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="brand-logo-text">Admina</div>
                </div>

                <!-- Form Titles -->
                <h2 class="login-title">Enter OTP Code</h2>
                <p class="login-subtitle">We sent a 6-digit verification code to <strong class="text-dark">admin@example.com</strong>. Enter it below to proceed.</p>

                <!-- OTP Form -->
                <form action="{{ route('admin.auth.reset-password') }}" method="GET" id="otpForm">

                    <!-- 6 Digit OTP Inputs -->
                    <div class="otp-inputs-wrapper">
                        <input type="text" class="otp-digit-input" maxlength="1" pattern="[0-9]" required autofocus>
                        <input type="text" class="otp-digit-input" maxlength="1" pattern="[0-9]" required>
                        <input type="text" class="otp-digit-input" maxlength="1" pattern="[0-9]" required>
                        <input type="text" class="otp-digit-input" maxlength="1" pattern="[0-9]" required>
                        <input type="text" class="otp-digit-input" maxlength="1" pattern="[0-9]" required>
                        <input type="text" class="otp-digit-input" maxlength="1" pattern="[0-9]" required>
                    </div>

                    <!-- Resend Timer -->
                    <div class="resend-timer-box">
                        Didn't receive the code? <a href="#!" id="resendOtpBtn">Resend Code</a> <span class="text-muted ml-1" id="timerCount">(00:45)</span>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-signin">
                        Verify OTP Code
                    </button>

                    <!-- Back to Login Footer -->
                    <div class="signup-footer-text">
                        Wrong email address? <a href="{{ route('admin.auth.forgot-password') }}">Change Email</a>
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
            const otpInputs = document.querySelectorAll('.otp-digit-input');

            otpInputs.forEach((input, index) => {
                input.addEventListener('input', function () {
                    if (this.value.length === 1 && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', function (e) {
                    if (e.key === 'Backspace' && this.value.length === 0 && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });
            });
        });
    </script>
</body>
</html>
