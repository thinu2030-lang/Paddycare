@extends('layouts.app')
@section('title', 'Start Harvest Tracker')

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
    .page-title { font-size: 22px; font-weight: 700; color: #1a2e1e; margin-bottom: 24px; }
    .form-card { background: #fff; border-radius: 12px; padding: 28px; border: 1px solid #e0e8e2; max-width: 600px; }
    .form-group { margin-bottom: 18px; }
    .form-label { display: block; font-size: 13px; font-weight: 500; color: #333; margin-bottom: 7px; }
    .form-control { width: 100%; padding: 10px 14px; border: 1.5px solid #d0ddd4; border-radius: 8px; font-size: 14px; color: #1a1a1a; background: #f8fdf9; transition: border-color 0.2s; }
    .form-control:focus { outline: none; border-color: #1a5c2e; background: #fff; }
    .btn-submit { background: #1a5c2e; color: #fff; padding: 12px 28px; border-radius: 8px; font-size: 14px; font-weight: 600; border: none; cursor: pointer; }
    .btn-submit:hover { background: #144a24; }
    .info-box { background: #e8f5e9; border-radius: 10px; padding: 16px; border: 1px solid #a5d6b0; margin-top: 16px; font-size: 12px; color: #3a7d4e; line-height: 1.6; }
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
        <a href="{{ route('farmer.crops') }}" class="sidebar-link active">🌾 Harvest Tracker</a>
        <div class="sidebar-section">Appointments</div>
        <a href="{{ route('farmer.appointments.create') }}" class="sidebar-link">📅 Book Appointment</a>
        <a href="{{ route('farmer.appointments') }}" class="sidebar-link">🗓 My Appointments</a>
        <div class="sidebar-section">Info</div>
        <a href="{{ route('articles') }}" class="sidebar-link">📖 Articles</a>
        <form method="POST" action="{{ route('logout') }}" style="margin-top:20px;">
            @csrf
            <button type="submit" class="sidebar-link" style="width:100%;background:none;border:none;cursor:pointer;text-align:left;">🚪 Logout</button>
        </form>
    </aside>

    <main class="main-content">
        <div class="page-title">🌾 Start Harvest Tracker</div>
        <div class="form-card">
            <form method="POST" action="{{ route('farmer.crops.store') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Select Seed Variety</label>
                    <select name="seed_id" class="form-control" required>
                        <option value="">-- Select Variety --</option>
                        @foreach($seeds as $seed)
                            <option value="{{ $seed->id }}">
                                {{ $seed->name }} — {{ $seed->district }} ({{ $seed->maturity_days }} days)
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Sowing / Transplanting Date</label>
                    <input type="date" name="sowing_date" class="form-control"
                           max="{{ date('Y-m-d') }}" required>
                </div>
                <button type="submit" class="btn-submit">🌱 Start Tracking</button>
            </form>
            <div class="info-box">
                ℹ️ Based on your sowing date and selected variety, the system will automatically calculate your full cultivation timeline — from land preparation to harvest day — with 10 key tasks and reminders.
            </div>
        </div>
    </main>
</div>
@endsection