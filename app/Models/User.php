<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use JeffGreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasName
{
    use LogsActivity, HasApiTokens, HasFactory, Notifiable, HasRoles, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
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
        'password' => 'hashed',
    ];

    /**
     * Can the user access the admin?
     *
     * @return bool
     */
    public function canAccessFilament(): bool
    {
        return $this->can('access admin');
    }


    /**
     * The user's display name for the admin.
     *
     * @return string
     */
    public function getFilamentName(): string {
        return $this->name;
    }

    /**
     * The instances that belong to the user.
     *
     * @return BelongsToMany
     */
    public function instances(): BelongsToMany {
        return $this->belongsToMany(
            Instance::class
        );
    }

    public function services(): HasManyThrough {
        return $this->hasManyThrough(
            Service::class,
            Instance::class
        );
    }

    /**
     * Service OAuth Tokens
     * @return HasMany
     */
    public function serviceTokens(): HasMany {
        return $this->hasMany(ServiceToken::class);
    }

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()->logFillable();
    }
}
