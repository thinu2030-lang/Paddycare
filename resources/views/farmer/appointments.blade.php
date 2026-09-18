@extends('layouts.app')
@section('title', 'My Appointments')

@push('styles')
<style>
    .dashboard-wrap { display: grid; grid-template-columns: 220px 1fr; min-height: calc(100vh - 100px); }
    .sidebar { background: #1a5c2e; padding: 24px 0; position: sticky; top: 60px; height: calc(100vh - 60px); overflow-y: auto; }
    .sidebar-user { padding: 0 20px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 12px; }
    .sidebar-avatar { width: 48px; height: 48px; background: #6fdc9e; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; color: #0a3318; margin-bottom: 10px; }
    .sidebar-name { color: #fff; font-weight: 600; font-size: 14px; }
    .sidebar-role { color: #6fdc9e; font-size: 12px; margin-top: 2px; }
    .sidebar-section { font-size: 10px; color: #6fdc9e; letter-spacing: 1px; text-transform: uppercase; padding: 14px 20px 6px; }
    .sidebar-link { display: flex; align-items: center; gap: 10px; padding: 10px 20px; color: #a5d6b0; font-size: 13px; border-left: 3px solid transparent; transition: all 0.2s; }
    .sidebar-link:hover { background: rgba(255,255,255,0.08); color: #fff; }
    .sidebar-link.active { background: rgba(255,255,255,0.12); color: #fff; border-left-color: #6fdc9e; font-weight: 500; }
    .main-content { padding: 28px; background: #f4f6f4; }
    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
    .page-title { font-size: 22px; font-weight: 700; color: #1a2e1e; }
    .btn-primary { background: #1a5c2e; color: #fff; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; border: none; cursor: pointer; transition: background 0.2s; display: inline-flex; align-items: center; gap: 6px; }
    .btn-primary:hover { background: #144a24; }

    .appt-table-wrap {
        background: #fff; border-radius: 12px;
        border: 1px solid #e0e8e2;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    table { width: 100%; border-collapse: collapse; }
    thead { background: #f8fdf9; }
    th {
        text-align: left; padding: 14px 16px;
        font-size: 12px; font-weight: 600;
        color: #3a7d4e; text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e0e8e2;
    }
    td {
        padding: 14px 16px; font-size: 13px;
        color: #1a2e1e; border-bottom: 1px solid #f0f4f1;
    }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #f8fdf9; }

    .officer-cell { display: flex; align-items: center; gap: 10px; }
    .officer-av {
        width: 34px; height: 34px; border-radius: 50%;
        background: #e6f1fb; display: flex; align-items: center;
        justify-content: center; font-size: 12px;
        font-weight: 700; color: #185fa5; flex-shrink: 0;
    }
    .officer-name { font-size: 13px; font-weight: 500; }
    .officer-dist { font-size: 11px; color: #666; }

    .badge { font-size: 11px; padding: 4px 12px; border-radius: 20px; font-weight: 500; }
    .badge-pending   { background: #faeeda; color: #854f0b; }
    .badge-confirmed { background: #e8f5e9; color: #1a5c2e; }
    .badge-rejected  { background: #fce4ec; color: #993556; }
    .badge-completed { background: #e6f1fb; color: #185fa5; }

    .empty-state {
        text-align: center; padding: 48px;
        color: #888; font-size: 14px;
    }
    .empty-icon { font-size: 48px; display: block; margin-bottom: 12px; }
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
        <a href="{{ route('farmer.diagnosis') }}" class="sidebar-link">📷 Disease Check</a>
        <a href="{{ route('farmer.seeds') }}" class="sidebar-link">🌱 Seed Guide</a>
        <a href="{{ route('farmer.crops') }}" class="sidebar-link">🌾 Harvest Tracker</a>
        <div class="sidebar-section">Appointments</div>
        <a href="{{ route('farmer.appointments.create') }}" class="sidebar-link">📅 Book Appointment</a>
        <a href="{{ route('farmer.appointments') }}" class="sidebar-link active">🗓 My Appointments</a>
        <div class="sidebar-section">Info</div>
        <a href="{{ route('articles') }}" class="sidebar-link">📖 Articles</a>
        <form method="POST" action="{{ route('logout') }}" style="margin-top:20px;">
            @csrf
            <button type="submit" class="sidebar-link" style="width:100%;background:none;border:none;cursor:pointer;text-align:left;">🚪 Logout</button>
        </form>
    </aside>

    <main class="main-content">
        <div class="page-header">
            <div class="page-title">🗓 My Appointments</div>
            <a href="{{ route('farmer.appointments.create') }}">
                <button class="btn-primary">📅 + Book New</button>
            </a>
        </div>

        <div class="appt-table-wrap">
            @if($appointments->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Field Officer</th>
                        <th>Date & Time</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Officer Response</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appt)
                    <tr>
                        <td>
                            <div class="officer-cell">
                                <div class="officer-av">
                                    {{ strtoupper(substr($appt->officer->name,0,2)) }}
                                </div>
                                <div>
                                    <div class="officer-name">{{ $appt->officer->name }}</div>
                                    <div class="officer-dist">📍 {{ $appt->officer->district }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            📅 {{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y') }}<br>
                            <span style="color:#666; font-size:12px;">
                                🕐 {{ \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A') }}
                            </span>
                        </td>
                        <td style="max-width:180px; color:#555;">
                            {{ $appt->reason ?? '—' }}
                        </td>
                        <td>
                            <span class="badge badge-{{ $appt->status }}">
                                {{ $appt->status === 'pending'   ? '⏳' : ($appt->status === 'confirmed' ? '✅' : ($appt->status === 'rejected' ? '❌' : '🏁')) }}
                                {{ ucfirst($appt->status) }}
                            </span>
                        </td>
                        <td style="font-size:12px; color:#555; max-width:160px;">
                            {{ $appt->officer_response ?? '—' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <span class="empty-icon">📅</span>
                No appointments yet.<br>
                <a href="{{ route('farmer.appointments.create') }}"
                   style="color:#1a5c2e; font-weight:600;">Book your first appointment →</a>
            </div>
            @endif
        </div>
    </main>
</div>
@endsection