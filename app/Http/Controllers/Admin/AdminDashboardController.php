<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Diagnosis;
use App\Models\Disease;

class AdminDashboardController extends Controller {
    public function index() {
        $totalUsers   = User::count();
        $totalOfficers= User::role('officer')->count();
        $totalScans   = Diagnosis::count();
        $totalDiseases= Disease::count();
        $recentUsers  = User::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers','totalOfficers','totalScans','totalDiseases','recentUsers'
        ));
    }
}