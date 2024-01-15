<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Laravel\Sanctum\HasApiTokens;
use function PHPUnit\Framework\isNull;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable implements MustVerifyEmail
{

    #region Traits

    use HasApiTokens, HasFactory, Notifiable;

    #endregion


    #region CONST

    public const DEFAULT_AVATAR = 'default_avatar.jpg';

    #endregion


    #region ATTRIBUTES

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    #endregion


    #region RELATIONSHIPS


    /**
     * Get all tracks that are assigned to this user.
     */
    public function track_likes(): MorphToMany
    {
        return $this->morphedByMany(Track::class, 'likable');
    }

    /**
     * Get all resources that are assigned to this user.
     */
    public function resource_likes(): MorphToMany
    {
        return $this->morphedByMany(Resource::class, 'likable');
    }

    /*
    public function track_likes(): BelongsToMany {
        return $this->belongsToMany(Track::class);
    }

    public function resource_likes(): BelongsToMany {
        return $this->belongsToMany(Resource::class);
    }
    */

    //Owner
    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class);
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    #endregion


    #region ACCESSORS AND MUTATORS

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => $value ?? self::DEFAULT_AVATAR,
            set: function (UploadedFile|string|null $value, array $attributes): string {
                switch ($value) {
                    case is_string($value):
                        return $value;
                        break;
                    case is_object($value) && get_class($value) === UploadedFile::class:
                        $resizedAvatar = Image::make($value)
                            ->resize(200, 200);
                        $avatar = 'avatar.' . $value->extension();
                        Storage::disk('users-data')->put($attributes['id'] . "/avatar/$avatar", $resizedAvatar->stream());
                        return "$attributes[id]/avatar/$avatar";
                        break;
                }

                return $value ?? $attributes['avatar'];
            },

//            TODO: better way when seed will be improved
//            set: function (?UploadedFile $value, array $attributes): string {
//
//                if (is_null($value)) {
//                    return self::DEFAULT_AVATAR;
//                }
//
//                $resizedAvatar = Image::make($value)
//                    ->resize(200, 200);
//
//                $avatar = 'avatar.' . $value->extension();
//
//                Storage::disk('users-data')->put($attributes['id'] . "/avatar/$avatar", $resizedAvatar->stream());
//
//                return "$attributes[id]/avatar/$avatar";
//            }
        );
    }

    #endregion

}
