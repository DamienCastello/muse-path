<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Storage;

class Track extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'music',
        'description',
        'user_id',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    // USERS_LIKES_TRACK
    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class);
    }

    public function feedbacks(): HasMany {
        return $this->hasMany(Feedback::class);
    }

    public function genres(): BelongsToMany {
        return $this->belongsToMany(Genre::class);
    }

    public function entityUrl($entityPath): string {
        return Storage::url($entityPath);
    }

    public function scopeRecent(Builder $builder /* Can get optional params to handle conditions below */): Builder {
        return $builder->orderBy('created_at', 'desc');
    }}
