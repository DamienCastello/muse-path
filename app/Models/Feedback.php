<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'user_id',
        'track_id'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function track(): BelongsTo {
        return $this->belongsTo(Track::class);
    }

    protected $casts = [
        'updated_at' => 'datetime:Y-m-d',
    ];
}
