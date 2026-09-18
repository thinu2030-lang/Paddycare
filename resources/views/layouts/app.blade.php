<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PaddyCare — @yield('title', 'Paddy Disease Identification')</title>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f4;
            color: #1a1a1a;
            font-size: 14px;
        }
        a { text-decoration: none; color: inherit; }

        /* ===== NAVBAR ===== */
        .navbar {
            background: #1a5c2e;
            padding: 0 32px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .navbar-brand {
            color: #fff;
            font-size: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        .navbar-brand span { color: #6fdc9e; }
        .navbar-brand img {
            width: 40px; height: 40px;
            object-fit: contain;
            border-radius: 50%;
            background: #fff;
            padding: 2px;
        }
        .navbar-links { display: flex; gap: 6px; align-items: center; }
        .navbar-links a {
            color: #c8efd7;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 13px;
            transition: background 0.2s;
        }
        .navbar-links a:hover,
        .navbar-links a.active {
            background: rgba(255,255,255,0.15);
            color: #fff;
        }

        /* ===== NAV AUTH BUTTONS ===== */
        .navbar-auth { display: flex; gap: 8px; align-items: center; }

        .btn-nav-home {
            background: transparent; border: none;
            color: #c8efd7; padding: 6px 14px;
            border-radius: 6px; font-size: 13px;
            cursor: pointer; transition: all 0.2s;
            display: flex; align-items: center; gap: 5px;
        }
        .btn-nav-home:hover { background: rgba(255,255,255,0.12); color: #fff; }

        .btn-nav-login {
            background: transparent;
            border: 1.5px solid rgba(111,220,158,0.7);
            color: #d4f7e2; padding: 6px 18px;
            border-radius: 6px; font-size: 13px;
            font-weight: 500; cursor: pointer;
            transition: all 0.2s;
            display: flex; align-items: center; gap: 5px;
        }
        .btn-nav-login:hover { background: rgba(111,220,158,0.15); border-color: #6fdc9e; color: #fff; }

        .btn-nav-register {
            background: #6fdc9e; border: none;
            color: #0a3318; padding: 7px 18px;
            border-radius: 6px; font-size: 13px;
            font-weight: 700; cursor: pointer;
            transition: all 0.2s;
            display: flex; align-items: center; gap: 5px;
            box-shadow: 0 2px 8px rgba(111,220,158,0.3);
        }
        .btn-nav-register:hover { background: #5bc98a; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(111,220,158,0.4); }

        .btn-nav-logout {
            background: rgba(255,255,255,0.08);
            border: 1.5px solid rgba(255,255,255,0.2);
            color: #d4f7e2; padding: 6px 16px;
            border-radius: 6px; font-size: 13px;
            cursor: pointer; transition: all 0.2s;
            display: flex; align-items: center; gap: 5px;
        }
        .btn-nav-logout:hover { background: rgba(255,255,255,0.15); border-color: rgba(255,255,255,0.4); color: #fff; }

        .nav-user-badge {
            background: rgba(111,220,158,0.15);
            border: 1px solid rgba(111,220,158,0.3);
            color: #d4f7e2; padding: 5px 12px;
            border-radius: 20px; font-size: 12px;
            display: flex; align-items: center; gap: 5px;
        }

        /* ===== ALERT MESSAGES ===== */
        .alert {
            padding: 12px 20px; border-radius: 8px;
            margin: 16px 32px; font-size: 13px;
            display: flex; align-items: center; gap: 10px;
        }
        .alert-success { background: #e8f5e9; color: #1a5c2e; border: 1px solid #a5d6b0; }
        .alert-error   { background: #fce4ec; color: #993556; border: 1px solid #f4c0d1; }

        /* ===== FOOTER ===== */
        .footer {
            background: #1a5c2e;
            color: #a5d6b0;
            text-align: center;
            padding: 16px;
            font-size: 12px;
            margin-top: 0;
        }
        .footer a { color: #6fdc9e; }
    </style>

    @stack('styles')
</head>
<body>

<nav class="navbar">
    <a href="{{ route('home') }}" class="navbar-brand">
        <img src="{{ asset('images/logo.png') }}" alt="PaddyCare Logo">
        Paddy<span>Care</span>
    </a>

    <div class="navbar-links">
        @auth
            @if(auth()->user()->role === 'farmer')
                <a href="{{ route('farmer.dashboard') }}"    class="{{ request()->routeIs('farmer.dashboard')     ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('farmer.diagnosis') }}"    class="{{ request()->routeIs('farmer.diagnosis*')    ? 'active' : '' }}">Disease Check</a>
                <a href="{{ route('farmer.seeds') }}"        class="{{ request()->routeIs('farmer.seeds')         ? 'active' : '' }}">Seed Guide</a>
                <a href="{{ route('farmer.appointments') }}" class="{{ request()->routeIs('farmer.appointments*') ? 'active' : '' }}">Appointments</a>
                <a href="{{ route('articles') }}"            class="{{ request()->routeIs('articles*')            ? 'active' : '' }}">Articles</a>

            @elseif(auth()->user()->role === 'officer')
                <a href="{{ route('officer.dashboard') }}"           class="{{ request()->routeIs('officer.dashboard')      ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('officer.appointments') }}"        class="{{ request()->routeIs('officer.appointments*')  ? 'active' : '' }}">Appointments</a>
                <a href="{{ route('officer.diagnoses') }}"           class="{{ request()->routeIs('officer.diagnoses*')     ? 'active' : '' }}">Diagnoses</a>
                <a href="{{ route('officer.articles.index') }}"      class="{{ request()->routeIs('officer.articles*')      ? 'active' : '' }}">Articles</a>
                <a href="{{ route('officer.notifications.index') }}" class="{{ request()->routeIs('officer.notifications*') ? 'active' : '' }}">Notify Farmers</a>

            @elseif(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}"      class="{{ request()->routeIs('admin.dashboard')  ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.users.index') }}"    class="{{ request()->routeIs('admin.users*')     ? 'active' : '' }}">Users</a>
                <a href="{{ route('admin.diseases.index') }}" class="{{ request()->routeIs('admin.diseases*')  ? 'active' : '' }}">Diseases</a>
                <a href="{{ route('admin.articles.index') }}" class="{{ request()->routeIs('admin.articles*')  ? 'active' : '' }}">Articles</a>
                <a href="{{ route('admin.reports.index') }}"  class="{{ request()->routeIs('admin.reports*')   ? 'active' : '' }}">Reports</a>
            @endif
        @endauth
    </div>

    <div class="navbar-auth">
        @guest
            <a href="{{ route('home') }}">
                <button class="btn-nav-home"> Home</button>
            </a>
            <a href="{{ route('login') }}">
                <button class="btn-nav-login">Login</button>
            </a>
            <a href="{{ route('register') }}">
                <button class="btn-nav-register"> Register</button>
            </a>
        @else
            <div class="nav-user-badge">
                 {{ auth()->user()->name }}
            </div>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn-nav-logout"> Logout</button>
            </form>
        @endguest
    </div>
</nav>

@if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-error">❌ {{ session('error') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-error">
        ❌
        <ul style="list-style:none;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@yield('content')

<footer class="footer">
    <p>© 2026 PaddyCare · SLIATE Gampaha · B.M.T.Y Chandrarathna &nbsp;|&nbsp;
    <a href="#">Agriculture Sri Lanka</a></p>
</footer>

@stack('scripts')

</body>
</html>