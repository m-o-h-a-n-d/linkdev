@extends('frontend.layouts.app')

@section('title', 'Verify Email Address — Handball Hub')

@push('styles')
<style>
    /* Ultra Premium Animated Email OTP Interface Styles */
    
    .otp-wrapper {
        min-height: calc(100vh - 160px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        position: relative;
        overflow: hidden;
    }

    .otp-wrapper::before {
        content: '';
        position: absolute;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.18) 0%, rgba(0, 0, 0, 0) 70%);
        top: 20%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
        z-index: 0;
    }

    .otp-card {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 490px;
        background: rgba(14, 22, 38, 0.75);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 44px 38px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7), 0 0 40px rgba(16, 185, 129, 0.08);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .otp-card:hover {
        border-color: rgba(16, 185, 129, 0.3);
        box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.8), 0 0 50px rgba(16, 185, 129, 0.15);
    }

    /* Envelope Badge & Pulses */
    .otp-badge-container {
        position: relative;
        width: 90px;
        height: 90px;
        margin: 0 auto 28px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .otp-pulse-ring-1 {
        position: absolute;
        inset: -10px;
        border-radius: 50%;
        border: 2px dashed rgba(16, 185, 129, 0.4);
        animation: spinRing 12s linear infinite;
    }

    .otp-pulse-ring-2 {
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: rgba(16, 185, 129, 0.15);
        animation: pulseGlow 2.4s ease-in-out infinite;
    }

    .otp-badge-icon {
        position: relative;
        z-index: 2;
        width: 72px;
        height: 72px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
    }

    .otp-badge-icon svg {
        width: 34px;
        height: 34px;
        stroke: #ffffff;
        stroke-width: 2.2;
        fill: none;
        stroke-linecap: round;
        stroke-linejoin: round;
        animation: floatingLock 3s ease-in-out infinite;
    }

    .otp-title {
        font-family: var(--font-heading, 'Oswald', sans-serif);
        font-size: 2.1rem;
        font-weight: 800;
        color: #ffffff;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    .otp-subtitle {
        font-size: 0.95rem;
        color: #94a3b8;
        line-height: 1.5;
        margin-bottom: 30px;
    }

    .otp-email-highlight {
        color: #f8fafc;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.06);
        padding: 3px 10px;
        border-radius: 6px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        display: inline-block;
        margin-top: 4px;
    }

    .otp-boxes-grid {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin: 28px 0 24px;
        direction: ltr;
    }

    .otp-box {
        width: 54px;
        height: 64px;
        background: rgba(7, 12, 20, 0.8);
        border: 2px solid #1e293b;
        border-radius: 12px;
        color: #ffffff;
        font-size: 1.9rem;
        font-weight: 800;
        text-align: center;
        font-family: 'Inter', monospace;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.5);
    }

    .otp-box:focus {
        outline: none;
        border-color: #10b981;
        background: rgba(14, 22, 38, 0.95);
        box-shadow: 0 0 25px rgba(16, 185, 129, 0.5), inset 0 2px 4px rgba(0, 0, 0, 0.4);
        transform: translateY(-4px) scale(1.04);
    }

    .otp-box.filled {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.12);
        box-shadow: 0 0 15px rgba(16, 185, 129, 0.3);
    }

    .otp-timer-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-bottom: 26px;
    }

    .timer-ring-wrapper {
        position: relative;
        width: 36px;
        height: 36px;
    }

    .timer-ring-svg {
        transform: rotate(-90deg);
        width: 36px;
        height: 36px;
    }

    .timer-ring-bg {
        stroke: #1e293b;
        stroke-width: 3;
        fill: none;
    }

    .timer-ring-progress {
        stroke: #10b981;
        stroke-width: 3;
        stroke-dasharray: 100;
        stroke-dashoffset: 0;
        stroke-linecap: round;
        fill: none;
        transition: stroke-dashoffset 1s linear;
    }

    .timer-text {
        font-size: 0.9rem;
        color: #94a3b8;
        font-weight: 500;
    }

    .timer-seconds {
        font-weight: 800;
        color: #10b981;
        font-family: monospace;
        font-size: 1rem;
    }

    .btn-verify-submit {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: #ffffff;
        border: none;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.35);
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-verify-submit:hover {
        background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.45);
    }

    .btn-resend-link {
        background: none;
        border: none;
        color: #10b981;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        padding: 0;
        margin-left: 4px;
    }

    .btn-resend-link:hover:not(:disabled) {
        color: #34d399;
        text-decoration: underline;
    }

    .btn-resend-link:disabled {
        color: #64748b;
        cursor: not-allowed;
        opacity: 0.6;
    }

    @keyframes spinRing {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes pulseGlow {
        0%, 100% { transform: scale(0.95); opacity: 0.5; }
        50% { transform: scale(1.15); opacity: 0.15; }
    }

    @keyframes floatingLock {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    .shake-card {
        animation: cardShake 0.5s ease-in-out;
    }

    @keyframes cardShake {
        0%, 100% { transform: translateX(0); }
        20%, 60% { transform: translateX(-10px); }
        40%, 80% { transform: translateX(10px); }
    }
</style>
@endpush

@section('content')
<div class="otp-wrapper">
    <div class="otp-card {{ $errors->any() ? 'shake-card' : '' }}">
        
        <!-- Animated Security Badge -->
        <div class="otp-badge-container">
            <div class="otp-pulse-ring-1"></div>
            <div class="otp-pulse-ring-2"></div>
            <div class="otp-badge-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
            </div>
        </div>

        <h1 class="otp-title">Verify Email Address</h1>
        <p class="otp-subtitle">
            Enter the 6-digit confirmation code sent to:<br>
            <span class="otp-email-highlight">{{ $email }}</span>
        </p>

        @if(session('status'))
            <div style="background: rgba(16, 185, 129, 0.12); border: 1px solid #10b981; color: #34d399; padding: 12px 16px; border-radius: 10px; margin-bottom: 22px; font-size: 0.88rem; font-weight: 500;">
                ✓ {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: rgba(239, 68, 68, 0.12); border: 1px solid #ef4444; color: #f87171; padding: 12px 16px; border-radius: 10px; margin-bottom: 22px; font-size: 0.88rem; font-weight: 500;">
                @foreach($errors->all() as $error)
                    <div>⚠️ {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Email OTP Verification Form -->
        <form action="{{ route('verification.verify') }}" method="POST" id="otp-form">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="otp" id="otp-full-input" value="">

            <div class="otp-boxes-grid">
                <input type="text" maxlength="1" class="otp-box" data-index="0" autofocus placeholder="•" autocomplete="off">
                <input type="text" maxlength="1" class="otp-box" data-index="1" placeholder="•" autocomplete="off">
                <input type="text" maxlength="1" class="otp-box" data-index="2" placeholder="•" autocomplete="off">
                <input type="text" maxlength="1" class="otp-box" data-index="3" placeholder="•" autocomplete="off">
                <input type="text" maxlength="1" class="otp-box" data-index="4" placeholder="•" autocomplete="off">
                <input type="text" maxlength="1" class="otp-box" data-index="5" placeholder="•" autocomplete="off">
            </div>

            <!-- Countdown Timer Indicator -->
            <div class="otp-timer-container">
                <div class="timer-ring-wrapper">
                    <svg class="timer-ring-svg" viewBox="0 0 36 36">
                        <path class="timer-ring-bg" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <path class="timer-ring-progress" id="timer-progress" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    </svg>
                </div>
                <div class="timer-text">
                    Code expires in <span class="timer-seconds" id="timer-display">60s</span>
                </div>
            </div>

            <button type="submit" id="btn-submit-otp" class="btn-verify-submit">
                <span>Confirm & Activate Account</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </button>
        </form>

        <!-- Resend Section -->
        <div style="margin-top: 28px; font-size: 0.9rem; color: #94a3b8;">
            Didn't receive the verification code?
            <form action="{{ route('verification.resend') }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <button type="submit" id="resend-btn" class="btn-resend-link" disabled>
                    Resend Code
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const boxes = document.querySelectorAll('.otp-box');
        const fullInput = document.getElementById('otp-full-input');
        const form = document.getElementById('otp-form');
        const resendBtn = document.getElementById('resend-btn');
        const timerDisplay = document.getElementById('timer-display');
        const timerProgress = document.getElementById('timer-progress');
        const card = document.querySelector('.otp-card');

        boxes.forEach((box, index) => {
            box.addEventListener('input', (e) => {
                const val = e.target.value;
                if (val.length > 0) {
                    box.classList.add('filled');
                    if (index < boxes.length - 1) {
                        boxes[index + 1].focus();
                    }
                } else {
                    box.classList.remove('filled');
                }
                updateFullOtp();

                if (fullInput.value.length === 6) {
                    setTimeout(() => form.dispatchEvent(new Event('submit')), 150);
                }
            });

            box.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !box.value && index > 0) {
                    boxes[index - 1].focus();
                }
            });

            box.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasteData = (e.clipboardData || window.clipboardData).getData('text').trim();
                if (/^\d{6}$/.test(pasteData)) {
                    pasteData.split('').forEach((char, i) => {
                        if (boxes[i]) {
                            boxes[i].value = char;
                            boxes[i].classList.add('filled');
                        }
                    });
                    boxes[5].focus();
                    updateFullOtp();
                    setTimeout(() => form.dispatchEvent(new Event('submit')), 150);
                }
            });
        });

        function updateFullOtp() {
            let code = '';
            boxes.forEach(box => code += box.value);
            fullInput.value = code;
        }

        form.addEventListener('submit', (e) => {
            updateFullOtp();
            if (fullInput.value.length !== 6) {
                e.preventDefault();
                card.classList.remove('shake-card');
                void card.offsetWidth;
                card.classList.add('shake-card');
            }
        });

        const totalSeconds = 60;
        let timeLeft = totalSeconds;

        const timerInterval = setInterval(() => {
            timeLeft--;
            const progress = (timeLeft / totalSeconds) * 100;
            timerProgress.style.strokeDashoffset = (100 - progress);

            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                timerDisplay.textContent = 'Expired';
                timerDisplay.style.color = '#ef4444';
                timerProgress.style.stroke = '#ef4444';
                resendBtn.removeAttribute('disabled');
            } else {
                timerDisplay.textContent = timeLeft + 's';
            }
        }, 1000);
    });
</script>
@endpush
@endsection
