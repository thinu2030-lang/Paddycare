<?php
namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Diagnosis;
use App\Models\Disease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class DiagnosisController extends Controller
{
    private $diseaseMap = [
        'bacterial_leaf_blight'    => 'Bacterial Leaf Blight',
        'bacterial_leaf_streak'    => 'Bacterial Leaf Streak',
        'bacterial_panicle_blight' => 'Bacterial Panicle Blight',
        'blast'                    => 'Blast',
        'brown_spot'               => 'Brown Spot',
        'dead_heart'               => 'Dead Heart',
        'downy_mildew'             => 'Downy Mildew',
        'hispa'                    => 'Hispa',
        'tungro'                   => 'Tungro',
        'normal'                   => null,
    ];

    public function index()
    {
        $diagnoses = Diagnosis::where('user_id', Auth::id())
                              ->with('disease')
                              ->latest()
                              ->get();
        return view('farmer.diagnosis', compact('diagnoses'));
    }

    public function store(Request $request)
    {
        $request->validate(['image' => 'required|image|max:5120']);

        $path = $request->file('image')->store('diagnoses', 'public');

        $disease    = null;
        $confidence = null;

        try {
            $response = Http::timeout(15)->attach(
                'image',
                file_get_contents(storage_path('app/public/' . $path)),
                'leaf.jpg'
            )->post('http://127.0.0.1:5000/predict');

            if ($response->successful()) {
                $result         = $response->json();
                $predictedClass = $result['disease'] ?? null;
                $confidence     = $result['confidence'] ?? null;

                if ($predictedClass && isset($this->diseaseMap[$predictedClass])) {
                    $diseaseName = $this->diseaseMap[$predictedClass];
                    if ($diseaseName) {
                        $disease = Disease::where('name', $diseaseName)->first();
                    }
                }
            }
        } catch (\Exception $e) {
            $disease    = null;
            $confidence = null;
        }

        $diagnosis = Diagnosis::create([
            'user_id'          => Auth::id(),
            'disease_id'       => $disease?->id,
            'image_path'       => $path,
            'confidence'       => $confidence,
            'status'           => 'pending',
            'advice_requested' => false,
        ]);

        return redirect()->route('farmer.diagnosis.show', $diagnosis->id);
    }

    public function show($id)
    {
        $diagnosis = Diagnosis::with('disease')
                              ->where('user_id', Auth::id())
                              ->findOrFail($id);
        return view('farmer.diagnosis-result', compact('diagnosis'));
    }

    public function requestAdvice($id)
    {
        $diagnosis = Diagnosis::where('user_id', Auth::id())
                              ->findOrFail($id);

        $diagnosis->update(['advice_requested' => true]);

        return back()->with('success', '✅ Expert advice requested! An officer will review your diagnosis soon.');
    }
}