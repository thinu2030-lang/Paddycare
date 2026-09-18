@extends('layouts.app')
@section('title', 'Officer Reports')

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
    .page-title { font-size: 22px; font-weight: 700; color: #1a2e1e; margin-bottom: 6px; }
    .page-sub   { font-size: 13px; color: #666; margin-bottom: 28px; }

    .officers-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    .officer-card {
        background: #fff; border-radius: 14px;
        border: 1px solid #e0e8e2;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .officer-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(26,92,46,0.12);
    }
    .officer-card-header {
        background: linear-gradient(135deg, #1a5c2e, #2d8a4e);
        padding: 24px; text-align: center;
    }
    .officer-av {
        width: 64px; height: 64px; border-radius: 50%;
        background: #6fdc9e; display: flex; align-items: center;
        justify-content: center; font-size: 24px; font-weight: 700;
        color: #0a3318; margin: 0 auto 12px;
        border: 3px solid rgba(255,255,255,0.3);
    }
    .officer-name { color: #fff; font-size: 16px; font-weight: 600; margin-bottom: 4px; }
    .officer-dist { color: #a5d6b0; font-size: 12px; }

    .officer-card-body { padding: 16px; }
    .officer-stats {
        display: grid; grid-template-columns: 1fr 1fr 1fr;
        gap: 8px; margin-bottom: 16px;
    }
    .o-stat {
        background: #f8fdf9; border: 1px solid #e0e8e2;
        border-radius: 8px; padding: 10px; text-align: center;
    }
    .o-stat-num { font-size: 20px; font-weight: 700; color: #1a5c2e; }
    .o-stat-lbl { font-size: 10px; color: #666; margin-top: 2px; }

    .btn-report {
        display: block; width: 100%; padding: 11px;
        background: #1a5c2e; color: #fff;
        border: none; border-radius: 8px;
        font-size: 13px; font-weight: 600;
        cursor: pointer; text-align: center;
        text-decoration: none; transition: background 0.2s;
    }
    .btn-report:hover { background: #144a24; color: #fff; }

    .empty-state { grid-column: 1/-1; text-align: center; padding: 60px; color: #888; }
</style>
@endpush

@section('content')
<div class="dashboard-wrap">
    <aside class="sidebar">
        <div class="sidebar-user">
            <div class="sidebar-avatar">AD</div>
            <div class="sidebar-name">Administrator</div>
            <div class="sidebar-role">🛡️ System Admin</div>
        </div>
        <div class="sidebar-section">Overview</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link">📊 Dashboard</a>
        <div class="sidebar-section">Users</div>
        <a href="{{ route('admin.users.index') }}" class="sidebar-link">👥 All Users</a>
        <a href="{{ route('admin.users.create') }}" class="sidebar-link">➕ Add Officer</a>
        <div class="sidebar-section">Content</div>
        <a href="{{ route('admin.articles.index') }}" class="sidebar-link">📖 Articles</a>
        <a href="{{ route('admin.diseases.index') }}" class="sidebar-link">🦠 Diseases</a>
        <div class="sidebar-section">Reports</div>
        <a href="{{ route('admin.reports.index') }}" class="sidebar-link active">📊 Officer Reports</a>
        <form method="POST" action="{{ route('logout') }}" style="margin-top:20px;">
            @csrf
            <button type="submit" class="sidebar-link" style="width:100%;background:none;border:none;cursor:pointer;text-align:left;">🚪 Logout</button>
        </form>
    </aside>

    <main class="main-content">
        <div class="page-title">📊 Officer Performance Reports</div>
        <div class="page-sub">Select a field officer to generate and download their performance report as PDF.</div>

        <div class="officers-grid">
            @forelse($officers as $officer)
            @php
                $apptCount    = \App\Models\Appointment::where('officer_id', $officer->id)->count();
                $diagCount    = \App\Models\Diagnosis::where('reviewed_by', $officer->id)->count();
                $articleCount = \App\Models\Article::where('created_by', $officer->id)->where('is_published',1)->count();
            @endphp
            <div class="officer-card">
                <div class="officer-card-header">
                    <div class="officer-av">
                        {{ strtoupper(substr($officer->name, 0, 2)) }}
                    </div>
                    <div class="officer-name">{{ $officer->name }}</div>
                    <div class="officer-dist">📍 {{ $officer->district ?? 'N/A' }}</div>
                </div>
                <div class="officer-card-body">
                    <div class="officer-stats">
                        <div class="o-stat">
                            <div class="o-stat-num">{{ $apptCount }}</div>
                            <div class="o-stat-lbl">📅 Appointments</div>
                        </div>
                        <div class="o-stat">
                            <div class="o-stat-num">{{ $diagCount }}</div>
                            <div class="o-stat-lbl">🔬 Diagnoses</div>
                        </div>
                        <div class="o-stat">
                            <div class="o-stat-num">{{ $articleCount }}</div>
                            <div class="o-stat-lbl">📖 Articles</div>
                        </div>
                    </div>
                    <a href="{{ route('admin.reports.officer', $officer->id) }}"
                       class="btn-report" target="_blank">
                        📄 Generate PDF Report
                    </a>
                </div>
            </div>
            @empty
            <div class="empty-state">
                👮 No field officers registered yet.<br>
                <a href="{{ route('admin.users.create') }}" style="color:#1a5c2e;">Add an officer →</a>
            </div>
            @endforelse
        </div>
    </main>
</div>
@endsection