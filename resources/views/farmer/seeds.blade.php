@extends('layouts.app')
@section('title', 'Seed Guide')

@push('styles')
<style>
    .dashboard-wrap { display: grid; grid-template-columns: 220px 1fr; min-height: calc(100vh - 100px); }
    .sidebar { background: #1a5c2e; padding: 24px 0; position: sticky; top: 60px; height: calc(100vh - 60px); overflow-y: auto; }
    .sidebar-user { padding: 0 20px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 12px; }
    .sidebar-avatar { width: 48px; height: 48px; background: #6fdc9e; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; color: #0a3318; margin-bottom: 10px; }
    .sidebar-name { color: #fff; font-weight: 600; font-size: 14px; }
    .sidebar-role { color: #6fdc9e; font-size: 12px; }
    .sidebar-section { font-size: 10px; color: #6fdc9e; letter-spacing: 1px; text-transform: uppercase; padding: 14px 20px 6px; }
    .sidebar-link { display: flex; align-items: center; gap: 10px; padding: 10px 20px; color: #a5d6b0; font-size: 13px; border-left: 3px solid transparent; transition: all 0.2s; }
    .sidebar-link:hover { background: rgba(255,255,255,0.08); color: #fff; }
    .sidebar-link.active { background: rgba(255,255,255,0.12); color: #fff; border-left-color: #6fdc9e; font-weight: 500; }
    .main-content { padding: 28px; background: #f4f6f4; }
    .page-title { font-size: 22px; font-weight: 700; color: #1a2e1e; margin-bottom: 4px; }
    .page-sub   { font-size: 13px; color: #666; margin-bottom: 24px; }

    /* FILTER BAR */
    .filter-bar {
        background: #fff; border-radius: 12px; padding: 20px;
        border: 1px solid #e0e8e2; margin-bottom: 20px;
        display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap;
    }
    .filter-group { flex: 1; min-width: 160px; }
    .filter-label { font-size: 12px; font-weight: 500; color: #555; margin-bottom: 6px; display: block; }
    .filter-control {
        width: 100%; padding: 9px 12px;
        border: 1.5px solid #d0ddd4; border-radius: 8px;
        font-size: 13px; color: #1a1a1a; background: #f8fdf9;
    }
    .filter-control:focus { outline: none; border-color: #1a5c2e; }
    .btn-filter {
        background: #1a5c2e; color: #fff; padding: 9px 20px;
        border-radius: 8px; font-size: 13px; font-weight: 600;
        border: none; cursor: pointer; white-space: nowrap;
    }

    /* SEED CARDS */
    .seeds-grid { display: grid; grid-template-columns: repeat(2,1fr); gap: 16px; }
    .seed-card {
        background: #fff; border-radius: 12px;
        border: 1px solid #e0e8e2;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        overflow: hidden; transition: transform 0.2s, box-shadow 0.2s;
    }
    .seed-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(26,92,46,0.1); }
    .seed-card.recommended { border: 2px solid #1a5c2e; }

    .seed-card-header {
        background: linear-gradient(135deg, #e8f5e9, #f0fbf4);
        padding: 20px; display: flex; align-items: center; gap: 14px;
        border-bottom: 1px solid #e0e8e2;
    }
    .seed-icon {
        width: 52px; height: 52px; border-radius: 12px;
        background: #fff; display: flex; align-items: center;
        justify-content: center; font-size: 26px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .seed-name { font-size: 20px; font-weight: 700; color: #1a2e1e; }
    .seed-season { font-size: 12px; color: #3a7d4e; margin-top: 3px; }
    .rec-badge {
        margin-left: auto; background: #1a5c2e; color: #fff;
        font-size: 11px; padding: 4px 10px; border-radius: 20px;
        font-weight: 600; white-space: nowrap;
    }

    .seed-card-body { padding: 18px; }
    .seed-attrs {
        display: grid; grid-template-columns: repeat(3,1fr);
        gap: 10px; margin-bottom: 14px;
    }
    .attr-box {
        background: #f8fdf9; border-radius: 8px;
        padding: 10px; text-align: center;
        border: 1px solid #e0e8e2;
    }
    .attr-val { font-size: 18px; font-weight: 700; color: #1a2e1e; }
    .attr-lbl { font-size: 10px; color: #666; margin-top: 3px; text-transform: uppercase; letter-spacing: 0.3px; }

    .resist-badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;
    }
    .resist-high   { background: #e8f5e9; color: #1a5c2e; }
    .resist-medium { background: #fff3e0; color: #854f0b; }
    .resist-low    { background: #fce4ec; color: #993556; }

    .seed-desc { font-size: 13px; color: #555; line-height: 1.6; margin-top: 12px; }

    .empty-state { text-align: center; padding: 48px; color: #888; font-size: 14px; }
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
        <a href="{{ route('farmer.seeds') }}" class="sidebar-link active">🌱 Seed Guide</a>
        <a href="{{ route('farmer.crops') }}" class="sidebar-link">🌾 Harvest Tracker</a>
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
        <div class="page-title">🌱 Seed Recommendation Guide</div>
        <div class="page-sub">Find the best paddy variety for your district and season</div>

        <!-- FILTER -->
        <form method="GET" action="{{ route('farmer.seeds') }}">
            <div class="filter-bar">
                <div class="filter-group">
                    <label class="filter-label">📍 District</label>
                    <select name="district" class="filter-control">
                        @foreach($districts as $d)
                            <option value="{{ $d }}" {{ $district === $d ? 'selected' : '' }}>
                                {{ $d }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">🌤 Season</label>
                    <select name="season" class="filter-control">
                        <option value="Yala"  {{ $season === 'Yala'  ? 'selected' : '' }}>Yala (May–Sep)</option>
                        <option value="Maha"  {{ $season === 'Maha'  ? 'selected' : '' }}>Maha (Oct–Feb)</option>
                        <option value="Both"  {{ $season === 'Both'  ? 'selected' : '' }}>Both Seasons</option>
                    </select>
                </div>
                <button type="submit" class="btn-filter">🔍 Find Seeds</button>
            </div>
        </form>

        <!-- RESULTS -->
        @if($seeds->count() > 0)
        <div class="seeds-grid">
            @foreach($seeds as $seed)
            <div class="seed-card {{ $seed->is_recommended ? 'recommended' : '' }}">
                <div class="seed-card-header">
                    <div class="seed-icon">🌾</div>
                    <div>
                        <div class="seed-name">{{ $seed->name }}</div>
                        <div class="seed-season">
                            🌤 {{ $seed->season }} · 📍 {{ $seed->district }}
                        </div>
                    </div>
                    @if($seed->is_recommended)
                        <span class="rec-badge">⭐ Recommended</span>
                    @endif
                </div>
                <div class="seed-card-body">
                    <div class="seed-attrs">
                        <div class="attr-box">
                            <div class="attr-val">{{ $seed->maturity_days }}</div>
                            <div class="attr-lbl">Days to Harvest</div>
                        </div>
                        <div class="attr-box">
                            <div class="attr-val">{{ $seed->yield_per_ha }}t</div>
                            <div class="attr-lbl">Yield per Ha</div>
                        </div>
                        <div class="attr-box">
                            <span class="resist-badge resist-{{ strtolower($seed->blast_resistance) }}">
                                {{ $seed->blast_resistance === 'High' ? '🛡️' : ($seed->blast_resistance === 'Medium' ? '⚠️' : '❗') }}
                                {{ $seed->blast_resistance }}
                            </span>
                            <div class="attr-lbl" style="margin-top:4px;">Blast Resist.</div>
                        </div>
                    </div>
                    @if($seed->description)
                        <div class="seed-desc">{{ $seed->description }}</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">
            🌱 No seeds found for <strong>{{ $district }}</strong> — {{ $season }} season.<br>
            <span style="font-size:12px; margin-top:8px; display:block;">Try a different district or season.</span>
        </div>
        @endif
    </main>
</div>
@endsection