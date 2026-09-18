<?php
namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Diagnosis;
use Illuminate\Support\Facades\Auth;

class OfficerDashboardController extends Controller {
    public function index() {
        $officer          = Auth::user();
        $pendingAppts     = Appointment::where('officer_id', $officer->id)
                                       ->where('status','pending')->count();
        $todayAppts       = Appointment::where('officer_id', $officer->id)
                                       ->where('appointment_date', today())->get();
        $recentAppts      = Appointment::where('officer_id', $officer->id)
                                       ->with('farmer')->latest()->take(5)->get();
        $pendingDiagnoses = Diagnosis::where('status','pending')
                                     ->with(['farmer','disease'])->latest()->take(5)->get();

        return view('officer.dashboard', compact(
            'officer','pendingAppts','todayAppts','recentAppts','pendingDiagnoses'
        ));
    }
}