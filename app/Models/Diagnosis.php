<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model {
    protected $fillable = [
        'user_id','disease_id','image_path',
        'confidence','status','officer_note','reviewed_by'
    ];

    public function farmer() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function disease() {
        return $this->belongsTo(Disease::class);
    }

    public function reviewer() {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}