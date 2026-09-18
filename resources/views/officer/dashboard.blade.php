@extends('layouts.app')
@section('title', 'Officer Dashboard')

@push('styles')
<style>
    .dashboard-wrap { display: grid; grid-template-columns: 220px 1fr; min-height: calc(100vh - 100px); }
    .sidebar { background: #1a5c2e; padding: 24px 0; position: sticky; top: 60px; height: calc(100vh - 60px); overflow-y: auto; }
    .sidebar-user { padding: 0 20px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 12px; }
    .sidebar-avatar { width: 48px; height: 48px; background: #6fdc9e; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; color: #0a3318; margin-bottom: 10px; }
    .sidebar-name { color: #fff; font-weight: 600; font-size: 14px; }
    .sidebar-role { color: #a5d6b0; font-size: 12px; margin-top: 2px; }
    .sidebar-district { color: #a5d6b0; font-size: 12px; margin-top: 2px; }
    .sidebar-section { font-size: 10px; color: #6fdc9e; letter-spacing: 1px; text-transform: uppercase; padding: 14px 20px 6px; }
    .sidebar-link { display: flex; align-items: center; gap: 10px; padding: 10px 20px; color: #a5d6b0; font-size: 13px; border-left: 3px solid transparent; transition: all 0.2s; }
    .sidebar-link:hover { background: rgba(255,255,255,0.08); color: #fff; }
    .sidebar-link.active { background: rgba(255,255,255,0.12); color: #fff; border-left-color: #6fdc9e; font-weight: 500; }
    .main-content { padding: 28px; background: #f4f6f4; }
    .page-title { font-size: 22px; font-weight: 700; color: #1a2e1e; margin-bottom: 4px; }
    .page-sub   { font-size: 13px; color: #666; margin-bottom: 24px; }
    .stats-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; margin-bottom: 24px; }
    .stat-card { background: #fff; border-radius: 12px; padding: 18px 20px; border: 1px solid #e0e8e2; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
    .stat-label { font-size: 12px; color: #666; margin-bottom: 8px; }
    .stat-value { font-size: 28px; font-weight: 700; }
    .stat-sub   { font-size: 11px; color: #888; margin-top: 4px; }
    .content-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
    .card { background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #e0e8e2; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
    .card-title { font-size: 15px; font-weight: 600; color: #1a2e1e; margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between; }
    .appt-item { display: flex; align-items: center; gap: 12px; padding: 12px 0; border-bottom: 1px solid #f0f4f1; }
    .appt-item:last-child { border-bottom: none; }
    .farmer-av { width: 36px; height: 36px; border-radius: 50%; background: #e8f5e9; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: #1a5c2e; flex-shrink: 0; }
    .appt-info { flex: 1; }
    .appt-name { font-size: 13px; font-weight: 500; color: #1a2e1e; }
    .appt-sub  { font-size: 12px; color: #666; margin-top: 2px; }
    .badge { font-size: 11px; padding: 3px 10px; border-radius: 20px; font-weight: 500; }
    .badge-pending   { background: #faeeda; color: #854f0b; }
    .badge-confirmed { background: #e8f5e9; color: #1a5c2e; }
    .badge-rejected  { background: #fce4ec; color: #993556; }
    .action-btns { display: flex; gap: 6px; margin-left: 8px; }
    .btn-accept { background: #e8f5e9; color: #1a5c2e; border: 1px solid #a5d6b0; padding: 5px 10px; border-radius: 6px; font-size: 12px; cursor: pointer; transition: all 0.2s; }
    .btn-accept:hover { background: #1a5c2e; color: #fff; }
    .btn-reject { background: #fce4ec; color: #993556; border: 1px solid #f4c0d1; padding: 5px 10px; border-radius: 6px; font-size: 12px; cursor: pointer; transition: all 0.2s; }
    .btn-reject:hover { background: #993556; color: #fff; }
    .diag-item { display: flex; align-items: center; gap: 12px; padding: 11px 0; border-bottom: 1px solid #f0f4f1; }
    .diag-item:last-child { border-bottom: none; }
    .diag-icon { width: 38px; height: 38px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; }
    .btn-sm { font-size: 12px; padding: 5px 12px; border-radius: 6px; border: 1px solid #d0ddd4; color: #555; background: #f4f6f4; cursor: pointer; }
    .btn-sm:hover { border-color: #1a5c2e; color: #1a5c2e; }
    .empty-state { text-align: center; padding: 28px; color: #888; font-size: 13px; }
</style>
@endpush

@section('content')
<div class="dashboard-wrap">
    <aside class="sidebar">
        <div class="sidebar-user">
            <div class="sidebar-avatar">{{ strtoupper(substr(auth()->user()->name,0,2)) }}</div>
            <div class="sidebar-name">{{ auth()->user()->name }}</div>
            <div class="sidebar-role">👮 Field Officer</div>
            <div class="sidebar-district">📍 {{ auth()->user()->district }}</div>
        </div>
        <div class="sidebar-section">Main</div>
        <a href="{{ route('officer.dashboard') }}" class="sidebar-link active">📊 Dashboard</a>
        <div class="sidebar-section">Work</div>
        <a href="{{ route('officer.appointments') }}" class="sidebar-link">📅 Appointments</a>
        <a href="{{ route('officer.diagnoses') }}" class="sidebar-link">🔬 Diagnoses</a>
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
        <div class="page-title">👋 Welcome, {{ auth()->user()->name }}!</div>
        <div class="page-sub">👮 Field Officer · 📍 {{ auth()->user()->district }} · {{ now()->format('l, F j, Y') }}</div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">⏳ Pending Requests</div>
                <div class="stat-value" style="color:#854f0b;">{{ $pendingAppts }}</div>
                <div class="stat-sub">Needs your response</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">📅 Today's Appointments</div>
                <div class="stat-value" style="color:#1a5c2e;">{{ $todayAppts->count() }}</div>
                <div class="stat-sub">Scheduled today</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">🔬 Pending Diagnoses</div>
                <div class="stat-value" style="color:#993556;">{{ $pendingDiagnoses->count() }}</div>
                <div class="stat-sub">Awaiting review</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">✅ Total Appointments</div>
                <div class="stat-value" style="color:#1a5c2e;">{{ $recentAppts->count() }}</div>
                <div class="stat-sub">All time</div>
            </div>
        </div>

        <div class="content-grid">
            <!-- PENDING APPOINTMENTS -->
            <div class="card">
                <div class="card-title">
                    <span>⏳ Pending Appointment Requests</span>
                    <a href="{{ route('officer.appointments') }}" style="font-size:12px; color:#1a5c2e;">View all →</a>
                </div>
                @forelse($recentAppts->where('status','pending') as $appt)
                <div class="appt-item">
                    <div class="farmer-av">{{ strtoupper(substr($appt->farmer->name,0,2)) }}</div>
                    <div class="appt-info">
                        <div class="appt-name">{{ $appt->farmer->name }}</div>
                        <div class="appt-sub">
                            📅 {{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d') }}
                            · 🕐 {{ \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A') }}
                        </div>
                    </div>
                    <div class="action-btns">
                        <form method="POST" action="{{ route('officer.appointments.accept', $appt->id) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-accept">✓ Accept</button>
                        </form>
                        <form method="POST" action="{{ route('officer.appointments.reject', $appt->id) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-reject">✕ Reject</button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="empty-state">✅ No pending requests!</div>
                @endforelse
            </div>

            <!-- PENDING DIAGNOSES -->
            <div class="card">
                <div class="card-title">
                    <span>🔬 Diagnoses Needing Review</span>
                    <a href="{{ route('officer.diagnoses') }}" style="font-size:12px; color:#1a5c2e;">View all →</a>
                </div>
                @forelse($pendingDiagnoses as $d)
                <div class="diag-item">
                    <div class="diag-icon" style="background:{{ $d->disease ? '#fce4ec' : '#e8f5e9' }}">
                        {{ $d->disease ? '🦠' : '✅' }}
                    </div>
                    <div style="flex:1;">
                        <div style="font-size:13px; font-weight:500; color:#1a2e1e;">
                            {{ $d->disease ? $d->disease->name : 'Healthy' }}
                        </div>
                        <div style="font-size:12px; color:#666;">
                            {{ $d->farmer->name }} · {{ $d->created_at->format('M d') }}
                        </div>
                    </div>
                    <a href="{{ route('officer.diagnoses.show', $d->id) }}">
                        <button class="btn-sm">Review</button>
                    </a>
                </div>
                @empty
                <div class="empty-state">✅ All diagnoses reviewed!</div>
                @endforelse
            </div>
        </div>

        <!-- TODAY'S SCHEDULE -->
        @if($todayAppts->count() > 0)
        <div class="card">
            <div class="card-title">📅 Today's Schedule</div>
            @foreach($todayAppts as $appt)
            <div class="appt-item">
                <div class="farmer-av">{{ strtoupper(substr($appt->farmer->name,0,2)) }}</div>
                <div class="appt-info">
                    <div class="appt-name">{{ $appt->farmer->name }}</div>
                    <div class="appt-sub">🕐 {{ \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A') }} · {{ $appt->reason ?? 'General consultation' }}</div>
                </div>
                <span class="badge badge-{{ $appt->status }}">{{ ucfirst($appt->status) }}</span>
            </div>
            @endforeach
        </div>
        @endif
    </main>
</div>
@endsection