@extends('layouts.app')
@section('title', 'Manage Users')

@push('styles')
<style>
    .dashboard-wrap { display: grid; grid-template-columns: 220px 1fr; min-height: calc(100vh - 100px); }
    .sidebar { background: #1a5c2e; padding: 24px 0; position: sticky; top: 60px; height: calc(100vh - 60px); overflow-y: auto; }
    .sidebar-user { padding: 0 20px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 12px; }
    .sidebar-avatar { width: 48px; height: 48px; background: #6fdc9e; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; color: #0a3318; margin-bottom: 10px; }
    .sidebar-name { color: #fff; font-weight: 600; font-size: 14px; }
    .sidebar-role { color: #a5d6b0; font-size: 12px; }
    .sidebar-section { font-size: 10px; color: #6fdc9e; letter-spacing: 1px; text-transform: uppercase; padding: 14px 20px 6px; }
    .sidebar-link { display: flex; align-items: center; gap: 10px; padding: 10px 20px; color: #a5d6b0; font-size: 13px; border-left: 3px solid transparent; transition: all 0.2s; background: none; border: none; width: 100%; text-align: left; cursor: pointer; text-decoration: none; }
    .sidebar-link:hover { background: rgba(255,255,255,0.08); color: #fff; }
    .sidebar-link.active { background: rgba(255,255,255,0.12); color: #fff; border-left-color: #6fdc9e; font-weight: 500; }
    .main-content { padding: 28px; background: #f4f6f4; }
    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
    .page-title { font-size: 22px; font-weight: 700; color: #1a2e1e; }
    .btn-primary { background: #1a5c2e; color: #fff; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: background 0.2s; }
    .btn-primary:hover { background: #144a24; }

    .filter-bar { background: #fff; border-radius: 12px; padding: 16px 20px; border: 1px solid #e0e8e2; margin-bottom: 20px; display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
    .filter-input { padding: 8px 12px; border: 1.5px solid #d0ddd4; border-radius: 8px; font-size: 13px; color: #1a1a1a; background: #f8fdf9; min-width: 200px; }
    .filter-input:focus { outline: none; border-color: #1a5c2e; }
    .filter-select { padding: 8px 12px; border: 1.5px solid #d0ddd4; border-radius: 8px; font-size: 13px; color: #1a1a1a; background: #f8fdf9; }
    .filter-select:focus { outline: none; border-color: #1a5c2e; }

    .table-wrap { background: #fff; border-radius: 12px; border: 1px solid #e0e8e2; box-shadow: 0 2px 8px rgba(0,0,0,0.04); overflow: hidden; }
    table { width: 100%; border-collapse: collapse; }
    thead { background: #f0fbf4; }
    th { text-align: left; padding: 13px 16px; font-size: 12px; font-weight: 600; color: #1a5c2e; text-transform: uppercase; letter-spacing: 0.4px; border-bottom: 1px solid #e0e8e2; }
    td { padding: 13px 16px; font-size: 13px; color: #1a2e1e; border-bottom: 1px solid #f0f4f1; vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #f8fdf9; }

    .user-cell { display: flex; align-items: center; gap: 10px; }
    .user-av { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; flex-shrink: 0; }
    .user-name { font-size: 13px; font-weight: 500; }
    .user-email { font-size: 11px; color: #666; }

    .badge { font-size: 11px; padding: 4px 12px; border-radius: 20px; font-weight: 500; }
    .badge-farmer  { background: #e8f5e9; color: #1a5c2e; }
    .badge-officer { background: #e6f1fb; color: #185fa5; }
    .badge-admin   { background: #f0fbf4; color: #1a5c2e; }

    .action-btns { display: flex; gap: 6px; }
    .btn-edit { font-size: 12px; padding: 5px 12px; border-radius: 6px; border: 1px solid #d0ddd4; color: #555; background: #f4f6f4; cursor: pointer; transition: all 0.2s; }
    .btn-edit:hover { border-color: #1a5c2e; color: #1a5c2e; }
    .btn-del { font-size: 12px; padding: 5px 12px; border-radius: 6px; border: 1px solid #f4c0d1; color: #993556; background: #fce4ec; cursor: pointer; transition: all 0.2s; }
    .btn-del:hover { background: #993556; color: #fff; }

    .empty-state { text-align: center; padding: 48px; color: #888; font-size: 14px; }
    .pagination-wrap { padding: 16px 20px; border-top: 1px solid #f0f4f1; }
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

    <!-- MAIN CONTENT CONTAINER -->
    <main class="main-content">
        <div class="page-header">
            <div class="page-title">👥 All Users</div>
            <a href="{{ route('admin.users.create') }}">
                <button class="btn-primary">➕ Add New Officer</button>
            </a>
        </div>

        <!-- FILTER BAR -->
        <div class="filter-bar">
            <input type="text" class="filter-input" id="searchInput"
                   placeholder="🔍 Search by name or email..." onkeyup="filterTable()">
            <select class="filter-select" id="roleFilter" onchange="filterTable()">
                <option value="">All Roles</option>
                <option value="admin">Admin</option>
                <option value="officer">Officer</option>
                <option value="farmer">Farmer</option>
            </select>
        </div>

        <!-- USERS TABLE CONTAINER -->
        <div class="table-wrap">
            @if($users->count() > 0)
            <table id="usersTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>District</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                    <tr>
                        <td style="color:#888; font-size:12px;">{{ $u->id }}</td>
                        <td>
                            <div class="user-cell">
                                <div class="user-av"
                                     style="background:{{ $u->role==='admin'?'#f0fbf4':($u->role==='officer'?'#e6f1fb':'#e8f5e9') }};
                                            color:{{ $u->role==='admin'?'#1a5c2e':($u->role==='officer'?'#185fa5':'#1a5c2e') }}">
                                    {{ strtoupper(substr($u->name,0,2)) }}
                                </div>
                                <div>
                                    <div class="user-name">{{ $u->name }}</div>
                                    <div class="user-email">{{ $u->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>📍 {{ $u->district ?? '—' }}</td>
                        <td style="color:#555;">{{ $u->phone ?? '—' }}</td>
                        <td>
                            <span class="badge badge-{{ $u->role }}">
                                {{ $u->role==='admin'?'🛡️':($u->role==='officer'?'👮':'🌾') }}
                                {{ ucfirst($u->role) }}
                            </span>
                        </td>
                        <td style="color:#666; font-size:12px;">{{ $u->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.users.edit', $u->id) }}">
                                    <button class="btn-edit">✏️ Edit</button>
                                </a>
                                @if($u->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}"
                                      onsubmit="return confirm('Delete {{ $u->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-del">🗑 Delete</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination-wrap">{{ $users->links() }}</div>
            @else
            <div class="empty-state">👥 No users found.</div>
            @endif
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
function filterTable() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const role   = document.getElementById('roleFilter').value.toLowerCase();
    const rows   = document.querySelectorAll('#usersTable tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const matchSearch = text.includes(search);
        const matchRole   = role === '' || text.includes(role);
        row.style.display = matchSearch && matchRole ? '' : 'none';
    });
}
</script>
@endpush