<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin IdeHelperResource
 */
class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'resource_author',
        'image',
        'slug',
        'description',
        'price',
        'category_id'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function imageUrl(): string {
        return Storage::url($this->image);
    }
}
