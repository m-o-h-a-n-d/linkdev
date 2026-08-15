@extends('backend.layouts.app')

@section('title', 'System Settings | Handball Hub')

@push('styles')
<style>
    .settings-hero-banner {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        border: 1px solid #334155;
        border-radius: 14px;
        padding: 24px 28px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    .settings-card {
        background: #0e1626 !important;
        border: 1px solid #1e293b !important;
        border-radius: 14px !important;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.35) !important;
    }

    .settings-section-heading {
        font-size: 1.1rem;
        font-weight: 700;
        color: #ffffff;
        padding-bottom: 12px;
        margin-bottom: 20px;
        border-bottom: 1px solid #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-group label {
        font-weight: 600;
        color: #e2e8f0;
        font-size: 0.9rem;
        margin-bottom: 6px;
    }

    .settings-input, .settings-textarea {
        background-color: #070c14 !important;
        border: 1px solid #334155 !important;
        color: #ffffff !important;
        border-radius: 8px !important;
        padding: 10px 14px !important;
        font-size: 0.92rem !important;
        transition: all 0.2s ease !important;
    }

    .settings-input:focus, .settings-textarea:focus {
        border-color: #ea580c !important;
        box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.2) !important;
        background-color: #070c14 !important;
        color: #ffffff !important;
    }

    .settings-input::placeholder, .settings-textarea::placeholder {
        color: #64748b !important;
    }

    /* Modern Dark Drag & Drop Area */
    .dropzone-box {
        border: 2px dashed #334155 !important;
        border-radius: 12px !important;
        padding: 24px 16px !important;
        text-align: center !important;
        background: rgba(15, 23, 42, 0.7) !important;
        cursor: pointer !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        position: relative !important;
        display: block !important;
    }

    .dropzone-box:hover, .dropzone-box.dragover {
        border-color: #ea580c !important;
        background: rgba(234, 88, 12, 0.1) !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(234, 88, 12, 0.2) !important;
    }

    .dropzone-icon-wrap {
        width: 52px;
        height: 52px;
        line-height: 52px;
        border-radius: 50%;
        background: rgba(30, 41, 59, 0.8);
        color: #ea580c;
        font-size: 1.4rem;
        margin: 0 auto 12px auto;
        transition: transform 0.2s ease, background 0.2s ease;
    }

    .dropzone-box:hover .dropzone-icon-wrap, .dropzone-box.dragover .dropzone-icon-wrap {
        transform: scale(1.1);
        background: #ea580c;
        color: #ffffff;
    }

    .dropzone-title {
        font-size: 0.95rem !important;
        font-weight: 700 !important;
        color: #ffffff !important;
        margin-bottom: 4px !important;
    }

    .dropzone-desc {
        font-size: 0.8rem !important;
        color: #94a3b8 !important;
        margin-bottom: 12px !important;
    }

    .preview-card {
        display: inline-block;
        background: #070c14;
        border: 1px solid #1e293b;
        border-radius: 10px;
        padding: 12px;
        margin-top: 8px;
        position: relative;
        box-shadow: 0 4px 12px rgba(0,0,0,0.4);
    }

    .preview-card img {
        max-height: 110px;
        max-width: 100%;
        border-radius: 6px;
        object-fit: contain;
        display: block;
        margin: 0 auto;
    }

    .preview-card.bracket-preview {
        display: block;
        width: 100%;
    }

    .preview-card.bracket-preview img {
        max-height: 240px;
        width: 100%;
        object-fit: cover;
    }

    .preview-badge {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        padding: 3px 10px;
        border-radius: 4px;
        background: rgba(234, 88, 12, 0.2);
        color: #ea580c;
        border: 1px solid rgba(234, 88, 12, 0.3);
        margin-bottom: 8px;
        display: inline-block;
    }

    .btn-remove-file {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #ef4444;
        color: #ffffff;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        font-size: 13px;
        font-weight: bold;
        line-height: 24px;
        cursor: pointer;
        display: none;
        text-align: center;
        box-shadow: 0 2px 6px rgba(0,0,0,0.6);
        transition: transform 0.15s;
    }

    .btn-remove-file:hover {
        transform: scale(1.15);
        background: #dc2626;
    }

    .submit-toolbar {
        background: #0e1626;
        border: 1px solid #1e293b;
        border-radius: 12px;
        padding: 16px 24px;
    }
</style>
@endpush

@section('content')
<!-- Header Banner -->
<div class="settings-hero-banner">
    <div>
        <h1 class="h4 mb-1 font-weight-bold text-white">
            <i class="fas fa-sliders-h mr-2 text-warning"></i>Table & System Settings
        </h1>
        <p class="mb-0 text-gray-400 small">
            Configure portal hero text, browser favicon, brand icon logo, and tournament match bracket diagram.
        </p>
    </div>
    <div>
        <a href="{{ url('/') }}" target="_blank" class="btn btn-sm btn-outline-warning font-weight-bold">
            <i class="fas fa-external-link-alt mr-1"></i> Preview Live Portal
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="background: rgba(16, 185, 129, 0.15); border-color: #10b981; color: #10b981;">
    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #10b981;">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="background: rgba(239, 68, 68, 0.15); border-color: #ef4444; color: #f87171;">
    <i class="fas fa-exclamation-triangle mr-1"></i> Please resolve the form errors below.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #f87171;">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- Left Column: Content & Texts -->
        <div class="col-lg-6 mb-4">
            <div class="card settings-card h-100">
                <div class="card-body p-4">
                    <div class="settings-section-heading">
                        <i class="fas fa-feather-alt text-warning"></i> Portal Texts & Season
                    </div>

                    <!-- 3. Session -->
                    <div class="form-group mb-4">
                        <label>
                            <i class="fas fa-calendar-check text-warning mr-1"></i> 3. Session / Season Label <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="session" 
                               class="form-control settings-input @error('session') is-invalid @enderror" 
                               value="{{ old('session', $settings->session) }}" 
                               placeholder="e.g. Season 2025/26" 
                               required>
                        <small class="form-text text-muted">Displayed as the top badge/pill in the homepage Hero Banner.</small>
                        @error('session')
                            <div class="text-danger small mt-1 font-weight-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- 4. Header -->
                    <div class="form-group mb-4">
                        <label>
                            <i class="fas fa-heading text-warning mr-1"></i> 4. Header (Hero Headline) <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="header" 
                               class="form-control settings-input @error('header') is-invalid @enderror" 
                               value="{{ old('header', $settings->header) }}" 
                               placeholder="e.g. Every throw, every save, every point." 
                               required>
                        <small class="form-text text-muted">Main headline banner title on the public homepage.</small>
                        @error('header')
                            <div class="text-danger small mt-1 font-weight-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- 5. Description -->
                    <div class="form-group mb-4">
                        <label>
                            <i class="fas fa-align-left text-warning mr-1"></i> 5. Description (Portal Subtitle)
                        </label>
                        <textarea name="description" 
                                  rows="4" 
                                  class="form-control settings-textarea @error('description') is-invalid @enderror" 
                                  placeholder="Provide the hero subtitle description...">{{ old('description', $settings->description) }}</textarea>
                        <small class="form-text text-muted">Subtext shown beneath the hero headline on the homepage and search engines meta description.</small>
                        @error('description')
                            <div class="text-danger small mt-1 font-weight-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="p-3 rounded border border-secondary" style="background: rgba(15, 23, 42, 0.6);">
                        <div class="text-white small font-weight-bold mb-1">
                            <i class="fas fa-cubes text-warning mr-1"></i> Clean Architecture & Patterns
                        </div>
                        <div class="text-gray-400 small">
                            All settings are strongly typed via <code>UpdateSettingData</code>, orchestrated through <code>SettingService</code>, persisted via <code>SettingRepository</code>, and audited in <code>ActivityLog</code>.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Media, Favicon, Icon & Matches Image (Drag & Drop) -->
        <div class="col-lg-6 mb-4">
            <div class="card settings-card h-100">
                <div class="card-body p-4">
                    <div class="settings-section-heading">
                        <i class="fas fa-photo-video text-warning"></i> Visual Branding & Media
                    </div>

                    <div class="row">
                        <!-- 1. Favicon Dropzone -->
                        <div class="col-md-6 mb-4">
                            <label class="d-block">
                                <i class="fas fa-star text-warning mr-1"></i> 1. Browser Favicon
                            </label>
                            
                            <div class="dropzone-box" id="dropzone-favicon" onclick="document.getElementById('file-favicon').click()">
                                <input type="file" name="favicon" id="file-favicon" class="d-none" accept=".ico,.png,.jpg,.jpeg,.svg,.webp">
                                <div class="dropzone-icon-wrap"><i class="fas fa-globe"></i></div>
                                <div class="dropzone-title">Drag & Drop Favicon</div>
                                <div class="dropzone-desc">ICO, PNG, SVG (Max 2MB)</div>

                                <div class="preview-card" id="preview-box-favicon">
                                    @if($settings->favicon)
                                        <div class="preview-badge">Current Favicon</div><br>
                                        <img src="{{ $settings->favicon_url }}" id="img-favicon" alt="Current Favicon">
                                    @else
                                        <div class="text-muted small py-2" id="empty-favicon"><i class="fas fa-image text-gray-500 mr-1"></i> Default Favicon</div>
                                        <img src="" id="img-favicon" alt="Favicon Preview" style="display:none;">
                                    @endif
                                    <button type="button" class="btn-remove-file" id="remove-favicon" title="Clear selection" style="display:none;">&times;</button>
                                </div>
                            </div>
                            @error('favicon')
                                <div class="text-danger small mt-1 font-weight-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 2. Site Icon / Logo Dropzone -->
                        <div class="col-md-6 mb-4">
                            <label class="d-block">
                                <i class="fas fa-shield-alt text-warning mr-1"></i> 2. Brand Icon / Logo
                            </label>
                            
                            <div class="dropzone-box" id="dropzone-icon" onclick="document.getElementById('file-icon').click()">
                                <input type="file" name="icon" id="file-icon" class="d-none" accept=".png,.jpg,.jpeg,.svg,.webp">
                                <div class="dropzone-icon-wrap"><i class="fas fa-volleyball-ball"></i></div>
                                <div class="dropzone-title">Drag & Drop Logo</div>
                                <div class="dropzone-desc">PNG, SVG, WEBP (Max 2MB)</div>

                                <div class="preview-card" id="preview-box-icon">
                                    @if($settings->icon)
                                        <div class="preview-badge">Current Logo</div><br>
                                        <img src="{{ $settings->icon_url }}" id="img-icon" alt="Current Logo">
                                    @else
                                        <div class="text-muted small py-2" id="empty-icon"><i class="fas fa-image text-gray-500 mr-1"></i> Default Logo (H)</div>
                                        <img src="" id="img-icon" alt="Icon Preview" style="display:none;">
                                    @endif
                                    <button type="button" class="btn-remove-file" id="remove-icon" title="Clear selection" style="display:none;">&times;</button>
                                </div>
                            </div>
                            @error('icon')
                                <div class="text-danger small mt-1 font-weight-bold">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- 6. Change Image Of Matches Dropzone -->
                    <div class="form-group mb-2">
                        <label class="d-block">
                            <i class="fas fa-project-diagram text-warning mr-1"></i> 6. Tournament Bracket / Matches Image
                        </label>
                        
                        <div class="dropzone-box" id="dropzone-matches-image" onclick="document.getElementById('file-matches-image').click()">
                            <input type="file" name="matches_image" id="file-matches-image" class="d-none" accept=".png,.jpg,.jpeg,.webp">
                            <div class="dropzone-icon-wrap"><i class="fas fa-cloud-upload-alt"></i></div>
                            <div class="dropzone-title">Drag & Drop Tournament Match Diagram</div>
                            <div class="dropzone-desc">Upload new bracket overview (PNG, JPG, WEBP - Max 5MB)</div>

                            <div class="preview-card bracket-preview" id="preview-box-matches-image">
                                <div class="preview-badge">Current Match Diagram</div><br>
                                <img src="{{ $settings->matches_image_url }}" id="img-matches-image" alt="Matches Image">
                                <button type="button" class="btn-remove-file" id="remove-matches-image" title="Clear selection" style="display:none;">&times;</button>
                            </div>
                        </div>
                        @error('matches_image')
                            <div class="text-danger small mt-1 font-weight-bold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Toolbar -->
    <div class="submit-toolbar shadow-sm d-flex align-items-center justify-content-between mb-5">
        <span class="text-gray-400 small">
            <i class="fas fa-shield-alt text-success mr-1"></i> Changes apply immediately to frontend and backend interfaces.
        </span>
        @can('settings.edit')
        <button type="submit" class="btn btn-warning font-weight-bold px-4 py-2 shadow-sm text-dark">
            <i class="fas fa-save mr-1"></i> Save System Settings
        </button>
        @endcan
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    /**
     * Reusable Drag and Drop Setup Helper
     */
    function initDropzone(dropzoneId, inputId, imgId, emptyId, removeBtnId, originalSrc) {
        const dropzone = document.getElementById(dropzoneId);
        const input = document.getElementById(inputId);
        const img = document.getElementById(imgId);
        const emptyState = emptyId ? document.getElementById(emptyId) : null;
        const removeBtn = document.getElementById(removeBtnId);

        if (!dropzone || !input || !img) return;

        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Highlight dropzone on drag enter/over
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, () => dropzone.classList.add('dragover'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, () => dropzone.classList.remove('dragover'), false);
        });

        // Handle dropped files
        dropzone.addEventListener('drop', function (e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files && files.length > 0) {
                input.files = files;
                handleFile(files[0]);
            }
        });

        // Handle browse select
        input.addEventListener('change', function () {
            if (this.files && this.files.length > 0) {
                handleFile(this.files[0]);
            }
        });

        function handleFile(file) {
            if (!file.type.startsWith('image/') && !file.name.endsWith('.ico')) {
                alert('Please upload a valid image file.');
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                img.src = e.target.result;
                img.style.display = 'block';
                if (emptyState) emptyState.style.display = 'none';
                if (removeBtn) removeBtn.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }

        // Handle remove button
        if (removeBtn) {
            removeBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                input.value = '';
                if (originalSrc) {
                    img.src = originalSrc;
                    img.style.display = 'block';
                    if (emptyState) emptyState.style.display = 'none';
                } else {
                    img.src = '';
                    img.style.display = 'none';
                    if (emptyState) emptyState.style.display = 'block';
                }
                removeBtn.style.display = 'none';
            });
        }
    }

    // Initialize all 3 dropzones
    initDropzone(
        'dropzone-favicon', 
        'file-favicon', 
        'img-favicon', 
        'empty-favicon', 
        'remove-favicon', 
        "{{ $settings->favicon_url ?? '' }}"
    );

    initDropzone(
        'dropzone-icon', 
        'file-icon', 
        'img-icon', 
        'empty-icon', 
        'remove-icon', 
        "{{ $settings->icon_url ?? '' }}"
    );

    initDropzone(
        'dropzone-matches-image', 
        'file-matches-image', 
        'img-matches-image', 
        null, 
        'remove-matches-image', 
        "{{ $settings->matches_image_url }}"
    );
});
</script>
@endpush
