@extends('layouts.app')
@section('title', 'Diagnosis Result')

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

    .result-grid {
        display: grid;
        grid-template-columns: 1fr 1.4fr;
        gap: 20px;
    }
    .card {
        background: #fff; border-radius: 12px; padding: 20px;
        border: 1px solid #e0e8e2;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        margin-bottom: 20px;
    }
    .card-title {
        font-size: 15px; font-weight: 600; color: #1a2e1e;
        margin-bottom: 16px; padding-bottom: 12px;
        border-bottom: 1px solid #f0f4f1;
    }

    .leaf-image {
        width: 100%; border-radius: 10px;
        border: 1px solid #e0e8e2;
        max-height: 280px; object-fit: cover;
    }
    .img-meta {
        display: flex; justify-content: space-between;
        margin-top: 12px; font-size: 12px; color: #666;
    }

    .result-header {
        display: flex; align-items: center; gap: 16px;
        padding: 16px; border-radius: 10px;
        margin-bottom: 16px;
    }
    .result-header.disease { background: #fce4ec; border: 1px solid #f4c0d1; }
    .result-header.healthy { background: #e8f5e9; border: 1px solid #a5d6b0; }
    .result-icon { font-size: 40px; }
    .result-disease-name { font-size: 20px; font-weight: 700; }
    .result-scientific  { font-size: 13px; color: #666; font-style: italic; margin-top: 2px; }

    .conf-bar-wrap { margin-top: 8px; }
    .conf-bar-bg {
        height: 10px; background: rgba(0,0,0,0.1);
        border-radius: 20px; overflow: hidden;
    }
    .conf-bar-fill { height: 10px; border-radius: 20px; transition: width 1s ease; }
    .conf-label {
        display: flex; justify-content: space-between;
        font-size: 11px; margin-top: 4px; color: #555;
    }

    .severity-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 14px; border-radius: 20px;
        font-size: 13px; font-weight: 600; margin-top: 10px;
    }
    .sev-high   { background: #fce4ec; color: #993556; }
    .sev-medium { background: #fff3e0; color: #854f0b; }
    .sev-low    { background: #e8f5e9; color: #1a5c2e; }

    .treatment-section { margin-bottom: 16px; }
    .treatment-title {
        font-size: 13px; font-weight: 600; color: #1a2e1e;
        margin-bottom: 10px; display: flex; align-items: center; gap: 8px;
    }
    .treatment-box {
        background: #f8fdf9; border-radius: 8px;
        padding: 14px; border: 1px solid #c8e6c9;
        font-size: 13px; color: #2d5a3d; line-height: 1.7;
    }
    .treatment-box.chemical {
        background: #fff9f0; border-color: #ffd08a; color: #5c3a00;
    }
    .ipm-box {
        background: #e8f5e9; border-radius: 8px;
        padding: 14px; border-left: 4px solid #1a5c2e;
        font-size: 13px; color: #1a5c2e; line-height: 1.7;
    }

    /* REQUEST ADVICE SECTION */
    .advice-box {
        border-radius: 10px; padding: 16px 20px;
        margin-bottom: 16px; border: 1px solid;
    }
    .advice-box.pending {
        background: #fff3e0; border-color: #f5c97a;
    }
    .advice-box.requested {
        background: #e6f1fb; border-color: #90caf9;
    }
    .advice-box.received {
        background: #e8f5e9; border-color: #a5d6b0;
    }
    .advice-box-title {
        font-size: 14px; font-weight: 600; margin-bottom: 8px;
    }
    .advice-box.pending .advice-box-title   { color: #854f0b; }
    .advice-box.requested .advice-box-title { color: #185fa5; }
    .advice-box.received .advice-box-title  { color: #1a5c2e; }
    .advice-box-text {
        font-size: 13px; line-height: 1.7;
    }
    .advice-box.pending .advice-box-text   { color: #5c3a00; }
    .advice-box.requested .advice-box-text { color: #0c447c; }
    .advice-box.received .advice-box-text  { color: #2d5a3d; }

    .btn-request-advice {
        background: #854f0b; color: #fff;
        padding: 10px 22px; border-radius: 8px;
        font-size: 13px; font-weight: 600;
        border: none; cursor: pointer;
        transition: all 0.2s; margin-top: 10px;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-request-advice:hover { background: #6b3f09; transform: translateY(-1px); }

    .action-row {
        display: flex; gap: 10px; flex-wrap: wrap; margin-top: 16px;
    }
    .btn-primary {
        background: #1a5c2e; color: #fff;
        padding: 10px 20px; border-radius: 8px;
        font-size: 13px; font-weight: 600; border: none;
        cursor: pointer; transition: background 0.2s;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-primary:hover { background: #144a24; }
    .btn-outline {
        background: transparent; color: #1a5c2e;
        padding: 10px 20px; border-radius: 8px;
        font-size: 13px; font-weight: 600;
        border: 2px solid #1a5c2e; cursor: pointer;
        transition: all 0.2s;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-outline:hover { background: #1a5c2e; color: #fff; }

    .officer-note {
        background: #e6f1fb; border-radius: 8px;
        padding: 14px; border-left: 4px solid #185fa5;
        font-size: 13px; color: #0c447c; line-height: 1.7;
        margin-top: 14px;
    }
    .officer-note strong { display: block; margin-bottom: 4px; }

    .disclaimer {
        background: #f8f9fa; border-radius: 8px;
        padding: 12px 14px; font-size: 12px;
        color: #666; margin-top: 14px;
        border: 1px solid #e0e0e0;
    }
</style>
@endpush

@section('content')
<div class="dashboard-wrap">
    <aside class="sidebar">
        <div class="sidebar-user">
            <div class="sidebar-avatar">{{ strtoupper(substr(auth()->user()->name,0,2)) }}</div>
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
                style="width:100%;background:none;border:none;cursor:pointer;text-align:left;">
                🚪 Logout
            </button>
        </form>
    </aside>

    <main class="main-content">
        <div class="page-title">🔬 Diagnosis Result</div>
        <div class="page-sub">
            AI analysis completed · {{ $diagnosis->created_at->format('F j, Y — h:i A') }}
        </div>

        <div class="result-grid">
            <!-- LEFT: Image + Advice Section -->
            <div>
                <div class="card">
                    <div class="card-title">📸 Uploaded Image</div>
                    <img src="{{ asset('storage/'.$diagnosis->image_path) }}"
                         alt="Leaf" class="leaf-image">
                    <div class="img-meta">
                        <span>📅 {{ $diagnosis->created_at->format('M d, Y') }}</span>
                        <span>Status: <strong>{{ ucfirst($diagnosis->status) }}</strong></span>
                    </div>
                </div>

                <!-- ===== EXPERT ADVICE SECTION ===== -->
                @if($diagnosis->officer_note)
                    {{-- Officer already sent advice --}}
                    <div class="advice-box received">
                        <div class="advice-box-title">👮 Expert Advice Received!</div>
                        <div class="advice-box-text">
                            {{ $diagnosis->officer_note }}
                        </div>
                    </div>

                @elseif($diagnosis->advice_requested)
                    {{-- Advice requested, waiting --}}
                    <div class="advice-box requested">
                        <div class="advice-box-title">⏳ Advice Request Sent!</div>
                        <div class="advice-box-text">
                            Your request has been sent to a field officer.
                            They will review your diagnosis and send expert advice soon.
                            Please check back later.
                        </div>
                    </div>

                @else
                    {{-- Not yet requested --}}
                    @if($diagnosis->disease)
                    <div class="advice-box pending">
                        <div class="advice-box-title">🙋 Need Expert Advice?</div>
                        <div class="advice-box-text">
                            Not sure about the AI result? Request a review from
                            an agricultural field officer for expert guidance.
                        </div>
                        <form method="POST"
                              action="{{ route('farmer.diagnosis.request-advice', $diagnosis->id) }}">
                            @csrf
                            <button type="submit" class="btn-request-advice"
                                    onclick="return confirm('Request expert advice for this diagnosis?')">
                                🙋 Request Expert Advice
                            </button>
                        </form>
                    </div>
                    @endif
                @endif

                <div class="action-row">
                    <a href="{{ route('farmer.appointments.create') }}">
                        <button class="btn-primary">📅 Book Officer Visit</button>
                    </a>
                    <a href="{{ route('farmer.diagnosis') }}">
                        <button class="btn-outline">📷 New Scan</button>
                    </a>
                </div>
            </div>

            <!-- RIGHT: Result -->
            <div>
                @if($diagnosis->disease)
                    <div class="card">
                        <div class="result-header disease">
                            <div class="result-icon">🦠</div>
                            <div style="flex:1;">
                                <div class="result-disease-name" style="color:#4a1528;">
                                    {{ $diagnosis->disease->name }}
                                </div>
                                @if($diagnosis->disease->scientific_name)
                                    <div class="result-scientific">
                                        {{ $diagnosis->disease->scientific_name }}
                                    </div>
                                @endif
                                @if($diagnosis->confidence)
                                    <div class="conf-bar-wrap">
                                        <div class="conf-bar-bg">
                                            <div class="conf-bar-fill"
                                                 style="width:{{ $diagnosis->confidence }}%;
                                                        background:#993556;">
                                            </div>
                                        </div>
                                        <div class="conf-label">
                                            <span>AI Confidence</span>
                                            <span>{{ number_format($diagnosis->confidence,1) }}%</span>
                                        </div>
                                    </div>
                                @endif
                                <span class="severity-badge sev-{{ $diagnosis->disease->severity_level ?? 'medium' }}">
                                    {{ ($diagnosis->disease->severity_level ?? '') === 'high' ? '🔴' : (($diagnosis->disease->severity_level ?? '') === 'medium' ? '🟡' : '🟢') }}
                                    {{ ucfirst($diagnosis->disease->severity_level ?? 'Medium') }} Risk
                                </span>
                            </div>
                        </div>

                        <div class="treatment-section">
                            <div class="treatment-title">📋 About This Disease</div>
                            <div class="treatment-box">
                                {{ $diagnosis->disease->description }}
                            </div>
                        </div>

                        <div class="treatment-section">
                            <div class="treatment-title">🧪 Chemical Treatment</div>
                            <div class="treatment-box chemical">
                                {{ $diagnosis->disease->chemical_treatment }}
                            </div>
                        </div>

                        <div class="treatment-section">
                            <div class="treatment-title">🌿 Organic / Natural Treatment</div>
                            <div class="treatment-box">
                                {{ $diagnosis->disease->organic_treatment }}
                            </div>
                        </div>

                        <div class="treatment-section">
                            <div class="treatment-title">♻️ IPM Advice</div>
                            <div class="ipm-box">
                                {{ $diagnosis->disease->ipm_advice }}
                            </div>
                        </div>

                        <div class="disclaimer">
                            ⚠️ <strong>Disclaimer:</strong> AI results are for advisory purposes only.
                            Please consult a Field Officer before applying any treatments.
                        </div>
                    </div>

                @else
                    <div class="card">
                        <div class="result-header healthy">
                            <div class="result-icon">✅</div>
                            <div>
                                <div class="result-disease-name" style="color:#1a5c2e;">
                                    Healthy Leaf Detected!
                                </div>
                                <div class="result-scientific">
                                    No disease or pest detected
                                </div>
                                @if($diagnosis->confidence)
                                    <div class="conf-bar-wrap">
                                        <div class="conf-bar-bg">
                                            <div class="conf-bar-fill"
                                                 style="width:{{ $diagnosis->confidence }}%;
                                                        background:#1a5c2e;">
                                            </div>
                                        </div>
                                        <div class="conf-label">
                                            <span>AI Confidence</span>
                                            <span>{{ number_format($diagnosis->confidence,1) }}%</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="ipm-box">
                            🌾 Your paddy leaf looks healthy! Continue good farming practices —
                            regular monitoring, proper irrigation, and balanced fertilizer application.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>
@endsection