<?php
namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Seed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeedController extends Controller {
    public function index(Request $request) {
        $district = $request->district ?? Auth::user()->district;
        $season   = $request->season   ?? 'Both';

        $seeds = Seed::where('district', $district)
                     ->where(function($q) use ($season) {
                         $q->where('season', $season)
                           ->orWhere('season', 'Both');
                     })
                     ->orderByDesc('is_recommended')->get();

        $districts = Seed::select('district')->distinct()->pluck('district');
        return view('farmer.seeds', compact('seeds','district','season','districts'));
    }
}