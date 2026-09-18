<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Diagnosis;
use App\Models\Appointment;
use App\Models\Article;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    // Reports page — officer list show කරනවා
    public function index()
    {
        $officers = User::where('role', 'officer')->get();
        return view('admin.reports.index', compact('officers'));
    }

    // Selected officer PDF generate කරනවා
    public function generateOfficer($id)
    {
        $officer = User::findOrFail($id);

        // Appointment stats
        $appointments = Appointment::where('officer_id', $officer->id)->get();
        $stats = [
            'total_appointments'     => $appointments->count(),
            'confirmed_appointments' => $appointments->where('status','confirmed')->count(),
            'rejected_appointments'  => $appointments->where('status','rejected')->count(),
            'pending_appointments'   => $appointments->where('status','pending')->count(),
            'diagnoses_reviewed'     => Diagnosis::where('reviewed_by', $officer->id)->count(),
            'total_diagnoses'        => Diagnosis::count(),
            'articles_published'     => Article::where('created_by', $officer->id)->where('is_published',1)->count(),
            'articles_draft'         => Article::where('created_by', $officer->id)->where('is_published',0)->count(),
            'total_articles'         => Article::count() ?: 1,
        ];

        // Recent appointments (last 5)
        $recentAppointments = Appointment::where('officer_id', $officer->id)
            ->with('farmer')
            ->latest()
            ->limit(5)
            ->get();

        // Recent diagnoses reviewed (last 5)
        $recentDiagnoses = Diagnosis::where('reviewed_by', $officer->id)
            ->with(['farmer','disease'])
            ->latest()
            ->limit(5)
            ->get();

        // Articles written
        $articles = Article::where('created_by', $officer->id)
            ->latest()
            ->get();

        $pdf = Pdf::loadView('admin.reports.officer-report', compact(
            'officer','stats','recentAppointments','recentDiagnoses','articles'
        ))
        ->setPaper('a4','portrait')
        ->setOptions([
            'defaultFont'          => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled'      => false,
        ]);

        $filename = 'PaddyCare_Officer_Report_'.str_replace(' ','_',$officer->name).'_'.now()->format('Y-m-d').'.pdf';
        return $pdf->download($filename);
    }
}