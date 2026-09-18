@extends('layouts.app')
@section('title', 'Review Diagnosis')

@push('styles')
<style>
    .dashboard-wrap { display: grid; grid-template-columns: 220px 1fr; min-height: calc(100vh - 100px); }
    .sidebar { background: #1a5c2e; padding: 24px 0; position: sticky; top: 60px; height: calc(100vh - 60px); overflow-y: auto; }
    .sidebar-user { padding: 0 20px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 12px; }
    .sidebar-avatar { width: 48px; height: 48px; background: #6fdc9e; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; color: #0a3318; margin-bottom: 10px; }
    .sidebar-name { color: #fff; font-weight: 600; font-size: 14px; }
    .sidebar-role { color: #a5d6b0; font-size: 12px; }
    .sidebar-section { font-size: 10px; color: #6fdc9e; letter-spacing: 1px; text-transform: uppercase; padding: 14px 20px 6px; }
    .sidebar-link { display: flex; align-items: center; gap: 10px; padding: 10px 20px; color: #a5d6b0; font-size: 13px; border-left: 3px solid transparent; transition: all 0.2s; }
    .sidebar-link:hover { background: rgba(255,255,255,0.08); color: #fff; }
    .sidebar-link.active { background: rgba(255,255,255,0.12); color: #fff; border-left-color: #6fdc9e; font-weight: 500; }
    .main-content { padding: 28px; background: #f4f6f4; }
    .page-title { font-size: 22px; font-weight: 700; color: #1a2e1e; margin-bottom: 24px; }
    .review-grid { display: grid; grid-template-columns: 1fr 1.4fr; gap: 20px; }
    .card { background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #e0e8e2; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 16px; }
    .card-title { font-size: 15px; font-weight: 600; color: #1a2e1e; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid #f0f4f1; }
    .leaf-img { width: 100%; border-radius: 10px; border: 1px solid #e0e8e2; }
    .info-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f0f4f1; font-size: 13px; }
    .info-row:last-child { border-bottom: none; }
    .info-label { color: #666; }
    .info-value { font-weight: 500; color: #1a2e1e; }
    .disease-box { background: #fce4ec; border-radius: 10px; padding: 16px; border: 1px solid #f4c0d1; margin-bottom: 14px; }
    .disease-name { font-size: 18px; font-weight: 700; color: #4a1528; }
    .disease-sci  { font-size: 13px; color: #993556; font-style: italic; }
    .treatment-box { background: #f8fdf9; border-radius: 8px; padding: 14px; border: 1px solid #c8e6c9; font-size: 13px; color: #2d5a3d; line-height: 1.7; margin-bottom: 10px; }
    .form-group { margin-bottom: 14px; }
    .form-label { display: block; font-size: 13px; font-weight: 500; color: #333; margin-bottom: 6px; }
    .form-control { width: 100%; padding: 10px 14px; border: 1.5px solid #d0ddd4; border-radius: 8px; font-size: 13px; color: #1a1a1a; background: #f8fdf9; transition: border-color 0.2s; }
    .form-control:focus { outline: none; border-color: #1a5c2e; }
    .btn-blue { background: #1a5c2e; color: #fff; padding: 11px 24px; border-radius: 8px; font-size: 14px; font-weight: 600; border: none; cursor: pointer; }
    .btn-blue:hover { background: #144a24; }
    .existing-note { background: #e8f5e9; border-radius: 8px; padding: 14px; border-left: 4px solid #1a5c2e; font-size: 13px; color: #1a5c2e; line-height: 1.6; margin-bottom: 14px; }
</style>
@endpush

@section('content')
<div class="dashboard-wrap">
    <aside class="sidebar">
        <div class="sidebar-user">
            <div class="sidebar-avatar">{{ strtoupper(substr(auth()->user()->name,0,2)) }}</div>
            <div class="sidebar-name">{{ auth()->user()->name }}</div>
            <div class="sidebar-role">👮 Field Officer</div>
        </div>
        <div class="sidebar-section">Main</div>
        <a href="{{ route('officer.dashboard') }}" class="sidebar-link">📊 Dashboard</a>
        <div class="sidebar-section">Work</div>
        <a href="{{ route('officer.appointments') }}" class="sidebar-link">📅 Appointments</a>
        <a href="{{ route('officer.diagnoses') }}" class="sidebar-link active">🔬 Diagnoses</a>
        <div class="sidebar-section">Content</div>
        <a href="{{ route('officer.articles.index') }}" class="sidebar-link">📖 Articles</a>
        <div class="sidebar-section">Info</div>
        <a href="{{ route('articles') }}" class="sidebar-link">🌐 Public Articles</a>
        <form method="POST" action="{{ route('logout') }}" style="margin-top:20px;">
            @csrf
            <button type="submit" class="sidebar-link" style="width:100%;background:none;border:none;cursor:pointer;text-align:left;">🚪 Logout</button>
        </form>
    </aside>

    <main class="main-content">
        <div class="page-title">✍️ Review Diagnosis — Send Advice</div>
        <div class="review-grid">
            <div>
                <div class="card">
                    <div class="card-title">📸 Farmer's Leaf Image</div>
                    <img src="{{ asset('storage/'.$diagnosis->image_path) }}"
                         alt="Leaf" class="leaf-img">
                </div>
                <div class="card">
                    <div class="card-title">👨‍🌾 Farmer Info</div>
                    <div class="info-row">
                        <span class="info-label">Name</span>
                        <span class="info-value">{{ $diagnosis->farmer->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">District</span>
                        <span class="info-value">📍 {{ $diagnosis->farmer->district }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Submitted</span>
                        <span class="info-value">{{ $diagnosis->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">AI Confidence</span>
                        <span class="info-value" style="color:#993556;">
                            {{ $diagnosis->confidence ? number_format($diagnosis->confidence,1).'%' : '—' }}
                        </span>
                    </div>
                </div>
            </div>

            <div>
                @if($diagnosis->disease)
                <div class="card">
                    <div class="card-title">🦠 AI Detection Result</div>
                    <div class="disease-box">
                        <div class="disease-name">{{ $diagnosis->disease->name }}</div>
                        <div class="disease-sci">{{ $diagnosis->disease->scientific_name }}</div>
                    </div>
                    <div style="font-size:13px; font-weight:600; color:#333; margin-bottom:8px;">📋 Description</div>
                    <div class="treatment-box">{{ $diagnosis->disease->description }}</div>
                    <div style="font-size:13px; font-weight:600; color:#333; margin-bottom:8px;">🧪 Chemical Treatment</div>
                    <div class="treatment-box" style="background:#fff9f0; border-color:#ffd08a; color:#5c3a00;">{{ $diagnosis->disease->chemical_treatment }}</div>
                    <div style="font-size:13px; font-weight:600; color:#333; margin-bottom:8px;">🌿 Organic Treatment</div>
                    <div class="treatment-box">{{ $diagnosis->disease->organic_treatment }}</div>
                </div>
                @endif

                <div class="card">
                    <div class="card-title">💬 Send Your Expert Advice</div>
                    @if($diagnosis->officer_note)
                    <div class="existing-note">
                        <strong>✅ Advice already sent:</strong><br>
                        {{ $diagnosis->officer_note }}
                    </div>
                    @endif
                    <form method="POST" action="{{ route('officer.advice.send', $diagnosis->id) }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Your Expert Advice to Farmer</label>
                            <textarea name="officer_note" class="form-control" rows="5"
                                      placeholder="Write your treatment advice, field visit notes, precautions...">{{ $diagnosis->officer_note }}</textarea>
                        </div>
                        <button type="submit" class="btn-blue">
                            📤 Send Advice to Farmer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection