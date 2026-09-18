<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {
    protected $fillable = [
        'title','slug','content','category',
        'image','created_by','views','is_published'
    ];

    public function author() {
        return $this->belongsTo(User::class, 'created_by');
    }
}