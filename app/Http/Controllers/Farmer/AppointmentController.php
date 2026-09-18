<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller 
{
    public function index() 
    {
        $appointments = Appointment::where('farmer_id', Auth::id())
                                   ->with('officer')
                                   ->latest()
                                   ->get();
        return view('farmer.appointments', compact('appointments'));
    }

    public function create() 
    {
        $officers = User::role('officer')->get();
        return view('farmer.appointments-book', compact('officers'));
    }

    // AJAX මඟින් ලබාගන්නා Available සහ Booked Slots මෙතනින් handle වේ
    public function getAvailableSlots(Request $request)
    {
        $officerId = $request->officer_id;
        $date      = $request->date;

        // පද්ධතියේ පවතින සම්පූර්ණ කාල පරාසයන් (Time Slots)
        $allSlots = ['08:00', '09:00', '10:00', '11:00', '14:00', '15:00'];

        // තෝරාගත් දිනය සහ නිලධාරියා අනුව දැනටමත් වෙන්කර ඇති (Booked) Slots ලබාගැනීම
        $bookedSlots = Appointment::where('officer_id', $officerId)
                                  ->where('appointment_date', $date)
                                  ->whereIn('status', ['pending', 'confirmed'])
                                  ->pluck('appointment_time')
                                  ->map(function ($time) {
                                      return \Carbon\Carbon::parse($time)->format('H:i');
                                  })
                                  ->toArray();

        // මුළු slots වලින් දැනටමත් book වූ slots ඉවත් කර ඉතිරි slots ලබාගැනීම
        $availableSlots = array_values(array_diff($allSlots, $bookedSlots));

        return response()->json([
            'available' => $availableSlots,
            'booked'    => $bookedSlots,
        ]);
    }

    public function store(Request $request) 
    {
        $request->validate([
            'officer_id'       => 'required|exists:users,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'reason'           => 'nullable|string|max:500',
        ]);

        Appointment::create([
            'farmer_id'        => Auth::id(),
            'officer_id'       => $request->officer_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'reason'           => $request->reason,
            'status'           => 'pending',
        ]);

        return redirect()->route('farmer.appointments')
                         ->with('success', 'Appointment booked successfully!');
    }
}