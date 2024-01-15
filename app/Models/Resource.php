<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

/**
 * @mixin IdeHelperResource
 */
class Resource extends Model
{
    #region Traits

    use HasFactory;
    //use SoftDeletes;

    #endregion

    #region CONST

    public const DEFAULT_PREVIEW_RESOURCE = 'resource/default_preview_resource.jpg';

    #endregion

    #region ATTRIBUTES

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

    #endregion

    #region RELATIONSHIPS

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function users(): MorphToMany
    {
        return $this->morphToMany(User::class, 'likable');
    }

    /*
    // USERS_LIKES_RESOURCES
    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class);
    }
    */

    public function tags(): BelongsToMany {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(): HasMany {
        return $this->hasMany(Comment::class);
    }

    #endregion


     #region ACCESSORS AND MUTATORS

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn(string $value): string => $value,

            set: function (UploadedFile|null|string $value, array $attributes): string {
                // String only to generate seeds
                if(is_string($value)){
                    return $value;
                } else if ($value === null){
                    return 'resource/'.self::DEFAULT_PREVIEW_RESOURCE;
                } else {
                    $resizedImage = Image::make($value)
                        ->resize(300, 200);
                    $image = time() . '.' . $value->extension();
                    Storage::disk('users-data')->put("resource/$image", $resizedImage->stream());

                    return $image;
                }
            }
        );
    }


    #endregion

    #region SCOPE

    public function scopeRecent(Builder $builder /* Can get optional params to handle conditions below */): Builder {
        return $builder->orderBy('created_at', 'desc');
    }

    #endregion


    //TODO: Transform it in accessor
    public function imageUrl(): string {
        return Storage::url($this->image);
    }
}
