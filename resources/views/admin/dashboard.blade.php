@extends('layouts.app')
@section('title', 'Admin Dashboard')

@push('styles')
<style>
    .dashboard-wrap { display: grid; grid-template-columns: 220px 1fr; min-height: calc(100vh - 100px); }
    .sidebar { background: #1a5c2e; padding: 24px 0; position: sticky; top: 60px; height: calc(100vh - 60px); overflow-y: auto; }
    .sidebar-user { padding: 0 20px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 12px; }
    .sidebar-avatar { width: 48px; height: 48px; background: #6fdc9e; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; color: #0a3318; margin-bottom: 10px; }
    .sidebar-name { color: #fff; font-weight: 600; font-size: 14px; }
    .sidebar-role { color: #a5d6b0; font-size: 12px; margin-top: 2px; }
    .sidebar-section { font-size: 10px; color: #6fdc9e; letter-spacing: 1px; text-transform: uppercase; padding: 14px 20px 6px; }
    .sidebar-link { display: flex; align-items: center; gap: 10px; padding: 10px 20px; color: #a5d6b0; font-size: 13px; border-left: 3px solid transparent; transition: all 0.2s; background: none; border: none; width: 100%; text-align: left; cursor: pointer; text-decoration: none; }
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
    .content-grid { display: grid; grid-template-columns: 1.2fr 1fr; gap: 20px; }
    .card { background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #e0e8e2; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 20px; }
    .card-title { font-size: 15px; font-weight: 600; color: #1a2e1e; margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between; }
    .user-row { display: flex; align-items: center; gap: 12px; padding: 10px 0; border-bottom: 1px solid #f0f4f1; }
    .user-row:last-child { border-bottom: none; }
    .user-av { width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0; }
    .user-name { font-size: 13px; font-weight: 500; color: #1a2e1e; }
    .user-sub  { font-size: 11px; color: #666; }
    .badge { font-size: 11px; padding: 3px 10px; border-radius: 20px; font-weight: 500; }
    .badge-farmer  { background: #e8f5e9; color: #1a5c2e; }
    .badge-officer { background: #e6f1fb; color: #185fa5; }
    .badge-admin   { background: #f0fbf4; color: #1a5c2e; }
    .action-btns { display: flex; gap: 6px; margin-left: auto; }
    .btn-edit { font-size: 11px; padding: 4px 10px; border-radius: 6px; border: 1px solid #d0ddd4; color: #555; background: #f4f6f4; cursor: pointer; }
    .btn-del  { font-size: 11px; padding: 4px 10px; border-radius: 6px; border: 1px solid #f4c0d1; color: #993556; background: #fce4ec; cursor: pointer; }
    .btn-primary { background: #1a5c2e; color: #fff; padding: 7px 14px; border-radius: 7px; font-size: 12px; font-weight: 600; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; }
    .btn-primary:hover { background: #144a24; }
    .quick-links { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .quick-link {
        background: #f8fdf9; border: 1.5px solid #c8e6c9; border-radius: 10px;
        padding: 16px; text-align: center; cursor: pointer; transition: all 0.2s;
        display: block; color: #1a2e1e; text-decoration: none;
    }
    .quick-link:hover { border-color: #1a5c2e; background: #f0fbf4; transform: translateY(-2px); }
    .ql-icon { font-size: 28px; display: block; margin-bottom: 8px; }
    .ql-label { font-size: 13px; font-weight: 500; }
    .system-health { display: flex; flex-direction: column; gap: 10px; }
    .health-item { display: flex; align-items: center; gap: 12px; padding: 10px; background: #f8fdf9; border-radius: 8px; border: 1px solid #e0e8e2; }
    .health-dot { width: 10px; height: 10px; border-radius: 50%; background: #1a5c2e; flex-shrink: 0; }
    .health-label { font-size: 13px; color: #333; flex: 1; }
    .health-status { font-size: 12px; color: #1a5c2e; font-weight: 500; }
</style>
@endpush

@section('content')
<div class="dashboard-wrap">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-user">
            <div class="sidebar-avatar">AD</div>
            <div class="sidebar-name">Administrator</div>
            <div class="sidebar-role">🛡️ System Admin</div>
        </div>
        
        <div class="sidebar-section">Overview</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 Dashboard</a>
        
        <div class="sidebar-section">Users</div>
        <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">👥 All Users</a>
        <a href="{{ route('admin.users.create') }}" class="sidebar-link {{ request()->routeIs('admin.users.create') ? 'active' : '' }}">➕ Add Officer</a>
        
        <div class="sidebar-section">Content</div>
        <a href="{{ route('admin.articles.index') }}" class="sidebar-link {{ request()->routeIs('admin.articles*') ? 'active' : '' }}">📖 Articles</a>
        <a href="{{ route('admin.diseases.index') }}" class="sidebar-link {{ request()->routeIs('admin.diseases*') ? 'active' : '' }}">🦠 Diseases</a>
        
        <!-- Reports Section Added Here -->
        <div class="sidebar-section">Reports</div>
        <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">📊 Officer Reports</a>

        <form method="POST" action="{{ route('logout') }}" style="margin-top:20px;">
            @csrf
            <button type="submit" class="sidebar-link">🚪 Logout</button>
        </form>
    </aside>

    <!-- MAIN MAIN CONTENT CONTAINER -->
    <main class="main-content">
        <div class="page-title">🛡️ Admin Control Panel</div>
        <div class="page-sub">SLIATE Gampaha · PaddyCare System · {{ now()->format('l, F j, Y') }}</div>

        <!-- STATS CARDS -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">👥 Total Users</div>
                <div class="stat-value" style="color:#1a5c2e;">{{ $totalUsers }}</div>
                <div class="stat-sub">All registered users</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">👮 Field Officers</div>
                <div class="stat-value" style="color:#185fa5;">{{ $totalOfficers }}</div>
                <div class="stat-sub">Active officers</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">📷 Total Scans</div>
                <div class="stat-value" style="color:#1a5c2e;">{{ $totalScans }}</div>
                <div class="stat-sub">Disease diagnoses</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">🦠 Diseases in DB</div>
                <div class="stat-value" style="color:#993556;">{{ $totalDiseases }}</div>
                <div class="stat-sub">Tracked diseases</div>
            </div>
        </div>

        <div class="content-grid">
            <!-- RECENT USERS CARD -->
            <div>
                <div class="card">
                    <div class="card-title">
                        <span>👥 Recent Users</span>
                        <a href="{{ route('admin.users.create') }}">
                            <button class="btn-primary">➕ Add Officer</button>
                        </a>
                    </div>
                    @foreach($recentUsers as $u)
                    <div class="user-row">
                        <div class="user-av"
                             style="background:{{ $u->role === 'admin' ? '#f0fbf4' : ($u->role === 'officer' ? '#e6f1fb' : '#e8f5e9') }};
                                    color:{{ $u->role === 'admin' ? '#1a5c2e' : ($u->role === 'officer' ? '#185fa5' : '#1a5c2e') }}">
                            {{ strtoupper(substr($u->name,0,2)) }}
                        </div>
                        <div>
                            <div class="user-name">{{ $u->name }}</div>
                            <div class="user-sub">📍 {{ $u->district }} · {{ $u->created_at->format('M d') }}</div>
                        </div>
                        <span class="badge badge-{{ $u->role }}">{{ ucfirst($u->role) }}</span>
                        <div class="action-btns">
                            <a href="{{ route('admin.users.edit', $u->id) }}">
                                <button class="btn-edit">✏️ Edit</button>
                            </a>
                            <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}"
                                  onsubmit="return confirm('Delete this user?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-del">🗑</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                    <div style="margin-top:14px; text-align:center;">
                        <a href="{{ route('admin.users.index') }}" style="font-size:13px; color:#1a5c2e; font-weight:500; text-decoration:none;">View all users →</a>
                    </div>
                </div>
            </div>

            <!-- QUICK LINKS & SYSTEM HEALTH -->
            <div>
                <!-- QUICK ACTIONS -->
                <div class="card">
                    <div class="card-title"><span>⚡ Quick Actions</span></div>
                    <div class="quick-links">
                        <a href="{{ route('admin.users.create') }}" class="quick-link">
                            <span class="ql-icon">👮</span>
                            <span class="ql-label">Add Officer</span>
                        </a>
                        <a href="{{ route('admin.diseases.create') }}" class="quick-link">
                            <span class="ql-icon">🦠</span>
                            <span class="ql-label">Add Disease</span>
                        </a>
                        <a href="{{ route('admin.articles.create') }}" class="quick-link">
                            <span class="ql-icon">📝</span>
                            <span class="ql-label">Write Article</span>
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="quick-link">
                            <span class="ql-icon">👥</span>
                            <span class="ql-label">Manage Users</span>
                        </a>
<a href="{{ route('admin.reports.index') }}" class="quick-link">
    <span class="ql-icon">📊</span>
    <span class="ql-label">Officer Reports</span>
</a>                           
                    </div>
                </div>

                <!-- SYSTEM STATUS -->
                <div class="card">
                    <div class="card-title"><span>⚙️ System Status</span></div>
                    <div class="system-health">
                        <div class="health-item">
                            <div class="health-dot"></div>
                            <span class="health-label">🌐 Web Server</span>
                            <span class="health-status">✅ Online</span>
                        </div>
                        <div class="health-item">
                            <div class="health-dot"></div>
                            <span class="health-label">🗄️ Database</span>
                            <span class="health-status">✅ Connected</span>
                        </div>
                        <div class="health-item">
                            <div class="health-dot" style="background:#854f0b;"></div>
                            <span class="health-label">🤖 AI Flask API</span>
                            <span class="health-status" style="color:#854f0b;">⚠️ Not Started</span>
                        </div>
                        <div class="health-item">
                            <div class="health-dot"></div>
                            <span class="health-label">📁 File Storage</span>
                            <span class="health-status">✅ Ready</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection