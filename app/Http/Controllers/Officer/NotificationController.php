<?php
namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Mail\FarmerNotificationMail;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('sent_by', Auth::id())
                                     ->latest()->get();
        return view('officer.notifications.index', compact('notifications'));
    }

    public function create()
    {
        $district    = Auth::user()->district;
        $farmerCount = User::where('role', 'farmer')
                           ->where('district', $district)
                           ->count();
        return view('officer.notifications.create', compact('district', 'farmerCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'    => 'required|in:fertilizer,meeting,disease_alert,general',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $officer  = Auth::user();
        $district = $officer->district;

        Log::info('PaddyCare Notification — Officer: ' . $officer->name);
        Log::info('PaddyCare Notification — District: ' . $district);

        $farmers = User::where('role', 'farmer')
                       ->where('district', $district)
                       ->whereNotNull('email')
                       ->get();

        Log::info('PaddyCare Notification — Farmers found: ' . $farmers->count());

        $sentCount = 0;
        foreach ($farmers as $farmer) {
            try {
                Mail::to($farmer->email)->send(new FarmerNotificationMail(
                    $request->type,
                    $request->subject,
                    $request->message,
                    $officer->name,
                    $district,
                    $farmer->name
                ));
                $sentCount++;
                Log::info('Mail sent to: ' . $farmer->email);
            } catch (\Exception $e) {
                Log::error('Mail error for ' . $farmer->email . ': ' . $e->getMessage());
                continue;
            }
        }

        Notification::create([
            'sent_by'          => $officer->id,
            'district'         => $district,
            'type'             => $request->type,
            'subject'          => $request->subject,
            'message'          => $request->message,
            'recipients_count' => $sentCount,
        ]);

        return redirect()->route('officer.notifications.index')
                         ->with('success', "Notification sent to {$sentCount} farmers in {$district} district!");
    }
}