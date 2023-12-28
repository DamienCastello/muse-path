<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin IdeHelperResource
 */
class Resource extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'title',
        'image',
        'slug',
        'description',
        'price',
        'link',
        'category_id',
        'user_id'
    ];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    // USERS_LIKES_RESOURCES
    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class);
    }

    public function tags(): BelongsToMany {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(): HasMany {
        return $this->hasMany(Comment::class);
    }

    public function imageUrl(): string {
        return Storage::url($this->image);
    }

    public function scopeRecent(Builder $builder /* Can get optional params to handle conditions below */): Builder {
        return $builder->orderBy('created_at', 'desc');
    }
}
