@extends('layouts.app')
@section('title', 'Disease Check')

@push('styles')
<style>
    .dashboard-wrap {
        display: grid;
        grid-template-columns: 220px 1fr;
        min-height: calc(100vh - 100px);
    }
    .sidebar {
        background: #1a5c2e; padding: 24px 0;
        position: sticky; top: 60px;
        height: calc(100vh - 60px); overflow-y: auto;
    }
    .sidebar-user {
        padding: 0 20px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        margin-bottom: 12px;
    }
    .sidebar-avatar {
        width: 48px; height: 48px; background: #6fdc9e;
        border-radius: 50%; display: flex; align-items: center;
        justify-content: center; font-size: 18px; font-weight: 700;
        color: #0a3318; margin-bottom: 10px;
    }
    .sidebar-name { color: #fff; font-weight: 600; font-size: 14px; }
    .sidebar-role { color: #6fdc9e; font-size: 12px; margin-top: 2px; }
    .sidebar-section {
        font-size: 10px; color: #6fdc9e; letter-spacing: 1px;
        text-transform: uppercase; padding: 14px 20px 6px;
    }
    .sidebar-link {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 20px; color: #a5d6b0; font-size: 13px;
        border-left: 3px solid transparent; transition: all 0.2s;
    }
    .sidebar-link:hover { background: rgba(255,255,255,0.08); color: #fff; }
    .sidebar-link.active {
        background: rgba(255,255,255,0.12); color: #fff;
        border-left-color: #6fdc9e; font-weight: 500;
    }

    .main-content { padding: 28px; background: #f4f6f4; }
    .page-title { font-size: 22px; font-weight: 700; color: #1a2e1e; margin-bottom: 4px; }
    .page-sub   { font-size: 13px; color: #666; margin-bottom: 24px; }

    .diag-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .card {
        background: #fff; border-radius: 12px; padding: 20px;
        border: 1px solid #e0e8e2;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .card-title {
        font-size: 15px; font-weight: 600; color: #1a2e1e;
        margin-bottom: 16px;
    }

    /* UPLOAD */
    .upload-zone {
        border: 2px dashed #a5d6b0;
        border-radius: 12px;
        padding: 32px 20px;
        text-align: center;
        background: #f8fdf9;
        cursor: pointer;
        transition: all 0.2s;
        margin-bottom: 14px;
    }
    .upload-zone:hover { border-color: #1a5c2e; background: #f0fbf4; }
    .upload-zone.dragover { border-color: #1a5c2e; background: #e8f5e9; }
    .upload-icon { font-size: 48px; display: block; margin-bottom: 12px; }
    .upload-text  { font-size: 14px; color: #3a7d4e; font-weight: 500; margin-bottom: 4px; }
    .upload-sub   { font-size: 12px; color: #888; }
    #imagePreview {
        max-width: 100%; border-radius: 8px;
        margin-top: 12px; display: none;
        border: 1px solid #e0e8e2;
    }
    .upload-btns {
        display: grid; grid-template-columns: 1fr 1fr; gap: 10px;
    }
    .btn-primary {
        background: #1a5c2e; color: #fff;
        padding: 11px; border-radius: 8px;
        font-size: 14px; font-weight: 600;
        border: none; cursor: pointer;
        transition: background 0.2s;
    }
    .btn-primary:hover { background: #144a24; }
    .btn-outline {
        background: transparent; color: #1a5c2e;
        padding: 11px; border-radius: 8px;
        font-size: 14px; font-weight: 600;
        border: 2px solid #1a5c2e; cursor: pointer;
        transition: all 0.2s;
    }
    .btn-outline:hover { background: #1a5c2e; color: #fff; }
    .btn-full {
        width: 100%; margin-top: 14px;
        background: #1a5c2e; color: #fff;
        padding: 13px; border-radius: 8px;
        font-size: 15px; font-weight: 700;
        border: none; cursor: pointer;
        transition: background 0.2s;
    }
    .btn-full:hover { background: #144a24; }

    /* HISTORY */
    .hist-item {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 0; border-bottom: 1px solid #f0f4f1;
    }
    .hist-item:last-child { border-bottom: none; }
    .hist-icon {
        width: 40px; height: 40px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; flex-shrink: 0;
    }
    .hist-name { font-size: 13px; font-weight: 500; color: #1a2e1e; }
    .hist-meta { font-size: 12px; color: #666; margin-top: 2px; }
    .badge {
        font-size: 11px; padding: 3px 10px;
        border-radius: 20px; font-weight: 500;
    }
    .badge-high    { background: #fce4ec; color: #993556; }
    .badge-medium  { background: #fff3e0; color: #854f0b; }
    .badge-low     { background: #e8f5e9; color: #1a5c2e; }
    .badge-healthy { background: #e8f5e9; color: #1a5c2e; }
    .btn-sm {
        font-size: 12px; padding: 5px 12px;
        border-radius: 6px; border: 1px solid #d0ddd4;
        color: #555; background: #f4f6f4; cursor: pointer;
    }
    .btn-sm:hover { border-color: #1a5c2e; color: #1a5c2e; }

    .tips-box {
        background: #e8f5e9;
        border-radius: 10px;
        padding: 16px;
        margin-top: 16px;
        border: 1px solid #a5d6b0;
    }
    .tips-box h4 { font-size: 13px; font-weight: 600; color: #1a5c2e; margin-bottom: 8px; }
    .tips-box li { font-size: 12px; color: #3a7d4e; margin-bottom: 4px; margin-left: 16px; }
</style>
@endpush

@section('content')
<div class="dashboard-wrap">
    <aside class="sidebar">
        <div class="sidebar-user">
            <div class="sidebar-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div class="sidebar-name">{{ auth()->user()->name }}</div>
            <div class="sidebar-role">🌾 Farmer</div>
        </div>
        <div class="sidebar-section">Main</div>
        <a href="{{ route('farmer.dashboard') }}" class="sidebar-link">📊 Dashboard</a>
        <div class="sidebar-section">Paddy Care</div>
        <a href="{{ route('farmer.diagnosis') }}" class="sidebar-link active">📷 Disease Check</a>
        <a href="{{ route('farmer.seeds') }}" class="sidebar-link">🌱 Seed Guide</a>
        <a href="{{ route('farmer.crops') }}" class="sidebar-link">🌾 Harvest Tracker</a>
        <div class="sidebar-section">Appointments</div>
        <a href="{{ route('farmer.appointments.create') }}" class="sidebar-link">📅 Book Appointment</a>
        <a href="{{ route('farmer.appointments') }}" class="sidebar-link">🗓 My Appointments</a>
        <div class="sidebar-section">Info</div>
        <a href="{{ route('articles') }}" class="sidebar-link">📖 Articles</a>
        <form method="POST" action="{{ route('logout') }}" style="margin-top:20px;">
            @csrf
            <button type="submit" class="sidebar-link"
                style="width:100%; background:none; border:none; cursor:pointer; text-align:left;">
                🚪 Logout
            </button>
        </form>
    </aside>

    <main class="main-content">
        <div class="page-title">📷 Disease Check</div>
        <div class="page-sub">Upload a paddy leaf photo for instant AI diagnosis</div>

        <div class="diag-grid">
            <!-- UPLOAD FORM -->
            <div class="card">
                <div class="card-title">🌿 Upload Leaf Image</div>
                <form method="POST" action="{{ route('farmer.diagnosis.store') }}"
                      enctype="multipart/form-data" id="diagForm">
                    @csrf
                    <div class="upload-zone" id="dropZone"
                         onclick="document.getElementById('imageInput').click()">
                        <span class="upload-icon">📤</span>
                        <div class="upload-text">Click or drag & drop leaf image here</div>
                        <div class="upload-sub">JPG, PNG — Max 5MB</div>
                        <img id="imagePreview" src="" alt="Preview">
                    </div>
                    <input type="file" name="image" id="imageInput"
                           accept="image/*" style="display:none;" required>

                    <div class="upload-btns">
                        <button type="button" class="btn-outline"
                                onclick="document.getElementById('imageInput').click()">
                            📁 Browse File
                        </button>
                        <button type="button" class="btn-outline"
                                onclick="document.getElementById('imageInput').click()">
                            📷 Camera
                        </button>
                    </div>
                    <button type="submit" class="btn-full" id="submitBtn">
                        🔬 Analyze with AI
                    </button>
                </form>

                <div class="tips-box">
                    <h4>📋 Tips for Best Results:</h4>
                    <ul>
                        <li>Use clear, well-lit photos</li>
                        <li>Focus on the affected leaf area</li>
                        <li>Avoid blurry or dark images</li>
                        <li>One leaf per image works best</li>
                    </ul>
                </div>
            </div>

            <!-- HISTORY -->
            <div class="card">
                <div class="card-title">🕐 Previous Diagnoses</div>
                @forelse($diagnoses as $d)
                    <div class="hist-item">
                        <div class="hist-icon"
                             style="background:{{ $d->disease ? '#fce4ec' : '#e8f5e9' }}">
                            {{ $d->disease ? '🦠' : '✅' }}
                        </div>
                        <div style="flex:1;">
                            <div class="hist-name">
                                {{ $d->disease ? $d->disease->name : 'Healthy Leaf' }}
                            </div>
                            <div class="hist-meta">
                                {{ $d->confidence ? number_format($d->confidence,0).'%' : '—' }}
                                · {{ $d->created_at->format('M d, Y') }}
                            </div>
                        </div>
                        <span class="badge badge-{{ $d->disease ? $d->disease->severity_level : 'healthy' }}">
                            {{ $d->disease ? ucfirst($d->disease->severity_level) : 'Healthy' }}
                        </span>
                        <a href="{{ route('farmer.diagnosis.show', $d->id) }}">
                            <button class="btn-sm" style="margin-left:6px;">View</button>
                        </a>
                    </div>
                @empty
                    <div style="text-align:center; padding:32px; color:#888; font-size:13px;">
                        📷 No diagnoses yet.<br>Upload your first image!
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
    const input   = document.getElementById('imageInput');
    const preview = document.getElementById('imagePreview');
    const dropZone= document.getElementById('dropZone');

    input.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    dropZone.addEventListener('dragover', e => {
        e.preventDefault();
        dropZone.classList.add('dragover');
    });
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;
            const reader = new FileReader();
            reader.onload = ev => {
                preview.src = ev.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('diagForm').addEventListener('submit', function() {
        document.getElementById('submitBtn').textContent = '⏳ Analyzing...';
        document.getElementById('submitBtn').disabled = true;
    });
</script>
@endpush