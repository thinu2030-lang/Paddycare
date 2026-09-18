@extends('layouts.app')
@section('title', 'Harvest Tracker')

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
    .btn-primary { background: #1a5c2e; color: #fff; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
    .btn-primary:hover { background: #144a24; }

    .crop-card { background: #fff; border-radius: 14px; padding: 22px; border: 1px solid #e0e8e2; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 20px; }
    .crop-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; flex-wrap: wrap; gap: 10px; }
    .crop-title { font-size: 17px; font-weight: 700; color: #1a2e1e; }
    .crop-sub { font-size: 12px; color: #666; margin-top: 2px; }
    .btn-del { font-size: 12px; padding: 5px 12px; border-radius: 6px; border: 1px solid #f4c0d1; color: #993556; background: #fce4ec; cursor: pointer; }
    .btn-del:hover { background: #993556; color: #fff; }

    .countdown-banner { background: linear-gradient(135deg, #e8f5e9, #c8e6c9); border-radius: 10px; padding: 16px 20px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; flex-wrap: wrap; gap: 10px; }
    .countdown-days { font-size: 30px; font-weight: 800; color: #1a5c2e; }
    .countdown-label { font-size: 11px; color: #3a7d4e; text-transform: uppercase; letter-spacing: 0.5px; }
    .progress-bar-bg { flex: 1; min-width: 160px; height: 10px; background: #fff; border-radius: 20px; overflow: hidden; margin: 0 16px; }
    .progress-bar-fill { height: 10px; background: #1a5c2e; border-radius: 20px; transition: width 0.6s ease; }
    .progress-pct { font-size: 13px; font-weight: 600; color: #1a5c2e; }

    .timeline { position: relative; padding-left: 28px; }
    .timeline::before { content: ''; position: absolute; left: 9px; top: 6px; bottom: 6px; width: 2px; background: #d0ddd4; }
    .task-item { position: relative; padding-bottom: 18px; }
    .task-item:last-child { padding-bottom: 0; }
    .task-dot { position: absolute; left: -28px; top: 2px; width: 20px; height: 20px; border-radius: 50%; background: #fff; border: 2px solid #d0ddd4; display: flex; align-items: center; justify-content: center; font-size: 11px; }
    .task-dot.done { background: #1a5c2e; border-color: #1a5c2e; color: #fff; }
    .task-dot.today { border-color: #ba7517; background: #fff3e0; }
    .task-row { display: flex; align-items: center; gap: 12px; background: #f8fdf9; border-radius: 8px; padding: 10px 14px; border: 1px solid #e0e8e2; }
    .task-row.done { background: #f0fbf4; border-color: #a5d6b0; }
    .task-icon { font-size: 18px; }
    .task-title { font-size: 13px; font-weight: 600; color: #1a2e1e; }
    .task-title.done { text-decoration: line-through; color: #888; }
    .task-desc { font-size: 11px; color: #777; margin-top: 1px; }
    .task-date { font-size: 11px; color: #555; margin-left: auto; white-space: nowrap; }
    .task-check { width: 18px; height: 18px; border-radius: 50%; border: 1.5px solid #d0ddd4; cursor: pointer; flex-shrink: 0; }
    .task-check.done { background: #1a5c2e; border-color: #1a5c2e; }

    .empty-state { text-align: center; padding: 60px; color: #888; }
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
        <div class="page-header">
            <div class="page-title">🌾 Harvest Tracker</div>
            <a href="{{ route('farmer.crops.create') }}">
                <button class="btn-primary">➕ Start New Crop</button>
            </a>
        </div>

        @forelse($crops as $crop)
        <div class="crop-card">
            <div class="crop-header">
                <div>
                    <div class="crop-title">🌱 {{ $crop->seed_name }}</div>
                    <div class="crop-sub">
                        Sown: {{ $crop->sowing_date->format('M d, Y') }} ·
                        Expected Harvest: {{ $crop->harvest_date->format('M d, Y') }}
                    </div>
                </div>
                <form method="POST" action="{{ route('farmer.crops.destroy', $crop->id) }}"
                      onsubmit="return confirm('Remove this crop tracker?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-del">🗑 Remove</button>
                </form>
            </div>

            <div class="countdown-banner">
                <div>
                    <div class="countdown-days">
                        {{ $crop->days_to_harvest > 0 ? $crop->days_to_harvest : 0 }}
                    </div>
                    <div class="countdown-label">
                        {{ $crop->days_to_harvest > 0 ? 'Days to Harvest' : 'Ready / Past Harvest' }}
                    </div>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill" style="width: {{ $crop->progress_percent }}%;"></div>
                </div>
                <div class="progress-pct">{{ $crop->progress_percent }}% Complete</div>
            </div>

            <div class="timeline">
                @foreach($crop->tasks as $i => $task)
                @php $isToday = \Carbon\Carbon::now()->isSameDay($task['date']); @endphp
                <div class="task-item">
                    <div class="task-dot {{ $task['done'] ? 'done' : ($isToday ? 'today' : '') }}">
                        @if($task['done']) ✓ @endif
                    </div>
                    <div class="task-row {{ $task['done'] ? 'done' : '' }}">
                        <div class="task-icon">{{ $task['icon'] }}</div>
                        <div style="flex:1;">
                            <div class="task-title {{ $task['done'] ? 'done' : '' }}">{{ $task['title'] }}</div>
                            <div class="task-desc">{{ $task['desc'] }}</div>
                        </div>
                        <div class="task-date">{{ $task['date']->format('M d, Y') }}</div>
                        <form method="POST" action="{{ route('farmer.crops.toggle', $crop->id) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="field" value="{{ $task['field'] }}">
                            <button type="submit" class="task-check {{ $task['done'] ? 'done' : '' }}"
                                    style="border:none; padding:0;"
                                    title="{{ $task['done'] ? 'Mark as not done' : 'Mark as done' }}">
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="crop-card">
            <div class="empty-state">
                <span class="empty-icon">🌾</span>
                No active crop tracker yet.<br>
                <a href="{{ route('farmer.crops.create') }}" style="color:#1a5c2e; font-weight:600;">
                    Start tracking your harvest →
                </a>
            </div>
        </div>
        @endforelse
    </main>
</div>
@endsection