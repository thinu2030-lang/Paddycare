@extends('layouts.app')
@section('title', 'Add User')

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
    .form-card { background: #fff; border-radius: 12px; padding: 28px; border: 1px solid #e0e8e2; box-shadow: 0 2px 8px rgba(0,0,0,0.04); max-width: 640px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-group { margin-bottom: 18px; }
    .form-label { display: block; font-size: 13px; font-weight: 500; color: #333; margin-bottom: 7px; }
    .form-control { width: 100%; padding: 10px 14px; border: 1.5px solid #d0ddd4; border-radius: 8px; font-size: 14px; color: #1a1a1a; background: #f8fdf9; transition: border-color 0.2s; }
    .form-control:focus { outline: none; border-color: #1a5c2e; background: #fff; }
    .btn-submit { background: #1a5c2e; color: #fff; padding: 12px 28px; border-radius: 8px; font-size: 14px; font-weight: 600; border: none; cursor: pointer; transition: background 0.2s; }
    .btn-submit:hover { background: #144a24; }
    .btn-back { background: transparent; color: #555; padding: 12px 20px; border-radius: 8px; font-size: 14px; border: 1.5px solid #d0ddd4; cursor: pointer; margin-left: 10px; }
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
        <a href="{{ route('admin.users.create') }}" class="sidebar-link active">➕ Add Officer</a>
        <div class="sidebar-section">Content</div>
        <a href="{{ route('admin.articles.index') }}" class="sidebar-link">📖 Articles</a>
        <a href="{{ route('admin.diseases.index') }}" class="sidebar-link">🦠 Diseases</a>
        <form method="POST" action="{{ route('logout') }}" style="margin-top:20px;">
            @csrf
            <button type="submit" class="sidebar-link" style="width:100%;background:none;border:none;cursor:pointer;text-align:left;">🚪 Logout</button>
        </form>
    </aside>

    <main class="main-content">
        <div class="page-title">➕ Add New User / Officer</div>
        <div class="form-card">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name') }}" placeholder="S. Perera" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control"
                               value="{{ old('phone') }}" placeholder="077xxxxxxx">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email') }}" placeholder="officer@paddycare.lk" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">District</label>
                        <select name="district" class="form-control" required>
                            <option value="">-- Select --</option>
                            @foreach(['Colombo','Gampaha','Kalutara','Kandy','Matale','Nuwara Eliya','Galle','Matara','Hambantota','Jaffna','Kurunegala','Puttalam','Anuradhapura','Polonnaruwa','Badulla','Moneragala','Ratnapura','Kegalle'] as $d)
                                <option value="{{ $d }}" {{ old('district')===$d?'selected':'' }}>{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-control" required>
                            <option value="officer" {{ old('role')==='officer'?'selected':'' }}>👮 Officer</option>
                            <option value="farmer"  {{ old('role')==='farmer' ?'selected':'' }}>🌾 Farmer</option>
                            <option value="admin"   {{ old('role')==='admin'  ?'selected':'' }}>🛡️ Admin</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="Min 6 characters" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="Repeat password" required>
                    </div>
                </div>
                <div style="display:flex; align-items:center; gap:10px; margin-top:8px;">
                    <button type="submit" class="btn-submit">✅ Create User</button>
                    <a href="{{ route('admin.users.index') }}">
                        <button type="button" class="btn-back">← Back</button>
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection