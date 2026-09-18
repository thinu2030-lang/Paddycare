<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seed extends Model {
    protected $fillable = [
        'name','district','season','maturity_days',
        'yield_per_ha','blast_resistance','description','is_recommended'
    ];
}