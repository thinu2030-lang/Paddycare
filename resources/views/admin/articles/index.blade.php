@extends('layouts.app')
@section('title', 'Manage Articles')

@push('styles')
<style>
    .dashboard-wrap { display: grid; grid-template-columns: 220px 1fr; min-height: calc(100vh - 100px); }
    .sidebar { background: #1a5c2e; padding: 24px 0; position: sticky; top: 60px; height: calc(100vh - 60px); overflow-y: auto; }
    .sidebar-user { padding: 0 20px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 12px; }
    .sidebar-avatar { width: 48px; height: 48px; background: #6fdc9e; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; color: #0a3318; margin-bottom: 10px; }
    .sidebar-name { color: #fff; font-weight: 600; font-size: 14px; }
    .sidebar-role { color: #a5d6b0; font-size: 12px; }
    .sidebar-section { font-size: 10px; color: #6fdc9e; letter-spacing: 1px; text-transform: uppercase; padding: 14px 20px 6px; }
    .sidebar-link { display: flex; align-items: center; gap: 10px; padding: 10px 20px; color: #a5d6b0; font-size: 13px; border-left: 3px solid transparent; transition: all 0.2s; text-decoration: none; }
    .sidebar-link:hover { background: rgba(255,255,255,0.08); color: #fff; }
    .sidebar-link.active { background: rgba(255,255,255,0.12); color: #fff; border-left-color: #6fdc9e; font-weight: 500; }
    .main-content { padding: 28px; background: #f4f6f4; }
    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
    .page-title { font-size: 22px; font-weight: 700; color: #1a2e1e; }
    .btn-primary { background: #1a5c2e; color: #fff; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
    .btn-primary:hover { background: #144a24; }
    .table-wrap { background: #fff; border-radius: 12px; border: 1px solid #e0e8e2; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
    table { width: 100%; border-collapse: collapse; }
    thead { background: #f0fbf4; }
    th { text-align: left; padding: 13px 16px; font-size: 12px; font-weight: 600; color: #1a5c2e; text-transform: uppercase; border-bottom: 1px solid #e0e8e2; }
    td { padding: 13px 16px; font-size: 13px; border-bottom: 1px solid #f0f4f1; vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #f8fdf9; }
    .badge { font-size: 11px; padding: 4px 12px; border-radius: 20px; font-weight: 500; }
    .tag-irrigation { background:#e3f2fd; color:#0c447c; }
    .tag-fertilizer { background:#f3e5f5; color:#6a1b9a; }
    .tag-weed       { background:#e8f5e9; color:#1a5c2e; }
    .tag-pest       { background:#fff3e0; color:#854f0b; }
    .published   { background: #e8f5e9; color: #1a5c2e; }
    .unpublished { background: #f5f5f5; color: #666; }
    .action-btns { display: flex; gap: 6px; }
    .btn-edit { font-size: 12px; padding: 5px 12px; border-radius: 6px; border: 1px solid #d0ddd4; color: #555; background: #f4f6f4; cursor: pointer; }
    .btn-edit:hover { border-color: #1a5c2e; color: #1a5c2e; }
    .btn-del { font-size: 12px; padding: 5px 12px; border-radius: 6px; border: 1px solid #f4c0d1; color: #993556; background: #fce4ec; cursor: pointer; }
    .btn-del:hover { background: #993556; color: #fff; }
    .empty-state { text-align: center; padding: 48px; color: #888; }
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
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 Dashboard</a>
        
        <div class="sidebar-section">Users</div>
        <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">👥 All Users</a>
        <a href="{{ route('admin.users.create') }}" class="sidebar-link {{ request()->routeIs('admin.users.create') ? 'active' : '' }}">➕ Add Officer</a>
        
        <div class="sidebar-section">Content</div>
        <a href="{{ route('admin.articles.index') }}" class="sidebar-link {{ request()->routeIs('admin.articles*') ? 'active' : '' }}">📖 Articles</a>
        <a href="{{ route('admin.diseases.index') }}" class="sidebar-link {{ request()->routeIs('admin.diseases*') ? 'active' : '' }}">🦠 Diseases</a>
        
        <div class="sidebar-section">Reports</div>
        <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">📊 Officer Reports</a>
        
        <form method="POST" action="{{ route('logout') }}" style="margin-top:20px;">
            @csrf
            <button type="submit" class="sidebar-link" style="width:100%;background:none;border:none;cursor:pointer;text-align:left;">🚪 Logout</button>
        </form>
    </aside>

    <main class="main-content">
        <div class="page-header">
            <div class="page-title">📖 Manage Articles</div>
            <a href="{{ route('admin.articles.create') }}">
                <button class="btn-primary">➕ Write Article</button>
            </a>
        </div>
        <div class="table-wrap">
            @if($articles->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Views</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $a)
                    <tr>
                        <td style="max-width:240px;">
                            <div style="font-weight:500; color:#1a2e1e;">{{ Str::limit($a->title,50) }}</div>
                        </td>
                        <td>
                            <span class="badge tag-{{ $a->category }}">
                                {{ ucfirst($a->category) }}
                            </span>
                        </td>
                        <td style="font-size:12px; color:#555;">{{ $a->author->name ?? '—' }}</td>
                        <td style="color:#666;">👁 {{ $a->views }}</td>
                        <td>
                            <span class="badge {{ $a->is_published ? 'published' : 'unpublished' }}">
                                {{ $a->is_published ? '✅ Published' : '⏸ Draft' }}
                            </span>
                        </td>
                        <td style="font-size:12px; color:#666;">{{ $a->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.articles.edit', $a->id) }}">
                                    <button class="btn-edit">✏️ Edit</button>
                                </a>
                                <form method="POST" action="{{ route('admin.articles.destroy', $a->id) }}"
                                      onsubmit="return confirm('Delete this article?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-del">🗑</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">📖 No articles yet. <a href="{{ route('admin.articles.create') }}" style="color:#1a5c2e;">Write first article →</a></div>
            @endif
        </div>
    </main>
</div>
@endsection