<?php
namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Diagnosis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdviceController extends Controller
{
    public function index()
    {
        $diagnoses = Diagnosis::with(['farmer', 'disease'])
            ->where('status', 'pending')
            ->whereNull('reviewed_by')
            ->latest()
            ->paginate(15);

        return view('officer.diagnoses', compact('diagnoses'));
    }

    public function show($id)
    {
        $diagnosis = Diagnosis::with(['farmer', 'disease'])->findOrFail($id);
        return view('officer.diagnosis-detail', compact('diagnosis'));
    }

    public function sendAdvice(Request $request, $id)
    {
        $request->validate(['officer_note' => 'required|string']);

        $diagnosis = Diagnosis::findOrFail($id);
        $diagnosis->update([
            'officer_note' => $request->officer_note,
            'reviewed_by'  => Auth::id(),
            'status'       => 'reviewed',
        ]);

        return back()->with('success', 'Advice sent to farmer successfully.');
    }
}