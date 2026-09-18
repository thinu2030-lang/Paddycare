@extends('layouts.app')
@section('title', 'Send Notification')

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
    .form-card { background: #fff; border-radius: 12px; padding: 28px; border: 1px solid #e0e8e2; max-width: 680px; }
    .form-group { margin-bottom: 18px; }
    .form-label { display: block; font-size: 13px; font-weight: 500; color: #333; margin-bottom: 7px; }
    .form-control { width: 100%; padding: 10px 14px; border: 1.5px solid #d0ddd4; border-radius: 8px; font-size: 14px; color: #1a1a1a; background: #f8fdf9; transition: border-color 0.2s; }
    .form-control:focus { outline: none; border-color: #1a5c2e; background: #fff; }
    .info-box { background: #e8f5e9; border-radius: 10px; padding: 16px; border: 1px solid #a5d6b0; margin-bottom: 20px; font-size: 13px; color: #1a5c2e; }
    .btn-submit { background: #1a5c2e; color: #fff; padding: 12px 28px; border-radius: 8px; font-size: 14px; font-weight: 600; border: none; cursor: pointer; }
    .btn-submit:hover { background: #144a24; }
    .btn-back { background: transparent; color: #555; padding: 12px 20px; border-radius: 8px; font-size: 14px; border: 1.5px solid #d0ddd4; cursor: pointer; }
    .type-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .type-option input[type=radio] { display: none; }
    .type-option label {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 16px; border: 1.5px solid #e0e8e2;
        border-radius: 10px; cursor: pointer; transition: all 0.2s;
        font-size: 13px; color: #333;
    }
    .type-option input:checked + label { border-color: #1a5c2e; background: #f0fbf4; color: #1a5c2e; font-weight: 500; }
    .type-option label:hover { border-color: #1a5c2e; }
    .type-icon { font-size: 20px; }
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
        <a href="{{ route('officer.diagnoses') }}" class="sidebar-link">🔬 Diagnoses</a>
        <div class="sidebar-section">Content</div>
        <a href="{{ route('officer.articles.index') }}" class="sidebar-link">📖 Articles</a>
        <div class="sidebar-section">Notifications</div>
        <a href="{{ route('officer.notifications.index') }}" class="sidebar-link active">📧 Notify Farmers</a>
        <div class="sidebar-section">Info</div>
        <a href="{{ route('articles') }}" class="sidebar-link">🌐 Public Articles</a>
        <form method="POST" action="{{ route('logout') }}" style="margin-top:20px;">
            @csrf
            <button type="submit" class="sidebar-link" style="width:100%;background:none;border:none;cursor:pointer;text-align:left;">🚪 Logout</button>
        </form>
    </aside>

    <main class="main-content">
        <div class="page-title">📨 Send Notification to Farmers</div>

        <div class="form-card">
            <div class="info-box">
                This notification will be emailed to all
                <strong>{{ $farmerCount }} registered farmers</strong>
                in <strong>{{ $district }} District</strong>.
            </div>

            <form method="POST" action="{{ route('officer.notifications.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Notification Type</label>
                    <div class="type-grid">
                        <div class="type-option">
                            <input type="radio" name="type" id="fertilizer" value="fertilizer"
                                   {{ old('type')==='fertilizer' ? 'checked' : '' }}>
                            <label for="fertilizer">
                                <span class="type-icon">🧪</span>
                                <div>
                                    <div style="font-weight:500;">Fertilizer Reminder</div>
                                    <div style="font-size:11px; color:#666;">Pohora schedule</div>
                                </div>
                            </label>
                        </div>
                        <div class="type-option">
                            <input type="radio" name="type" id="meeting" value="meeting"
                                   {{ old('type')==='meeting' ? 'checked' : '' }}>
                            <label for="meeting">
                                <span class="type-icon">📅</span>
                                <div>
                                    <div style="font-weight:500;">Meeting Notice</div>
                                    <div style="font-size:11px; color:#666;">Farmer meeting</div>
                                </div>
                            </label>
                        </div>
                        <div class="type-option">
                            <input type="radio" name="type" id="disease_alert" value="disease_alert"
                                   {{ old('type')==='disease_alert' ? 'checked' : '' }}>
                            <label for="disease_alert">
                                <span class="type-icon">🦠</span>
                                <div>
                                    <div style="font-weight:500;">Disease Alert</div>
                                    <div style="font-size:11px; color:#666;">Outbreak warning</div>
                                </div>
                            </label>
                        </div>
                        <div class="type-option">
                            <input type="radio" name="type" id="general" value="general" checked
                                   {{ old('type')==='general' ? 'checked' : '' }}>
                            <label for="general">
                                <span class="type-icon">📢</span>
                                <div>
                                    <div style="font-weight:500;">General Notice</div>
                                    <div style="font-size:11px; color:#666;">Other notices</div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control"
                           value="{{ old('subject') }}"
                           placeholder="e.g. Important: Apply Urea Fertilizer This Week"
                           required>
                </div>

                <div class="form-group">
                    <label class="form-label">Message</label>
                    <textarea name="message" class="form-control" rows="8"
                              placeholder="Write your notification message here..."
                              required>{{ old('message') }}</textarea>
                </div>

                <div style="display:flex; gap:10px;">
                    <button type="submit" class="btn-submit"
                            onclick="return confirm('Send to {{ $farmerCount }} farmers in {{ $district }}?')">
                        📨 Send to {{ $farmerCount }} Farmers
                    </button>
                    <a href="{{ route('officer.notifications.index') }}">
                        <button type="button" class="btn-back">← Back</button>
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection