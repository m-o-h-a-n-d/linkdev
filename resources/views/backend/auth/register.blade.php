<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Create Admin Account | Handball System</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
            margin-top: 28px;
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

        <!-- LEFT SIDE: VECTOR ILLUSTRATION -->
        <div class="login-illustration-side">
            <div class="illustration-wrapper">
                <svg class="illustration-svg-box" viewBox="0 0 600 500" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="20" y="20" width="560" height="460" rx="24" fill="#0E1626" stroke="#1E293B" stroke-width="2"/>
                    <circle cx="300" cy="200" r="80" fill="#EA580C" opacity="0.2"/>
                    <path d="M300 130 C340 130, 370 160, 370 200 C370 240, 340 270, 300 270 C260 270, 230 240, 230 200 C230 160, 260 130, 300 130 Z" fill="#EA580C" opacity="0.3"/>
                    <circle cx="300" cy="180" r="30" fill="#FFFFFF"/>
                    <path d="M220 340 C220 290, 260 270, 300 270 C340 270, 380 290, 380 340" fill="#EA580C"/>
                </svg>
            </div>
        </div>

        <!-- RIGHT SIDE: FORM -->
        <div class="login-form-side">
            <div class="login-form-box">

                <div class="brand-logo-wrap">
                    <div class="brand-logo-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="brand-logo-text">Admina</div>
                </div>

                <h2 class="login-title">Create Admin Account</h2>
                <p class="login-subtitle">Register a new administrator account to manage handball competitions.</p>

                <form action="{{ route('admin.dashboard.index') }}" method="GET">
                    <div class="row">
                        <div class="col-6">
                            <div class="input-group-custom">
                                <i class="far fa-user input-icon-left"></i>
                                <input type="text" class="form-control-login" placeholder="First Name" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group-custom">
                                <i class="far fa-user input-icon-left"></i>
                                <input type="text" class="form-control-login" placeholder="Last Name" required>
                            </div>
                        </div>
                    </div>

                    <div class="input-group-custom">
                        <i class="far fa-envelope input-icon-left"></i>
                        <input type="email" class="form-control-login" placeholder="Email Address" required>
                    </div>

                    <button type="submit" class="btn-signin">
                        Create Account
                    </button>
                </form>

                <div class="signup-footer-text">
                    Already have an account? <a href="{{ route('admin.auth.login') }}">Login!</a>
                </div>

            </div>
        </div>

    </div>

    <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
