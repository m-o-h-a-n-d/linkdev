@extends('backend.layouts.app')

@section('title', 'Teams Directory | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-shield-alt text-primary mr-2"></i>Handball Teams Directory Table</h1>
    <div class="d-flex align-items-center" style="gap: 8px;">
        <a href="{{ route('admin.teams.create') }}" class="btn btn-success btn-sm shadow-sm font-weight-bold"><i class="fas fa-plus mr-1"></i> Register Team</a>
        <button type="button" class="btn btn-primary btn-sm shadow-sm font-weight-bold" onclick="copyPublicTeamRegistrationLink()" id="linkFormBtn">
            <i class="fas fa-link mr-1"></i> Link Form
        </button>
        <a href="{{ route('team-registration.public') }}" target="_blank" class="btn btn-outline-primary btn-sm shadow-sm font-weight-bold" title="Open Public Coach Registration Form">
            <i class="fas fa-external-link-alt mr-1"></i> Open Form
        </a>
    </div>
</div>

<!-- Success Alert for Link Copy -->
<div id="copySuccessAlert" class="alert alert-success alert-dismissible fade show d-none mb-4 shadow-sm" role="alert" style="border-radius: 12px; border-left: 5px solid #10b981;">
    <i class="fas fa-check-circle mr-2 text-success"></i> <strong>Public Registration Link Copied!</strong> Share this link with team coaches: <code id="copiedUrlText" class="bg-light px-2 py-1 rounded text-primary font-weight-bold ml-1"></code>
    <button type="button" class="close" onclick="document.getElementById('copySuccessAlert').classList.add('d-none')">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<!-- Teams Table -->
<div class="card mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-gray-800">Registered Clubs Table</h6>
        <span class="badge badge-primary font-weight-bold">32 Clubs Total</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Team Name & Crest</th>
                        <th>Short Code</th>
                        <th>City</th>
                        <th>Country</th>
                        <th>Active Competitions</th>
                        <th>Registered Date</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="team-crest-wrapper mr-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 12px; background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.3);">
                                    <img src="{{ asset('backend/img/ahly.svg') }}" alt="Al Ahly SC Logo" style="width: 32px; height: 32px; object-fit: contain; filter: drop-shadow(0 2px 8px rgba(239, 68, 68, 0.5));">
                                </div>
                                <div>
                                    <a href="{{ route('admin.teams.show') }}" class="font-weight-bold text-white h6 mb-0">Al Ahly SC</a>
                                    <div class="text-muted small mt-1">Al Ahly Handball Club</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-danger px-3 py-1" style="border-radius: 20px;">AHL</span></td>
                        <td class="font-weight-medium text-gray-300">Cairo</td>
                        <td><span class="badge badge-secondary px-3 py-1" style="border-radius: 20px;">Egypt</span></td>
                        <td><span class="badge font-weight-bold px-3 py-1" style="border-radius: 20px; background: #ea580c !important; color: #ffffff !important; font-size: 0.8rem; box-shadow: 0 2px 8px rgba(234, 88, 12, 0.35);">Egyptian Premier League</span></td>
                        <td class="text-muted small">Jan 15, 2025</td>
                        <td class="text-right">
                            <div class="d-inline-flex align-items-center" style="gap: 6px;">
                                <a class="btn btn-primary btn-sm rounded-lg font-weight-bold px-3" href="{{ route('admin.teams.show') }}" style="background: rgba(234, 88, 12, 0.15); color: #ea580c; border: 1px solid rgba(234, 88, 12, 0.3);"><i class="fas fa-chart-bar mr-1"></i> Profile</a>
                                <a class="btn btn-warning btn-sm rounded-lg font-weight-bold px-3" href="{{ route('admin.teams.edit') }}" style="background: rgba(234, 179, 8, 0.15); color: #eab308; border: 1px solid rgba(234, 179, 8, 0.3);"><i class="fas fa-edit mr-1"></i> Edit</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="team-crest-wrapper mr-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 12px; background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.2);">
                                    <img src="{{ asset('backend/img/zamalek.svg') }}" alt="Zamalek SC Logo" style="width: 32px; height: 32px; object-fit: contain; filter: drop-shadow(0 2px 8px rgba(255, 255, 255, 0.3));">
                                </div>
                                <div>
                                    <a href="{{ route('admin.teams.show') }}" class="font-weight-bold text-white h6 mb-0">Zamalek SC</a>
                                    <div class="text-muted small mt-1">Zamalek Handball Club</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-light px-3 py-1" style="border-radius: 20px; background: #ffffff !important; color: #0f172a !important;">ZAM</span></td>
                        <td class="font-weight-medium text-gray-300">Giza</td>
                        <td><span class="badge badge-secondary px-3 py-1" style="border-radius: 20px;">Egypt</span></td>
                        <td><span class="badge font-weight-bold px-3 py-1" style="border-radius: 20px; background: #ea580c !important; color: #ffffff !important; font-size: 0.8rem; box-shadow: 0 2px 8px rgba(234, 88, 12, 0.35);">Egyptian Premier League</span></td>
                        <td class="text-muted small">Feb 01, 2025</td>
                        <td class="text-right">
                            <div class="d-inline-flex align-items-center" style="gap: 6px;">
                                <a class="btn btn-primary btn-sm rounded-lg font-weight-bold px-3" href="{{ route('admin.teams.show') }}" style="background: rgba(234, 88, 12, 0.15); color: #ea580c; border: 1px solid rgba(234, 88, 12, 0.3);"><i class="fas fa-chart-bar mr-1"></i> Profile</a>
                                <a class="btn btn-warning btn-sm rounded-lg font-weight-bold px-3" href="{{ route('admin.teams.edit') }}" style="background: rgba(234, 179, 8, 0.15); color: #eab308; border: 1px solid rgba(234, 179, 8, 0.3);"><i class="fas fa-edit mr-1"></i> Edit</a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function copyPublicTeamRegistrationLink() {
        const publicFormUrl = "{{ route('team-registration.public') }}";
        const fullUrl = window.location.origin + publicFormUrl;

        navigator.clipboard.writeText(fullUrl).then(function() {
            const alertBox = document.getElementById('copySuccessAlert');
            const urlText = document.getElementById('copiedUrlText');
            if (urlText && alertBox) {
                urlText.innerText = fullUrl;
                alertBox.classList.remove('d-none');
            }
            const btn = document.getElementById('linkFormBtn');
            if (btn) {
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check mr-1"></i> Copied!';
                btn.classList.replace('btn-primary', 'btn-success');
                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                    btn.classList.replace('btn-success', 'btn-primary');
                }, 3000);
            }
        }).catch(function(err) {
            alert('Form Link: ' + window.location.origin + publicFormUrl);
        });
    }
</script>
@endpush
@endsection
