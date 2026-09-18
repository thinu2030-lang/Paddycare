<?php
namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Crop;
use App\Models\Seed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CropController extends Controller
{
    public function index()
    {
        $crops = Crop::where('user_id', Auth::id())->latest()->get();
        return view('farmer.crops', compact('crops'));
    }

    public function create()
    {
        $seeds = Seed::orderBy('name')->get();
        return view('farmer.crops-create', compact('seeds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'seed_id'     => 'required|exists:seeds,id',
            'sowing_date' => 'required|date',
        ]);

        $seed = Seed::findOrFail($request->seed_id);
        $sowingDate = \Carbon\Carbon::parse($request->sowing_date);
        $harvestDate = $sowingDate->copy()->addDays($seed->maturity_days);

        Crop::create([
            'user_id'       => Auth::id(),
            'seed_id'       => $seed->id,
            'seed_name'     => $seed->name,
            'sowing_date'   => $sowingDate,
            'harvest_date'  => $harvestDate,
            'maturity_days' => $seed->maturity_days,
        ]);

        return redirect()->route('farmer.crops')
                         ->with('success', 'Crop tracker started! Harvest countdown is now active.');
    }

    public function toggleTask(Request $request, $id)
    {
        $crop = Crop::where('user_id', Auth::id())->findOrFail($id);
        $field = $request->input('field');

        $allowedFields = ['task1_done','task2_done','task3_done','task4_done','task5_done',
                           'task6_done','task7_done','task8_done','task9_done','task10_done'];

        if (in_array($field, $allowedFields)) {
            $crop->update([$field => !$crop->$field]);
        }

        return back()->with('success', 'Task updated.');
    }

    public function destroy($id)
    {
        $crop = Crop::where('user_id', Auth::id())->findOrFail($id);
        $crop->delete();
        return back()->with('success', 'Crop tracker removed.');
    }
}