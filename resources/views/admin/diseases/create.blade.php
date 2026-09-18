@extends('layouts.app')
@section('title', 'Add Disease')

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
    .page-title { font-size: 22px; font-weight: 700; color: #1a2e1e; margin-bottom: 24px; }
    .form-card { background: #fff; border-radius: 12px; padding: 28px; border: 1px solid #e0e8e2; max-width: 700px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-group { margin-bottom: 18px; }
    .form-label { display: block; font-size: 13px; font-weight: 500; color: #333; margin-bottom: 7px; }
    .form-control { width: 100%; padding: 10px 14px; border: 1.5px solid #d0ddd4; border-radius: 8px; font-size: 13px; color: #1a1a1a; background: #f8f9fa; transition: border-color 0.2s; }
    .form-control:focus { outline: none; border-color: #993556; background: #fff; }
    .btn-submit { background: #993556; color: #fff; padding: 12px 28px; border-radius: 8px; font-size: 14px; font-weight: 600; border: none; cursor: pointer; }
    .btn-submit:hover { background: #7a2843; }
    .btn-back { background: transparent; color: #555; padding: 12px 20px; border-radius: 8px; font-size: 14px; border: 1.5px solid #d0ddd4; cursor: pointer; }
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
        <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">👥 All Users</a>
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
        <div class="page-title">➕ Add New Disease</div>
        <div class="form-card">
            <form method="POST" action="{{ route('admin.diseases.store') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Disease Name</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name') }}" placeholder="e.g. Blast Disease" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Scientific Name</label>
                        <input type="text" name="scientific_name" class="form-control"
                               value="{{ old('scientific_name') }}" placeholder="e.g. Pyricularia oryzae">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Severity Level</label>
                        <select name="severity_level" class="form-control" required>
                            <option value="high"   {{ old('severity_level')==='high'  ?'selected':'' }}>🔴 High</option>
                            <option value="medium" {{ old('severity_level')==='medium'?'selected':'' }}>🟡 Medium</option>
                            <option value="low"    {{ old('severity_level')==='low'   ?'selected':'' }}>🟢 Low</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"
                              placeholder="Describe symptoms and affected parts..." required>{{ old('description') }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">🧪 Chemical Treatment</label>
                    <textarea name="chemical_treatment" class="form-control" rows="3"
                              placeholder="Chemical treatments, dosage, frequency..." required>{{ old('chemical_treatment') }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">🌿 Organic Treatment</label>
                    <textarea name="organic_treatment" class="form-control" rows="3"
                              placeholder="Natural remedies, bio-fungicides..." required>{{ old('organic_treatment') }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">♻️ IPM Advice</label>
                    <textarea name="ipm_advice" class="form-control" rows="3"
                              placeholder="Integrated Pest Management practices..." required>{{ old('ipm_advice') }}</textarea>
                </div>
                <div style="display:flex; gap:10px; margin-top:8px;">
                    <button type="submit" class="btn-submit">✅ Add Disease</button>
                    <a href="{{ route('admin.diseases.index') }}">
                        <button type="button" class="btn-back">← Back</button>
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection