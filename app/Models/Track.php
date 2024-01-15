<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Track extends Model
{
    #region Traits

    use HasFactory;

    #endregion

    #region CONST

    public const DEFAULT_PREVIEW_TRACK = 'default_preview_track.jpg';
    #endregion

    #region ATTRIBUTES

    protected $fillable = [
        'title',
        'image',
        'music',
        'description',
        'user_id',
    ];

    #endregion

    #region RELATIONSHIPS

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function users(): MorphToMany
    {
        return $this->morphToMany(User::class, 'likable');
    }

    /*
    // USERS_LIKES_TRACK
    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class);
    }
    */

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    #endregion


    #region ACCESSORS AND MUTATORS

    protected function music(): Attribute
    {
        return Attribute::make(
            get: fn(string $value): string => $value,
            set: function (UploadedFile|string $value, array $attributes): string {
                // String only to generate seeds
                if(gettype($value) === 'string'){
                    return $value;
                } else {
                    $music = time() . '.' . $value->extension();
                    Storage::disk('users-data')->putFileAs($attributes['user_id'] . "/music/", $value, $music);

                    return $attributes['user_id'] . "/music/$music";
                }
            }
        );
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn(string $value): string => $value != null ? $value : self::DEFAULT_PREVIEW_TRACK,
            set: function (UploadedFile|string|null $value, array $attributes) {
                // String only to generate seeds
                if(gettype($value === "string")){
                    return $value;
                } else if ($value === null){
                    return 'users-data/'. self::DEFAULT_PREVIEW_TRACK;
                } else {
                    $resizedImage = Image::make($value)
                        ->resize(300, 200);
                    $image = time() . '.' . $value->extension();
                    Storage::disk('users-data')->put($attributes['user_id'] . "/image/$image", $resizedImage->stream());
                    return $attributes['user_id'] . "/image/$image";
                }
            }
        );
    }



    #endregion

    #region SCOPE

    public function scopeRecent(Builder $builder /* Can get optional params to handle conditions below */): Builder
    {
        return $builder->orderBy('created_at', 'desc');
    }

    #endregion

    //TODO: Transform it in accessor
    public function entityUrl($entityPath): string
    {
        return Storage::url($entityPath);
    }
}

