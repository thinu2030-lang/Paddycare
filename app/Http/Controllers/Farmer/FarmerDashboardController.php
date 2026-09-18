<?php
namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Diagnosis;
use App\Models\Appointment;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class FarmerDashboardController extends Controller
{
    public function index()
    {
        $user          = Auth::user();
        $totalScans    = Diagnosis::where('user_id', $user->id)->count();
        $diseasesFound = Diagnosis::where('user_id', $user->id)
                                  ->whereNotNull('disease_id')->count();
        $healthyScans  = Diagnosis::where('user_id', $user->id)
                                  ->whereNull('disease_id')->count();
        $appointments  = Appointment::where('farmer_id', $user->id)
                                    ->with('officer')->latest()->take(3)->get();
        $recentScans   = Diagnosis::where('user_id', $user->id)
                                  ->with('disease')->latest()->take(5)->get();

        // Officer advice received notifications
        $adviceReceived = Diagnosis::where('user_id', $user->id)
                                   ->whereNotNull('officer_note')
                                   ->where('status', 'reviewed')
                                   ->with(['disease', 'reviewer'])
                                   ->latest()
                                   ->take(3)
                                   ->get();

        // District notifications from officers
        $districtNotifications = Notification::where('district', $user->district)
                                             ->latest()
                                             ->take(3)
                                             ->get();

        return view('farmer.dashboard', compact(
            'user', 'totalScans', 'diseasesFound', 'healthyScans',
            'appointments', 'recentScans',
            'adviceReceived', 'districtNotifications'
        ));
    }
}