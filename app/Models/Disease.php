<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disease extends Model {
    protected $fillable = [
        'name','scientific_name','description',
        'chemical_treatment','organic_treatment',
        'ipm_advice','severity_level','image'
    ];
}