<?php
namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfficerAppointmentController extends Controller {

    public function index() {
        $appointments = Appointment::where('officer_id', Auth::id())
                                   ->with('farmer')->latest()->get();
        return view('officer.appointments', compact('appointments'));
    }

    public function accept($id) {
        $appt = Appointment::where('officer_id', Auth::id())->findOrFail($id);
        $appt->update(['status' => 'confirmed']);
        return back()->with('success', 'Appointment confirmed.');
    }

    public function reject(Request $request, $id) {
        $appt = Appointment::where('officer_id', Auth::id())->findOrFail($id);
        $appt->update([
            'status'           => 'rejected',
            'officer_response' => $request->reason,
        ]);
        return back()->with('success', 'Appointment rejected.');
    }
}