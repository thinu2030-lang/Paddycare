@extends('layouts.app')
@section('title', 'Review Diagnoses')

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

    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
    .page-title { font-size: 22px; font-weight: 700; color: #1a2e1e; }
    .page-sub { font-size: 13px; color: #666; margin-top: 4px; }

    .card { background: #fff; border-radius: 12px; border: 1px solid #e0e8e2; box-shadow: 0 2px 8px rgba(0,0,0,0.04); overflow: hidden; }
    table { width: 100%; border-collapse: collapse; }
    thead { background: #f0fbf4; }
    th { text-align: left; padding: 13px 16px; font-size: 12px; font-weight: 600; color: #1a5c2e; text-transform: uppercase; border-bottom: 1px solid #e0e8e2; }
    td { padding: 13px 16px; font-size: 13px; border-bottom: 1px solid #f0f4f1; vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #f8fdf9; }

    .badge { font-size: 11px; padding: 4px 12px; border-radius: 20px; font-weight: 500; }
    .badge-pending  { background: #faeeda; color: #854f0b; }
    .badge-reviewed { background: #e8f5e9; color: #1a5c2e; }

    .btn-review {
        font-size: 12px; padding: 6px 16px; border-radius: 6px;
        border: none; color: #fff; background: #1a5c2e;
        cursor: pointer; font-weight: 500; transition: all 0.2s;
        white-space: nowrap;
    }
    .btn-review:hover { background: #144a24; }

    .thumb { width: 48px; height: 48px; border-radius: 8px; object-fit: cover; border: 1px solid #e0e8e2; }

    .farmer-info { display: flex; flex-direction: column; gap: 2px; }
    .farmer-name { font-weight: 600; color: #1a2e1e; font-size: 13px; }
    .farmer-dist { font-size: 11px; color: #666; }

    .disease-tag { display: inline-flex; align-items: center; gap: 4px; }
    .disease-sick    { color: #993556; font-weight: 500; }
    .disease-healthy { color: #1a5c2e; font-weight: 500; }

    .conf-high { color: #993556; font-weight: 700; }
    .conf-med  { color: #854f0b; font-weight: 700; }
    .conf-low  { color: #1a5c2e; font-weight: 700; }

    .empty-state { text-align: center; padding: 60px; color: #888; }
    .empty-icon  { font-size: 48px; margin-bottom: 12px; }
    .empty-text  { font-size: 15px; font-weight: 500; color: #555; margin-bottom: 6px; }
    .empty-sub   { font-size: 13px; color: #888; }

    /* PAGINATION */
    .pagination-wrap {
        display: flex; gap: 8px; align-items: center;
        padding: 16px; font-size: 13px;
    }
    .page-btn {
        padding: 6px 14px; border-radius: 6px;
        font-size: 13px; font-weight: 500;
        text-decoration: none; transition: all 0.2s;
    }
    .page-btn-active {
        background: #1a5c2e; color: #fff;
    }
    .page-btn-active:hover { background: #144a24; color: #fff; }
    .page-btn-disabled {
        background: #f0f4f1; color: #aaa; cursor: not-allowed;
    }
    .page-info { color: #666; font-size: 13px; }
</style>
@endpush

@section('content')
<div class="dashboard-wrap">
    <aside class="sidebar">
        <div class="sidebar-user">
            <div class="sidebar-avatar">{{ strtoupper(substr(auth()->user()->name,0,2)) }}</div>
            <div class="sidebar-name">{{ auth()->user()->name }}</div>
            <div class="sidebar-role">👮 Field Officer</div>
        </div>
        <div class="sidebar-section">Main</div>
        <a href="{{ route('officer.dashboard') }}" class="sidebar-link">📊 Dashboard</a>
        <div class="sidebar-section">Work</div>
        <a href="{{ route('officer.appointments') }}" class="sidebar-link">📅 Appointments</a>
        <a href="{{ route('officer.diagnoses') }}" class="sidebar-link active">🔬 Diagnoses</a>
        <div class="sidebar-section">Content</div>
        <a href="{{ route('officer.articles.index') }}" class="sidebar-link">📖 Articles</a>
        <div class="sidebar-section">Notifications</div>
        <a href="{{ route('officer.notifications.index') }}" class="sidebar-link">📧 Notify Farmers</a>
        <div class="sidebar-section">Info</div>
        <a href="{{ route('articles') }}" class="sidebar-link">🌐 Public Articles</a>
        <form method="POST" action="{{ route('logout') }}" style="margin-top:20px;">
            @csrf
            <button type="submit" class="sidebar-link"
                    style="width:100%;background:none;border:none;cursor:pointer;text-align:left;">
                🚪 Logout
            </button>
        </form>
    </aside>

    <main class="main-content">
        <div class="page-header">
            <div>
                <div class="page-title">🔬 Diagnoses Awaiting Review</div>
                <div class="page-sub">
                    Farmers who have requested expert advice — review and send recommendations
                </div>
            </div>
            <div style="background:#faeeda; border:1px solid #f5c97a; border-radius:8px; padding:10px 18px; font-size:13px; color:#854f0b; font-weight:500;">
                ⏳ {{ $diagnoses->total() }} Pending Reviews
            </div>
        </div>

        <div class="card">
            @if($diagnoses->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Leaf Image</th>
                        <th>Farmer</th>
                        <th>Disease Detected</th>
                        <th>Confidence</th>
                        <th>Submitted</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($diagnoses as $d)
                    <tr>
                        <td>
                            @if($d->image_path)
                                <img src="{{ asset('storage/'.$d->image_path) }}"
                                     alt="Leaf" class="thumb">
                            @else
                                <div class="thumb"
                                     style="background:#f0f4f1; display:flex; align-items:center; justify-content:center; font-size:20px;">
                                    🌿
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="farmer-info">
                                <span class="farmer-name">{{ $d->farmer->name ?? '—' }}</span>
                                <span class="farmer-dist">📍 {{ $d->farmer->district ?? '—' }}</span>
                            </div>
                        </td>
                        <td>
                            @if($d->disease)
                                <span class="disease-tag disease-sick">
                                    🦠 {{ $d->disease->name }}
                                </span>
                            @else
                                <span class="disease-tag disease-healthy">
                                    ✅ Healthy Leaf
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($d->confidence)
                                @php $conf = $d->confidence; @endphp
                                <span class="{{ $conf > 85 ? 'conf-high' : ($conf > 60 ? 'conf-med' : 'conf-low') }}">
                                    {{ number_format($conf, 1) }}%
                                </span>
                            @else
                                <span style="color:#aaa;">—</span>
                            @endif
                        </td>
                        <td style="font-size:12px; color:#666;">
                            {{ $d->created_at->format('M d, Y') }}<br>
                            <span style="font-size:11px;">{{ $d->created_at->diffForHumans() }}</span>
                        </td>
                        <td>
                            <span class="badge badge-pending">⏳ Pending</span>
                        </td>
                        <td>
                            <a href="{{ route('officer.diagnoses.show', $d->id) }}">
                                <button class="btn-review">✍️ Review & Advise</button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- CUSTOM PAGINATION --}}
            @if($diagnoses->hasPages())
            <div class="pagination-wrap">
                @if($diagnoses->onFirstPage())
                    <span class="page-btn page-btn-disabled">← Prev</span>
                @else
                    <a href="{{ $diagnoses->previousPageUrl() }}" class="page-btn page-btn-active">← Prev</a>
                @endif

                <span class="page-info">
                    Page {{ $diagnoses->currentPage() }} of {{ $diagnoses->lastPage() }}
                    &nbsp;·&nbsp; {{ $diagnoses->total() }} total
                </span>

                @if($diagnoses->hasMorePages())
                    <a href="{{ $diagnoses->nextPageUrl() }}" class="page-btn page-btn-active">Next →</a>
                @else
                    <span class="page-btn page-btn-disabled">Next →</span>
                @endif
            </div>
            @endif

            @else
            <div class="empty-state">
                <div class="empty-icon">✅</div>
                <div class="empty-text">All diagnoses reviewed!</div>
                <div class="empty-sub">No pending farmer diagnoses awaiting review at this time.</div>
            </div>
            @endif
        </div>
    </main>
</div>
@endsection