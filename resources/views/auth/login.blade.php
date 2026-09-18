@extends('layouts.app')
@section('title', 'Login')

@push('styles')
<style>
    .auth-page {
        min-height: calc(100vh - 140px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 16px;
        background: linear-gradient(135deg, #e8f5e9 0%, #f4f9f4 100%);
    }
    .auth-card {
        background: #fff;
        border-radius: 16px;
        padding: 40px;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 8px 32px rgba(26,92,46,0.12);
        border: 1px solid #e0e8e2;
    }
    .auth-logo {
        text-align: center;
        font-size: 40px;
        margin-bottom: 8px;
    }
    .auth-title {
        text-align: center;
        font-size: 22px;
        font-weight: 700;
        color: #1a2e1e;
        margin-bottom: 4px;
    }
    .auth-sub {
        text-align: center;
        font-size: 13px;
        color: #666;
        margin-bottom: 28px;
    }
    .form-group { margin-bottom: 16px; }
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: #333;
        margin-bottom: 6px;
    }
    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid #d0ddd4;
        border-radius: 8px;
        font-size: 14px;
        color: #1a1a1a;
        background: #f8fdf9;
        transition: border-color 0.2s;
    }
    .form-control:focus {
        outline: none;
        border-color: #1a5c2e;
        background: #fff;
    }
    .btn-submit {
        width: 100%;
        background: #1a5c2e;
        color: #fff;
        padding: 12px;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        margin-top: 8px;
        transition: background 0.2s;
    }
    .btn-submit:hover { background: #144a24; }
    .auth-footer {
        text-align: center;
        margin-top: 20px;
        font-size: 13px;
        color: #666;
    }
    .auth-footer a { color: #1a5c2e; font-weight: 500; }

    .password-wrapper {
        position: relative;
    }
    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 16px;
        user-select: none;
        background: none;
        border: none;
        padding: 0;
    }
</style>
@endpush

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-logo">🌾</div>
        <div class="auth-title">Welcome Back</div>
        <div class="auth-sub">Sign in to your PaddyCare account</div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email') }}" placeholder="your@email.com" required>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="passwordField" class="form-control"
                           placeholder="••••••••" required style="padding-right: 42px;">
                    <button type="button" class="password-toggle" onclick="togglePassword()" id="toggleIcon">
                        👁️
                    </button>
                </div>
            </div>
            <button type="submit" class="btn-submit">🔐 Sign In</button>
        </form>

        <div class="auth-footer">
            Don't have an account? <a href="{{ route('register') }}">Register here</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePassword() {
    const field = document.getElementById('passwordField');
    const icon = document.getElementById('toggleIcon');
    if (field.type === 'password') {
        field.type = 'text';
        icon.textContent = '🙈';
    } else {
        field.type = 'password';
        icon.textContent = '👁️';
    }
}
</script>
@endpush