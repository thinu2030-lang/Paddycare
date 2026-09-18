@extends('layouts.app')
@section('title', 'Farmer Dashboard')

@push('styles')
<style>
    .dashboard-wrap {
        display: grid;
        grid-template-columns: 220px 1fr;
        min-height: calc(100vh - 100px);
    }
    .sidebar {
        background: #1a5c2e;
        padding: 24px 0;
        position: sticky;
        top: 60px;
        height: calc(100vh - 60px);
        overflow-y: auto;
    }
    .sidebar-user {
        padding: 0 20px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        margin-bottom: 12px;
    }
    .sidebar-avatar {
        width: 48px; height: 48px;
        background: #6fdc9e;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; font-weight: 700;
        color: #0a3318;
        margin-bottom: 10px;
    }
    .sidebar-name { color: #fff; font-weight: 600; font-size: 14px; }
    .sidebar-role { color: #6fdc9e; font-size: 12px; margin-top: 2px; }
    .sidebar-district { color: #a5d6b0; font-size: 12px; margin-top: 2px; }
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
    .sidebar-icon { font-size: 16px; }

    .main-content { padding: 28px; background: #f4f6f4; }
    .page-title { font-size: 22px; font-weight: 700; color: #1a2e1e; margin-bottom: 4px; }
    .page-sub { font-size: 13px; color: #666; margin-bottom: 24px; }

    .stats-grid {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 14px; margin-bottom: 24px;
    }
    .stat-card {
        background: #fff; border-radius: 12px; padding: 18px 20px;
        border: 1px solid #e0e8e2; box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .stat-card-label { font-size: 12px; color: #666; margin-bottom: 8px; display: flex; align-items: center; gap: 6px; }
    .stat-card-value { font-size: 28px; font-weight: 700; }
    .stat-card-sub { font-size: 11px; color: #888; margin-top: 4px; }

    .quick-actions {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 10px; margin-bottom: 20px;
    }
    .action-btn {
        background: #fff; border: 1.5px solid #e0e8e2;
        border-radius: 10px; padding: 16px; text-align: center;
        cursor: pointer; transition: all 0.2s; display: block; color: #1a2e1e;
    }
    .action-btn:hover {
        border-color: #1a5c2e; background: #f0fbf4;
        transform: translateY(-2px); box-shadow: 0 4px 12px rgba(26,92,46,0.1);
    }
    .action-btn-icon  { font-size: 28px; display: block; margin-bottom: 8px; }
    .action-btn-label { font-size: 13px; font-weight: 500; }

    .content-grid {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 20px; margin-bottom: 20px;
    }
    .card {
        background: #fff; border-radius: 12px; padding: 20px;
        border: 1px solid #e0e8e2; box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        margin-bottom: 20px;
    }
    .card-title {
        font-size: 15px; font-weight: 600; color: #1a2e1e;
        margin-bottom: 16px; display: flex; align-items: center;
        justify-content: space-between;
    }

    .appt-item {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 0; border-bottom: 1px solid #f0f4f1;
    }
    .appt-item:last-child { border-bottom: none; }
    .appt-date-box {
        background: #e8f5e9; border-radius: 8px;
        padding: 8px 10px; text-align: center; min-width: 46px;
    }
    .appt-day   { font-size: 20px; font-weight: 700; color: #1a5c2e; line-height: 1; }
    .appt-month { font-size: 10px; color: #3a7d4e; text-transform: uppercase; margin-top: 2px; }
    .appt-info  { flex: 1; }
    .appt-name  { font-size: 13px; font-weight: 500; color: #1a2e1e; }
    .appt-time  { font-size: 12px; color: #666; margin-top: 2px; }

    .badge { font-size: 11px; padding: 3px 10px; border-radius: 20px; font-weight: 500; white-space: nowrap; }
    .badge-pending   { background: #faeeda; color: #854f0b; }
    .badge-confirmed { background: #e8f5e9; color: #1a5c2e; }
    .badge-rejected  { background: #fce4ec; color: #993556; }
    .badge-high      { background: #fce4ec; color: #993556; }
    .badge-medium    { background: #fff3e0; color: #854f0b; }
    .badge-healthy   { background: #e8f5e9; color: #1a5c2e; }

    .diag-item {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 0; border-bottom: 1px solid #f0f4f1;
    }
    .diag-item:last-child { border-bottom: none; }
    .diag-icon {
        width: 40px; height: 40px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; flex-shrink: 0;
    }
    .diag-name { font-size: 13px; font-weight: 500; color: #1a2e1e; }
    .diag-meta { font-size: 12px; color: #666; margin-top: 2px; }

    .empty-state { text-align: center; padding: 24px; color: #888; font-size: 13px; }
    .btn-sm {
        font-size: 12px; padding: 6px 14px; border-radius: 6px;
        border: 1.5px solid #1a5c2e; color: #1a5c2e;
        background: transparent; cursor: pointer; transition: all 0.2s; white-space: nowrap;
    }
    .btn-sm:hover { background: #1a5c2e; color: #fff; }

    /* ADVICE SECTION */
    .advice-card {
        background: #fff; border-radius: 12px; padding: 20px;
        border: 1px solid #90caf9; box-shadow: 0 2px 8px rgba(24,95,165,0.08);
        margin-bottom: 20px;
    }
    .advice-card-title {
        font-size: 15px; font-weight: 600; color: #185fa5;
        margin-bottom: 16px; display: flex; align-items: center;
        justify-content: space-between;
    }
    .advice-item {
        display: flex; gap: 14px; align-items: flex-start;
        padding: 14px 0; border-bottom: 1px solid #e6f1fb;
    }
    .advice-item:last-child { border-bottom: none; }
    .advice-thumb {
        width: 48px; height: 48px; border-radius: 8px;
        object-fit: cover; border: 1px solid #e0e8e2; flex-shrink: 0;
    }
    .advice-note {
        background: #e6f1fb; border-left: 3px solid #185fa5;
        border-radius: 6px; padding: 10px 14px;
        font-size: 12px; color: #0c447c; line-height: 1.6;
        margin-top: 6px;
    }

    /* DISTRICT NOTIFICATIONS */
    .notif-card {
        background: #fff; border-radius: 12px; padding: 20px;
        border: 1px solid #c8e6c9; box-shadow: 0 2px 8px rgba(26,92,46,0.06);
        margin-bottom: 20px;
    }
    .notif-card-title {
        font-size: 15px; font-weight: 600; color: #1a5c2e;
        margin-bottom: 16px;
    }
    .notif-item { padding: 12px 0; border-bottom: 1px solid #f0f4f1; }
    .notif-item:last-child { border-bottom: none; }
    .notif-type-badge {
        display: inline-block; font-size: 11px; padding: 3px 10px;
        border-radius: 20px; font-weight: 600; margin-bottom: 6px;
    }
</style>
@endpush

@section('content')
<div class="dashboard-wrap">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-user">
            <div class="sidebar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
            <div class="sidebar-name">{{ auth()->user()->name }}</div>
            <div class="sidebar-role">🌾 Farmer</div>
            <div class="sidebar-district">📍 {{ auth()->user()->district }}</div>
        </div>

        <div class="sidebar-section">Main</div>
        <a href="{{ route('farmer.dashboard') }}" class="sidebar-link {{ request()->routeIs('farmer.dashboard') ? 'active' : '' }}">
            <span class="sidebar-icon">📊</span> Dashboard
        </a>

        <div class="sidebar-section">Paddy Care</div>
        <a href="{{ route('farmer.diagnosis') }}" class="sidebar-link {{ request()->routeIs('farmer.diagnosis*') ? 'active' : '' }}">
            <span class="sidebar-icon">📷</span> Disease Check
        </a>
        <a href="{{ route('farmer.seeds') }}" class="sidebar-link {{ request()->routeIs('farmer.seeds') ? 'active' : '' }}">
            <span class="sidebar-icon">🌱</span> Seed Guide
        </a>
        <a href="{{ route('farmer.crops') }}" class="sidebar-link {{ request()->routeIs('farmer.crops*') ? 'active' : '' }}">
            <span class="sidebar-icon">🌾</span> Harvest Tracker
        </a>

        <div class="sidebar-section">Appointments</div>
        <a href="{{ route('farmer.appointments.create') }}" class="sidebar-link {{ request()->routeIs('farmer.appointments.create') ? 'active' : '' }}">
            <span class="sidebar-icon">📅</span> Book Appointment
        </a>
        <a href="{{ route('farmer.appointments') }}" class="sidebar-link {{ request()->routeIs('farmer.appointments') ? 'active' : '' }}">
            <span class="sidebar-icon">🗓</span> My Appointments
        </a>

        <div class="sidebar-section">Info</div>
        <a href="{{ route('articles') }}" class="sidebar-link">
            <span class="sidebar-icon">📖</span> Articles
        </a>

        <form method="POST" action="{{ route('logout') }}" style="margin-top:20px;">
            @csrf
            <button type="submit" class="sidebar-link"
                style="width:100%; background:none; border:none; cursor:pointer; text-align:left;">
                <span class="sidebar-icon">🚪</span> Logout
            </button>
        </form>
    </aside>

    <!-- MAIN -->
    <main class="main-content">
        <div class="page-title">👋 Welcome, {{ auth()->user()->name }}!</div>
        <div class="page-sub">📍 {{ auth()->user()->district }} District &nbsp;·&nbsp; {{ now()->format('l, F j, Y') }}</div>

        <!-- STATS -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-label">📷 Total Scans</div>
                <div class="stat-card-value" style="color:#185fa5;">{{ $totalScans }}</div>
                <div class="stat-card-sub">Leaf images uploaded</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-label">🦠 Diseases Found</div>
                <div class="stat-card-value" style="color:#e24b4a;">{{ $diseasesFound }}</div>
                <div class="stat-card-sub">Requires attention</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-label">📅 Appointments</div>
                <div class="stat-card-value" style="color:#1a5c2e;">{{ $appointments->count() }}</div>
                <div class="stat-card-sub">Total booked</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-label">🏆 Healthy Scans</div>
                <div class="stat-card-value" style="color:#854f0b;">{{ $totalScans - $diseasesFound }}</div>
                <div class="stat-card-sub">Clean results</div>
            </div>
        </div>

        <!-- QUICK ACTIONS -->
        <div class="quick-actions">
            <a href="{{ route('farmer.diagnosis') }}" class="action-btn">
                <span class="action-btn-icon">📷</span>
                <span class="action-btn-label">Check Disease Now</span>
            </a>
            <a href="{{ route('farmer.appointments.create') }}" class="action-btn">
                <span class="action-btn-icon">📅</span>
                <span class="action-btn-label">Book Appointment</span>
            </a>
            <a href="{{ route('farmer.crops') }}" class="action-btn">
                <span class="action-btn-icon">🌾</span>
                <span class="action-btn-label">Harvest Tracker</span>
            </a>
            <a href="{{ route('farmer.seeds') }}" class="action-btn">
                <span class="action-btn-icon">🌱</span>
                <span class="action-btn-label">Seed Recommendations</span>
            </a>
        </div>

        <!-- OFFICER ADVICE RECEIVED -->
        @if($adviceReceived->count() > 0)
        <div class="advice-card">
            <div class="advice-card-title">
                <span>👮 Expert Advice from Field Officers</span>
                <span style="background:#185fa5; color:#fff; font-size:11px; padding:3px 12px; border-radius:20px;">
                    {{ $adviceReceived->count() }} New
                </span>
            </div>
            @foreach($adviceReceived as $adv)
            <div class="advice-item">
                <img src="{{ asset('storage/'.$adv->image_path) }}"
                     alt="Leaf" class="advice-thumb">
                <div style="flex:1;">
                    <div style="font-size:13px; font-weight:600; color:#1a2e1e; margin-bottom:4px;">
                        {{ $adv->disease->name ?? 'Healthy Leaf' }}
                        <span style="font-size:11px; color:#888; font-weight:400; margin-left:8px;">
                            {{ $adv->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <div class="advice-note">
                        <strong>👮 {{ $adv->reviewer->name ?? 'Field Officer' }}:</strong>
                        {{ \Illuminate\Support\Str::limit($adv->officer_note, 150) }}
                    </div>
                    <a href="{{ route('farmer.diagnosis.show', $adv->id) }}"
                       style="font-size:12px; color:#185fa5; font-weight:500; margin-top:6px; display:inline-block;">
                        View Full Details →
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- DISTRICT NOTIFICATIONS -->
        @if($districtNotifications->count() > 0)
        <div class="notif-card">
            <div class="notif-card-title">
                📧 Officer Notifications — {{ auth()->user()->district }} District
            </div>
            @foreach($districtNotifications as $notif)
            @php
                $typeColors = [
                    'fertilizer'    => ['bg'=>'#e8f5e9','color'=>'#1a5c2e','label'=>'Fertilizer'],
                    'meeting'       => ['bg'=>'#e6f1fb','color'=>'#185fa5','label'=>'Meeting'],
                    'disease_alert' => ['bg'=>'#fce4ec','color'=>'#993556','label'=>'Disease Alert'],
                    'general'       => ['bg'=>'#fff3e0','color'=>'#854f0b','label'=>'General'],
                ];
                $tc = $typeColors[$notif->type] ?? ['bg'=>'#f5f5f5','color'=>'#555','label'=>ucfirst($notif->type)];
            @endphp
            <div class="notif-item">
                <span class="notif-type-badge"
                      style="background:{{ $tc['bg'] }}; color:{{ $tc['color'] }};">
                    {{ $tc['label'] }}
                </span>
                <div style="font-size:13px; font-weight:600; color:#1a2e1e; margin-bottom:4px;">
                    {{ $notif->subject }}
                </div>
                <div style="font-size:12px; color:#555; line-height:1.6;">
                    {{ \Illuminate\Support\Str::limit($notif->message, 120) }}
                </div>
                <div style="font-size:11px; color:#888; margin-top:4px;">
                    {{ $notif->created_at->diffForHumans() }}
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- APPOINTMENTS + RECENT DIAGNOSES -->
        <div class="content-grid">
            <!-- Appointments -->
            <div class="card">
                <div class="card-title">
                    <span>📅 My Appointments</span>
                    <a href="{{ route('farmer.appointments.create') }}" class="btn-sm">+ Book</a>
                </div>
                @forelse($appointments as $appt)
                <div class="appt-item">
                    <div class="appt-date-box">
                        <div class="appt-day">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('d') }}</div>
                        <div class="appt-month">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('M') }}</div>
                    </div>
                    <div class="appt-info">
                        <div class="appt-name">{{ $appt->officer->name }}</div>
                        <div class="appt-time">🕐 {{ \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A') }}</div>
                    </div>
                    <span class="badge badge-{{ $appt->status }}">{{ ucfirst($appt->status) }}</span>
                </div>
                @empty
                <div class="empty-state">
                    📅 No appointments yet.<br>
                    <a href="{{ route('farmer.appointments.create') }}"
                       style="color:#1a5c2e; font-weight:500;">Book one now →</a>
                </div>
                @endforelse
            </div>

            <!-- Recent Diagnoses -->
            <div class="card">
                <div class="card-title">
                    <span>🔬 Recent Diagnoses</span>
                    <a href="{{ route('farmer.diagnosis') }}" class="btn-sm">+ New Scan</a>
                </div>
                @forelse($recentScans as $scan)
                <div class="diag-item">
                    <div class="diag-icon"
                         style="background:{{ $scan->disease ? '#fce4ec' : '#e8f5e9' }}">
                        {{ $scan->disease ? '🦠' : '✅' }}
                    </div>
                    <div style="flex:1;">
                        <div class="diag-name">
                            {{ $scan->disease ? $scan->disease->name : 'Healthy Leaf' }}
                        </div>
                        <div class="diag-meta">
                            {{ $scan->confidence ? number_format($scan->confidence, 0).'% confidence' : 'Processed' }}
                            · {{ $scan->created_at->format('M d') }}
                        </div>
                    </div>
                    <span class="badge {{ $scan->disease ? ($scan->disease->severity_level === 'high' ? 'badge-high' : 'badge-medium') : 'badge-healthy' }}">
                        {{ $scan->disease ? ucfirst($scan->disease->severity_level ?? 'Medium') : 'Healthy' }}
                    </span>
                    <a href="{{ route('farmer.diagnosis.show', $scan->id) }}"
                       class="btn-sm" style="margin-left:8px;">View</a>
                </div>
                @empty
                <div class="empty-state">
                    📷 No scans yet.<br>
                    <a href="{{ route('farmer.diagnosis') }}"
                       style="color:#1a5c2e; font-weight:500;">Upload first image →</a>
                </div>
                @endforelse
            </div>
        </div>
    </main>
</div>
@endsection