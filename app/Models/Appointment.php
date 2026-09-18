<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model {
    protected $fillable = [
        'farmer_id','officer_id','appointment_date',
        'appointment_time','reason','status','officer_response'
    ];

    public function farmer() {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    public function officer() {
        return $this->belongsTo(User::class, 'officer_id');
    }
}