@extends('backend.layouts.app')

@section('title', 'Live Match Control Engine | Handball System')

@section('content')
<!-- TOP BROADCAST HEADER -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-white font-weight-bold">
            <i class="fas fa-broadcast-tower text-danger mr-2 animate-pulse"></i>Live Match Control Engine
        </h1>
        <p class="text-muted small mb-0 mt-1">Real-time handball match controller and live score broadcast center</p>
    </div>
    <div class="d-flex align-items-center">
        <span class="badge badge-danger badge-pill px-3 py-2 animate-pulse shadow-sm" style="background: rgba(239, 68, 68, 0.15) !important; color: #f87171 !important; border: 1px solid rgba(239, 68, 68, 0.3) !important; font-size: 12px;">
            <i class="fas fa-circle text-danger mr-1.5" style="font-size: 8px;"></i> MATCH IS LIVE <i class="fas fa-wifi ml-1 text-danger"></i>
        </span>
    </div>
</div>

<!-- MAIN ARENA CARD (HANDBALL HUB THEME MATCHING SCREENSHOT) -->
<div class="card shadow-lg mb-4 border-0" style="background: #0e1626; border-radius: 20px; overflow: hidden; border: 1px solid #1e293b;">
    
    <!-- Header with 2nd Half • Cairo Hall Pill on Right -->
    <div class="px-4 py-3 d-flex justify-content-end align-items-center" style="background: #162238; border-bottom: 1px solid #1e293b;">
        <span class="badge px-3 py-1.5 font-weight-bold text-white shadow-sm" style="background: #1e293b; border: 1px solid #334155; border-radius: 9999px; font-size: 12px;">
            2nd Half • Cairo Hall <i class="fas fa-trophy text-warning ml-1"></i>
        </span>
    </div>

    <div class="card-body p-4">
        <!-- SCORE CARDS ROW -->
        <div class="row align-items-center my-2">
            
            <!-- HOME TEAM (AL AHLY SC) -->
            <div class="col-lg-5 col-md-5 mb-3 mb-md-0">
                <div class="p-3 d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #7f1d1d 0%, #450a0a 100%); border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 14px; box-shadow: 0 8px 24px rgba(127, 29, 29, 0.35);">
                    <div class="d-flex align-items-center">
                        <div class="p-2 rounded-lg mr-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.15); flex-shrink: 0;">
                            <img src="{{ asset('backend/img/ahly.svg') }}" alt="Al Ahly SC Crest" style="width: 100%; height: 100%; object-fit: contain;">
                        </div>
                        <div>
                            <h4 class="font-weight-bold text-white mb-0" style="font-size: 20px; letter-spacing: -0.3px;">Al Ahly SC</h4>
                            <span style="color: #94a3b8; font-size: 13px; font-weight: 500;">Home Team • Egypt</span>
                        </div>
                    </div>
                    <div>
                        <span class="live-score-big text-white font-weight-bold" id="liveHomeScore" style="font-size: 38px; font-weight: 800; letter-spacing: -1px; text-shadow: 0 4px 12px rgba(0,0,0,0.6);">26</span>
                    </div>
                </div>
            </div>

            <!-- MATCH TIMER CENTER -->
            <div class="col-lg-2 col-md-2 text-center mb-3 mb-md-0">
                <div class="font-weight-bold text-white mb-1" id="matchTimer" style="font-size: 24px; letter-spacing: 1px; font-family: 'Inter', sans-serif;">48:15</div>
                <div>
                    <span class="badge px-3 py-1 font-weight-bold" style="background: #ea580c; color: #ffffff; border-radius: 9999px; font-size: 11.5px; box-shadow: 0 4px 12px rgba(234, 88, 12, 0.35);">2nd Half • Cairo Hall</span>
                </div>
            </div>

            <!-- AWAY TEAM (ZAMALEK SC) -->
            <div class="col-lg-5 col-md-5">
                <div class="p-3 d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #713f12 0%, #3f2205 100%); border: 1px solid rgba(234, 179, 8, 0.4); border-radius: 14px; box-shadow: 0 8px 24px rgba(113, 63, 18, 0.3);">
                    <div class="d-flex align-items-center">
                        <div class="p-2 rounded-lg mr-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.15); flex-shrink: 0;">
                            <img src="{{ asset('backend/img/zamalek.svg') }}" alt="Zamalek SC Crest" style="width: 100%; height: 100%; object-fit: contain;">
                        </div>
                        <div>
                            <h4 class="font-weight-bold text-white mb-0" style="font-size: 20px; letter-spacing: -0.3px;">Zamalek SC</h4>
                            <span style="color: #94a3b8; font-size: 13px; font-weight: 500;">Away Team • Egypt</span>
                        </div>
                    </div>
                    <div>
                        <span class="live-score-big text-white font-weight-bold" id="liveAwayScore" style="font-size: 38px; font-weight: 800; letter-spacing: -1px; text-shadow: 0 4px 12px rgba(0,0,0,0.6);">24</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- REAL-TIME MATCH ACTIONS CONTROLLER (ROUNDED PILLS CONTAINER) -->
        <div class="p-4 mt-4 position-relative" style="background: #070c14; border: 1px solid #1e293b; border-radius: 16px;">
            <div class="text-center mb-4">
                <span class="font-weight-bold text-white small" style="letter-spacing: 0.5px; font-size: 13px;">
                    <i class="fas fa-gamepad mr-1.5" style="color: #ea580c;"></i> Real-time Match Actions
                </span>
            </div>

            <div class="row align-items-center justify-content-center">
                <!-- Ahly Score Controller (Pill style) -->
                <div class="col-md-5 mb-3 mb-md-0">
                    <div class="btn-group w-100 shadow-sm" role="group">
                        <button class="btn font-weight-bold py-2 px-3 text-white" data-score-btn="liveHomeScore" data-action="plus" style="background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%); border: 1px solid #ea580c; border-radius: 9999px 0 0 9999px; box-shadow: 0 4px 14px rgba(234, 88, 12, 0.4);">
                            <i class="fas fa-plus mr-1"></i> +1 Goal Ahly
                        </button>
                        <button class="btn py-2 px-3" data-score-btn="liveHomeScore" data-action="minus" style="border: 1px solid #ea580c; color: #f97316; border-radius: 0 9999px 9999px 0; background: #0e1626; font-weight: 700;">
                            <i class="fas fa-minus mr-1"></i> -1
                        </button>
                    </div>
                </div>

                <!-- Zamalek Score Controller (Pill style) -->
                <div class="col-md-5">
                    <div class="btn-group w-100 shadow-sm" role="group">
                        <button class="btn btn-danger font-weight-bold py-2 px-3" data-score-btn="liveAwayScore" data-action="plus" style="background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); border: 1px solid #ef4444; border-radius: 9999px 0 0 9999px; box-shadow: 0 4px 14px rgba(220, 38, 38, 0.4);">
                            <i class="fas fa-plus mr-1"></i> +1 Goal Zamalek
                        </button>
                        <button class="btn py-2 px-3" data-score-btn="liveAwayScore" data-action="minus" style="border: 1px solid #dc2626; color: #f87171; border-radius: 0 9999px 9999px 0; background: #0e1626; font-weight: 700;">
                            <i class="fas fa-minus mr-1"></i> -1
                        </button>
                    </div>
                </div>
            </div>

            <!-- ACTION PILLS BOTTOM ROW -->
            <div class="d-flex justify-content-center align-items-center gap-2 mt-4 flex-wrap">
                <button class="btn font-weight-bold rounded-pill px-4 py-2 mr-2 mb-2 mb-md-0 text-white shadow-sm" onclick="showHandballToast('Match Paused', 'Halftime break started');" style="background: linear-gradient(135deg, #d97706, #b45309); border: 1px solid #f59e0b; box-shadow: 0 4px 14px rgba(217, 119, 6, 0.35);">
                    <i class="fas fa-clock mr-1.5"></i> Halftime
                </button>
                <button class="btn font-weight-bold rounded-pill px-4 py-2 mr-2 mb-2 mb-md-0 text-white shadow-sm" onclick="showHandballToast('Match Finished', 'Match result saved to database!');" style="background: linear-gradient(135deg, #059669, #047857); border: 1px solid #10b981; box-shadow: 0 4px 14px rgba(5, 150, 105, 0.35);">
                    <i class="fas fa-flag-checkered mr-1.5"></i> Finish Match
                </button>
                <button class="btn font-weight-bold rounded-pill px-4 py-2 mb-2 mb-md-0 text-white shadow-sm" onclick="navigator.clipboard.writeText(window.location.href); showHandballToast('Link Copied', 'Live match broadcast link copied to clipboard!');" style="background: linear-gradient(135deg, #ea580c, #c2410c); border: 1px solid #f97316; box-shadow: 0 4px 14px rgba(234, 88, 12, 0.4);">
                    <i class="fas fa-share-alt mr-1.5"></i> Share Match
                </button>
            </div>

            <!-- Bottom Right Sparkle Accent (Matching Screenshot) -->
            <div class="position-absolute d-none d-md-block" style="right: 22px; bottom: 20px; opacity: 0.35; color: #ea580c; font-size: 22px;">
                ✦
            </div>
        </div>

    </div>
</div>
@endsection


