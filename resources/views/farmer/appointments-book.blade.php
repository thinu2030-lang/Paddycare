@extends('layouts.app')
@section('title', 'Book Appointment')

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
    .page-title { font-size: 22px; font-weight: 700; color: #1a2e1e; margin-bottom: 24px; }

    .book-grid { display: grid; grid-template-columns: 1.2fr 1fr; gap: 20px; }
    .card { background: #fff; border-radius: 12px; padding: 24px; border: 1px solid #e0e8e2; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
    .card-title { font-size: 15px; font-weight: 600; color: #1a2e1e; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid #f0f4f1; }

    .form-group { margin-bottom: 18px; }
    .form-label { display: block; font-size: 13px; font-weight: 500; color: #333; margin-bottom: 7px; }
    .form-control {
        width: 100%; padding: 10px 14px;
        border: 1.5px solid #d0ddd4; border-radius: 8px;
        font-size: 14px; color: #1a1a1a; background: #f8fdf9;
        transition: border-color 0.2s;
    }
    .form-control:focus { outline: none; border-color: #1a5c2e; background: #fff; }

    /* OFFICER CARDS */
    .officer-list { display: flex; flex-direction: column; gap: 10px; }
    .officer-option {
        display: flex; align-items: center; gap: 12px;
        padding: 14px; border: 1.5px solid #e0e8e2;
        border-radius: 10px; cursor: pointer; transition: all 0.2s;
        position: relative;
    }
    .officer-option:hover { border-color: #1a5c2e; background: #f8fdf9; }
    .officer-option.selected { border-color: #1a5c2e; background: #f0fbf4; }
    .officer-option input[type=radio] { position: absolute; opacity: 0; }
    .o-av {
        width: 44px; height: 44px; border-radius: 50%;
        background: #e6f1fb; display: flex; align-items: center;
        justify-content: center; font-size: 14px;
        font-weight: 700; color: #185fa5; flex-shrink: 0;
    }
    .o-name { font-size: 14px; font-weight: 600; color: #1a2e1e; }
    .o-dist { font-size: 12px; color: #666; margin-top: 2px; }
    .o-check {
        margin-left: auto; width: 22px; height: 22px;
        border-radius: 50%; border: 2px solid #d0ddd4;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; transition: all 0.2s;
    }
    .officer-option.selected .o-check {
        background: #1a5c2e; border-color: #1a5c2e; color: #fff;
    }

    /* TIME SLOTS */
    .time-slots { display: grid; grid-template-columns: repeat(3,1fr); gap: 8px; }
    .time-slot {
        padding: 10px; border: 1.5px solid #e0e8e2;
        border-radius: 8px; text-align: center;
        font-size: 13px; cursor: pointer; transition: all 0.2s;
        color: #555; background: #f8fdf9;
    }
    .time-slot:hover:not(.booked) { border-color: #1a5c2e; color: #1a5c2e; background: #f0fbf4; }
    .time-slot.selected { background: #1a5c2e; color: #fff; border-color: #1a5c2e; font-weight: 600; }
    .time-slot.booked {
        background: #f5f5f5; color: #bbb;
        cursor: not-allowed; text-decoration: line-through;
        border-color: #e0e0e0;
    }

    .slots-hint { font-size: 11px; color: #888; margin-top: 8px; display: flex; gap: 14px; }
    .hint-item { display: flex; align-items: center; gap: 5px; }
    .hint-dot { width: 10px; height: 10px; border-radius: 50%; }
    .hint-available { background: #1a5c2e; }
    .hint-booked    { background: #bbb; }

    .btn-submit {
        width: 100%; background: #1a5c2e; color: #fff;
        padding: 14px; border-radius: 8px; font-size: 15px;
        font-weight: 700; border: none; cursor: pointer;
        margin-top: 8px; transition: background 0.2s;
    }
    .btn-submit:hover { background: #144a24; }

    .slots-loading { text-align: center; padding: 20px; color: #888; font-size: 13px; grid-column: 1/-1; }
    .slots-placeholder { text-align: center; padding: 20px; color: #aaa; font-size: 12px; grid-column: 1/-1; border: 2px dashed #e0e8e2; border-radius: 8px; }
    .no-slots { text-align: center; padding: 16px; color: #993556; font-size: 12px; background: #fce4ec; border-radius: 8px; grid-column: 1/-1; }

    .info-box {
        background: #e8f5e9; border-radius: 10px;
        padding: 16px; border: 1px solid #a5d6b0; margin-top: 16px;
    }
    .info-box h4 { font-size: 13px; font-weight: 600; color: #1a5c2e; margin-bottom: 8px; }
    .info-box li { font-size: 12px; color: #3a7d4e; margin-bottom: 4px; margin-left: 16px; }
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
        <a href="{{ route('farmer.crops') }}" class="sidebar-link">🌾 Harvest Tracker</a>
        <div class="sidebar-section">Appointments</div>
        <a href="{{ route('farmer.appointments.create') }}" class="sidebar-link active">📅 Book Appointment</a>
        <a href="{{ route('farmer.appointments') }}" class="sidebar-link">🗓 My Appointments</a>
        <div class="sidebar-section">Info</div>
        <a href="{{ route('articles') }}" class="sidebar-link">📖 Articles</a>
        <form method="POST" action="{{ route('logout') }}" style="margin-top:20px;">
            @csrf
            <button type="submit" class="sidebar-link" style="width:100%;background:none;border:none;cursor:pointer;text-align:left;">🚪 Logout</button>
        </form>
    </aside>

    <main class="main-content">
        <div class="page-title">📅 Book Appointment</div>

        <form method="POST" action="{{ route('farmer.appointments.store') }}" id="apptForm">
            @csrf
            <div class="book-grid">
                <!-- LEFT -->
                <div>
                    <div class="card">
                        <div class="card-title">👮 Select Field Officer</div>
                        <div class="officer-list">
                            @foreach($officers as $officer)
                            <label class="officer-option" id="opt-{{ $officer->id }}">
                                <input type="radio" name="officer_id"
                                       value="{{ $officer->id }}"
                                       onchange="selectOfficer({{ $officer->id }})"
                                       {{ old('officer_id') == $officer->id ? 'checked' : '' }}>
                                <div class="o-av">
                                    {{ strtoupper(substr($officer->name,0,2)) }}
                                </div>
                                <div>
                                    <div class="o-name">{{ $officer->name }}</div>
                                    <div class="o-dist">📍 {{ $officer->district }}</div>
                                </div>
                                <div class="o-check" id="check-{{ $officer->id }}">✓</div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- RIGHT -->
                <div>
                    <div class="card">
                        <div class="card-title">📅 Date & Time</div>
                        <div class="form-group">
                            <label class="form-label">Preferred Date</label>
                            <input type="date" name="appointment_date"
                                   id="appointmentDate"
                                   class="form-control"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   value="{{ old('appointment_date') }}" 
                                   onchange="loadSlots()" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Select Time Slot</label>
                            <input type="hidden" name="appointment_time"
                                   id="selectedTime" value="{{ old('appointment_time') }}" required>
                            
                            <div class="time-slots" id="timeSlotsContainer">
                                <div class="slots-placeholder">
                                    📅 Select an officer and date first
                                </div>
                            </div>

                            <!-- Available/Booked Hint -->
                            <div class="slots-hint">
                                <div class="hint-item">
                                    <div class="hint-dot hint-available"></div>
                                    <span>Available</span>
                                </div>
                                <div class="hint-item">
                                    <div class="hint-dot hint-booked"></div>
                                    <span>Already Booked</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Reason for Visit</label>
                            <textarea name="reason" class="form-control" rows="3"
                                      placeholder="Describe your issue briefly...">{{ old('reason') }}</textarea>
                        </div>
                        <button type="submit" class="btn-submit">
                            ✅ Confirm Appointment
                        </button>
                    </div>

                    <div class="info-box">
                        <h4>ℹ️ What to Expect:</h4>
                        <ul>
                            <li>Officer will confirm within 24 hours</li>
                            <li>Bring your field photos if possible</li>
                            <li>Note your paddy variety and age</li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </main>
</div>
@endsection

@push('scripts')
<script>
let selectedOfficerId = null;

function selectOfficer(id) {
    document.querySelectorAll('.officer-option').forEach(el => el.classList.remove('selected'));
    document.getElementById('opt-' + id).classList.add('selected');
    selectedOfficerId = id;
    loadSlots();
}

function loadSlots() {
    const date = document.getElementById('appointmentDate').value;
    const container = document.getElementById('timeSlotsContainer');

    // Reset කලින් select කරපු වෙලාව
    document.getElementById('selectedTime').value = '';

    if (!selectedOfficerId || !date) {
        container.innerHTML = '<div class="slots-placeholder">📅 Select an officer and date first</div>';
        return;
    }

    container.innerHTML = '<div class="slots-loading">⏳ Loading available slots...</div>';

    fetch(`{{ route('farmer.appointments.slots') }}?officer_id=${selectedOfficerId}&date=${date}`)
        .then(res => res.json())
        .then(data => {
            container.innerHTML = '';

            const allSlots = ['08:00','09:00','10:00','11:00','14:00','15:00'];

            allSlots.forEach(time => {
                const isBooked = data.booked.includes(time);
                const div = document.createElement('div');

                div.className = 'time-slot' + (isBooked ? ' booked' : '');
                div.textContent = formatTime(time);
                div.setAttribute('data-time', time);

                if (isBooked) {
                    div.title = 'Already booked — choose another slot';
                } else {
                    div.onclick = () => selectTime(time, div);
                }

                container.appendChild(div);
            });
        })
        .catch(() => {
            container.innerHTML = '<div class="no-slots">⚠️ Error loading slots. Please try again.</div>';
        });
}

function selectTime(time, el) {
    document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('selectedTime').value = time;
}

function formatTime(time24) {
    const [h, m] = time24.split(':');
    const hour = parseInt(h);
    const ampm = hour >= 12 ? 'PM' : 'AM';
    const hour12 = hour % 12 === 0 ? 12 : hour % 12;
    return `${hour12}:${m} ${ampm}`;
}

// Form එක Submit වෙද්දී validation check එක
document.getElementById('apptForm').addEventListener('submit', function(e) {
    const officerId = document.querySelector('input[name=officer_id]:checked');
    const time = document.getElementById('selectedTime').value;

    if (!officerId) {
        e.preventDefault();
        alert('Please select a Field Officer.');
        return;
    }
    if (!time) {
        e.preventDefault();
        alert('Please select a time slot.');
        return;
    }
});

// Old value එකක් තිබුනොත් (Validation fail වී ආපසු පැමිණි විට)
document.querySelectorAll('input[name=officer_id]:checked').forEach(r => {
    selectOfficer(r.value);
});
</script>
@endpush