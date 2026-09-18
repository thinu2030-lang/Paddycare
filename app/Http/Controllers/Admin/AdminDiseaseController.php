<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Disease;
use Illuminate\Http\Request;

class AdminDiseaseController extends Controller {

    public function index() {
        $diseases = Disease::latest()->get();
        return view('admin.diseases.index', compact('diseases'));
    }

    public function create() { return view('admin.diseases.create'); }

    public function store(Request $request) {
        $request->validate([
            'name'               => 'required',
            'description'        => 'required',
            'chemical_treatment' => 'required',
            'organic_treatment'  => 'required',
            'ipm_advice'         => 'required',
            'severity_level'     => 'required',
        ]);
        Disease::create($request->all());
        return redirect()->route('admin.diseases.index')
                         ->with('success', 'Disease added.');
    }

    public function edit(Disease $disease) {
        return view('admin.diseases.edit', compact('disease'));
    }

    public function update(Request $request, Disease $disease) {
        $disease->update($request->all());
        return redirect()->route('admin.diseases.index')
                         ->with('success', 'Disease updated.');
    }

    public function destroy(Disease $disease) {
        $disease->delete();
        return back()->with('success', 'Disease deleted.');
    }

    public function show(Disease $disease) {
        return view('admin.diseases.show', compact('disease'));
    }
}