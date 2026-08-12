<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Team Registration Form | Handball Competition System</title>

    <!-- Google Fonts (Inter) & FontAwesome -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #1e293b;
        }

        .team-reg-container {
            min-height: 100vh;
            display: flex;
        }

        /* Left Illustration Banner */
        .team-reg-illustration-side {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 50px;
            color: #ffffff;
        }

        .illustration-wrapper {
            max-width: 480px;
            width: 100%;
        }

        .brand-logo-wrap {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
        }

        .brand-logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 22px;
            margin-right: 14px;
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.4);
        }

        .brand-logo-text {
            font-size: 28px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.5px;
        }

        .feature-card-item {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            backdrop-filter: blur(10px);
        }

        .feature-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(37, 99, 235, 0.2);
            color: #60a5fa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-right: 16px;
            flex-shrink: 0;
        }

        /* Right Form Side */
        .team-reg-form-side {
            flex: 1.3;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 40px;
            overflow-y: auto;
        }

        .team-reg-form-box {
            max-width: 620px;
            width: 100%;
        }

        .form-header-title {
            font-size: 28px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .form-header-subtitle {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 32px;
        }

        .section-label-heading {
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #2563eb;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
        }

        .section-label-heading::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
            margin-left: 12px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 20px;
        }

        .form-control-custom {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            height: 50px;
            padding-left: 18px;
            padding-right: 18px;
            font-size: 14px;
            color: #1e293b;
            width: 100%;
            transition: all 0.2s ease;
        }

        .form-control-custom:focus {
            background: #ffffff;
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
            outline: none;
        }

        textarea.form-control-custom {
            height: auto;
            padding-top: 14px;
        }

        .btn-submit-team {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            height: 52px;
            font-size: 16px;
            font-weight: 700;
            width: 100%;
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 12px;
        }

        .btn-submit-team:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.45);
        }

        /* Success Card View */
        .success-box {
            text-align: center;
            padding: 40px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 20px;
        }

        .success-icon {
            width: 72px;
            height: 72px;
            background: #16a34a;
            color: #ffffff;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin-bottom: 20px;
            box-shadow: 0 10px 25px rgba(22, 163, 74, 0.3);
        }

        @media (max-width: 991px) {
            .team-reg-illustration-side {
                display: none;
            }
            .team-reg-form-side {
                padding: 40px 20px;
            }
        }
    </style>
</head>

<body>

    <div class="team-reg-container">

        <!-- LEFT SIDE: BRANDING & INSTRUCTIONS -->
        <div class="team-reg-illustration-side">
            <div class="illustration-wrapper">
                <div class="brand-logo-wrap">
                    <div class="brand-logo-icon">
                        <i class="fas fa-volleyball-ball"></i>
                    </div>
                    <div class="brand-logo-text">Handball <span style="font-size: 14px; color: #60a5fa; margin-left: 6px;">HUB</span></div>
                </div>

                <h2 style="font-weight: 800; font-size: 32px; margin-bottom: 16px; line-height: 1.2;">Official Club Registration Portal</h2>
                <p style="color: #94a3b8; font-size: 15px; margin-bottom: 36px;">Welcome Head Coach & Team Manager. Submit your official handball team information to join upcoming season competitions.</p>

                <div class="feature-card-item">
                    <div class="feature-card-icon"><i class="fas fa-shield-alt"></i></div>
                    <div>
                        <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 4px;">Club Profile Verification</h4>
                        <p style="font-size: 13px; color: #94a3b8; margin: 0;">Your team details will be instantly verified by the league administrator.</p>
                    </div>
                </div>

                <div class="feature-card-item">
                    <div class="feature-card-icon"><i class="fas fa-trophy"></i></div>
                    <div>
                        <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 4px;">League Placement</h4>
                        <p style="font-size: 13px; color: #94a3b8; margin: 0;">Select your preferred league or tournament group for auto-enrollment.</p>
                    </div>
                </div>

                <div class="feature-card-item">
                    <div class="feature-card-icon"><i class="fas fa-user-check"></i></div>
                    <div>
                        <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 4px;">Coach & Staff Contact</h4>
                        <p style="font-size: 13px; color: #94a3b8; margin: 0;">Receive official match schedules and status notifications by email.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE: REGISTRATION FORM -->
        <div class="team-reg-form-side">
            <div class="team-reg-form-box">

                @if(session('success'))
                    <!-- SUCCESS MESSAGE STATE -->
                    <div class="success-box mb-4">
                        <div class="success-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <h2 style="font-weight: 800; color: #15803d; margin-bottom: 8px;">Registration Submitted Successfully!</h2>
                        <p style="color: #374151; font-size: 15px; margin-bottom: 24px;">{{ session('success') }}</p>
                        <a href="{{ route('team-registration.public') }}" class="btn btn-outline-primary font-weight-bold px-4" style="border-radius: 12px; padding: 10px 20px;">
                            <i class="fas fa-redo mr-2"></i> Submit Another Team
                        </a>
                    </div>
                @else

                    <div id="formSection">
                        <h1 class="form-header-title">Register Your Team</h1>
                        <p class="form-header-subtitle">Fill out the team form below. This request will be sent directly to league administrators for approval.</p>

                        <form action="{{ route('team-registration.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- SECTION 1: CLUB INFO -->
                            <div class="section-label-heading">1. Club Details</div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="input-group-custom">
                                        <label class="small font-weight-bold text-gray-700 mb-1">Official Team / Club Name *</label>
                                        <input type="text" name="name" class="form-control-custom @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. Al Ahly SC / Barcelona HC" required>
                                        @error('name')
                                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group-custom">
                                        <label class="small font-weight-bold text-gray-700 mb-1">Short Code *</label>
                                        <input type="text" name="short_name" class="form-control-custom text-uppercase @error('short_name') is-invalid @enderror" value="{{ old('short_name') }}" placeholder="e.g. AHL" maxlength="20" required>
                                        @error('short_name')
                                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group-custom">
                                        <label class="small font-weight-bold text-gray-700 mb-1">Country *</label>
                                        <select name="country" class="form-control-custom @error('country') is-invalid @enderror" required>
                                            <option value="">Select Country...</option>
                                            <option value="Egypt" {{ old('country', 'Egypt') == 'Egypt' ? 'selected' : '' }}>Egypt</option>
                                            <option value="Spain" {{ old('country') == 'Spain' ? 'selected' : '' }}>Spain</option>
                                            <option value="Germany" {{ old('country') == 'Germany' ? 'selected' : '' }}>Germany</option>
                                            <option value="France" {{ old('country') == 'France' ? 'selected' : '' }}>France</option>
                                            <option value="Denmark" {{ old('country') == 'Denmark' ? 'selected' : '' }}>Denmark</option>
                                            <option value="Hungary" {{ old('country') == 'Hungary' ? 'selected' : '' }}>Hungary</option>
                                            <option value="Croatia" {{ old('country') == 'Croatia' ? 'selected' : '' }}>Croatia</option>
                                        </select>
                                        @error('country')
                                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group-custom">
                                        <label class="small font-weight-bold text-gray-700 mb-1">City / Location *</label>
                                        <input type="text" name="city" class="form-control-custom @error('city') is-invalid @enderror" value="{{ old('city') }}" placeholder="e.g. Cairo / Barcelona" required>
                                        @error('city')
                                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="input-group-custom">
                                <label class="small font-weight-bold text-gray-700 mb-1">Home Sports Arena / Hall Name</label>
                                <input type="text" name="arena" class="form-control-custom @error('arena') is-invalid @enderror" value="{{ old('arena') }}" placeholder="e.g. Al Ahly Sports Hall / Palau Blaugrana">
                                @error('arena')
                                    <small class="text-danger font-weight-bold">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- SECTION 2: COACH & MANAGER CONTACT -->
                            <div class="section-label-heading mt-4">2. Head Coach & Manager Info</div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group-custom">
                                        <label class="small font-weight-bold text-gray-700 mb-1">Manager / Coach Full Name *</label>
                                        <input type="text" name="manager_name" class="form-control-custom @error('manager_name') is-invalid @enderror" value="{{ old('manager_name') }}" placeholder="e.g. David Davis" required>
                                        @error('manager_name')
                                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group-custom">
                                        <label class="small font-weight-bold text-gray-700 mb-1">Email Address *</label>
                                        <input type="email" name="email" class="form-control-custom @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="coach@clubdomain.com" required>
                                        @error('email')
                                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group-custom">
                                        <label class="small font-weight-bold text-gray-700 mb-1">Phone / WhatsApp *</label>
                                        <input type="tel" name="phone" class="form-control-custom @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="+20 100 000 0000" required>
                                        @error('phone')
                                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION 3: LOGO -->
                            <div class="section-label-heading mt-4">3. Team Logo</div>

                            <div class="input-group-custom">
                                <label class="small font-weight-bold text-gray-700 mb-1">Team Crest / Logo (Optional)</label>
                                <input type="file" name="logo" class="form-control-custom p-2 @error('logo') is-invalid @enderror" accept="image/*">
                                @error('logo')
                                    <small class="text-danger font-weight-bold">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn-submit-team">
                                <i class="fas fa-paper-plane mr-2"></i> Submit Official Registration Form
                            </button>

                        </form>
                    </div>

                @endif

            </div>
        </div>

    </div>
</body>
</html>
