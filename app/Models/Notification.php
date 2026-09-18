<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    // කෙලින්ම database එකට දාන්න අවසර දෙන fields ටික (Mass Assignment)
    protected $fillable = [
        'sent_by',
        'district',
        'type',
        'subject',
        'message',
        'recipients_count',
    ];

    /**
     * Notification එකක් යවපු නිලධාරියා (User) ලබාගැනීමට ඇති සම්බන්ධතාවය.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_by');
    }
}