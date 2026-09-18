@extends('layouts.app')
@section('title', 'Manage Appointments')

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
    .card { background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #e0e8e2; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
    table { width: 100%; border-collapse: collapse; }
    thead { background: #f0fbf4; }
    th { text-align: left; padding: 13px 16px; font-size: 12px; font-weight: 600; color: #1a5c2e; text-transform: uppercase; letter-spacing: 0.4px; border-bottom: 1px solid #e0e8e2; }
    td { padding: 13px 16px; font-size: 13px; color: #1a2e1e; border-bottom: 1px solid #f0f4f1; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #f8fdf9; }
    .farmer-cell { display: flex; align-items: center; gap: 10px; }
    .farmer-av { width: 34px; height: 34px; border-radius: 50%; background: #e8f5e9; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: #1a5c2e; flex-shrink: 0; }
    .badge { font-size: 11px; padding: 4px 12px; border-radius: 20px; font-weight: 500; }
    .badge-pending   { background: #faeeda; color: #854f0b; }
    .badge-confirmed { background: #e8f5e9; color: #1a5c2e; }
    .badge-rejected  { background: #fce4ec; color: #993556; }
    .badge-completed { background: #e6f1fb; color: #185fa5; }
    .action-btns { display: flex; gap: 6px; }
    .btn-accept { background: #e8f5e9; color: #1a5c2e; border: 1px solid #a5d6b0; padding: 5px 12px; border-radius: 6px; font-size: 12px; cursor: pointer; }
    .btn-accept:hover { background: #1a5c2e; color: #fff; }
    .btn-reject { background: #fce4ec; color: #993556; border: 1px solid #f4c0d1; padding: 5px 12px; border-radius: 6px; font-size: 12px; cursor: pointer; }
    .btn-reject:hover { background: #993556; color: #fff; }
    .empty-state { text-align: center; padding: 48px; color: #888; font-size: 14px; }
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
        <a href="{{ route('officer.appointments') }}" class="sidebar-link active">📅 Appointments</a>
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
        <div class="page-title">📅 Farmer Appointment Requests</div>
        <div class="card">
            @if($appointments->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Farmer</th>
                        <th>Date & Time</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appt)
                    <tr>
                        <td>
                            <div class="farmer-cell">
                                <div class="farmer-av">{{ strtoupper(substr($appt->farmer->name,0,2)) }}</div>
                                <div>
                                    <div style="font-weight:500;">{{ $appt->farmer->name }}</div>
                                    <div style="font-size:11px; color:#666;">📍 {{ $appt->farmer->district }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            📅 {{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y') }}<br>
                            <span style="font-size:12px; color:#666;">🕐 {{ \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A') }}</span>
                        </td>
                        <td style="max-width:160px; font-size:12px; color:#555;">{{ $appt->reason ?? '—' }}</td>
                        <td><span class="badge badge-{{ $appt->status }}">{{ ucfirst($appt->status) }}</span></td>
                        <td>
                            @if($appt->status === 'pending')
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
                            @else
                            <span style="font-size:12px; color:#888;">{{ ucfirst($appt->status) }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">📅 No appointment requests yet.</div>
            @endif
        </div>
    </main>
</div>
@endsection