@extends('layouts.app')
@section('title', 'Register')

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
        max-width: 480px;
        box-shadow: 0 8px 32px rgba(26,92,46,0.12);
        border: 1px solid #e0e8e2;
    }
    .auth-logo  { text-align: center; font-size: 40px; margin-bottom: 8px; }
    .auth-title { text-align: center; font-size: 22px; font-weight: 700; color: #1a2e1e; margin-bottom: 4px; }
    .auth-sub   { text-align: center; font-size: 13px; color: #666; margin-bottom: 28px; }
    .form-row   { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .form-group { margin-bottom: 16px; }
    .form-label { display: block; font-size: 13px; font-weight: 500; color: #333; margin-bottom: 6px; }
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
    .form-control:focus { outline: none; border-color: #1a5c2e; background: #fff; }

    /* PASSWORD FIELD WITH EYE ICON */
    .password-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }
    .password-wrap .form-control {
        padding-right: 42px;
    }
    .eye-btn {
        position: absolute;
        right: 12px;
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
        color: #888;
        font-size: 16px;
        line-height: 1;
        transition: color 0.2s;
        display: flex;
        align-items: center;
    }
    .eye-btn:hover { color: #1a5c2e; }

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
    .auth-footer { text-align: center; margin-top: 20px; font-size: 13px; color: #666; }
    .auth-footer a { color: #1a5c2e; font-weight: 500; }
</style>
@endpush

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-logo">🌾</div>
        <div class="auth-title">Create Account</div>
        <div class="auth-sub">Join PaddyCare — Free for farmers</div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name') }}" placeholder="Nimal Kumara" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control"
                           value="{{ old('phone') }}" placeholder="077xxxxxxx">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email') }}" placeholder="your@email.com" required>
            </div>

            <div class="form-group">
                <label class="form-label">District</label>
                <select name="district" class="form-control" required>
                    <option value="">-- Select District --</option>
                    @foreach(['Colombo','Gampaha','Kalutara','Kandy','Matale','Nuwara Eliya','Galle','Matara','Hambantota','Jaffna','Kurunegala','Puttalam','Anuradhapura','Polonnaruwa','Badulla','Moneragala','Ratnapura','Kegalle','Trincomalee','Batticaloa','Ampara','Vavuniya','Mannar','Mullaitivu','Kilinochchi'] as $d)
                        <option value="{{ $d }}" {{ old('district') === $d ? 'selected' : '' }}>{{ $d }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="password-wrap">
                        <input type="password" name="password" id="password"
                               class="form-control"
                               placeholder="Min 6 characters" required>
                        <button type="button" class="eye-btn" onclick="togglePassword('password', this)">
                            👁️
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <div class="password-wrap">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="form-control"
                               placeholder="Repeat password" required>
                        <button type="button" class="eye-btn" onclick="togglePassword('password_confirmation', this)">
                            👁️
                        </button>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">🌾 Create Account</button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="{{ route('login') }}">Sign in</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePassword(fieldId, btn) {
    const input = document.getElementById(fieldId);
    if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = '';
    } else {
        input.type = 'password';
        btn.textContent = '👁️';
    }
}
</script>
@endpush