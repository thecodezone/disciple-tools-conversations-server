<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Instance extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['name', 'endpoint', 'verification_token'];

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @return HasMany
     */
    public function services(): HasMany {
        return $this->hasMany(Service::class);
    }

    /**
     * Log options for spatie/activitylog
     *
     * @see https://spatie.be/docs/laravel-activitylog/v4/advanced-usage/logging-model-events
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()->logOnly(['name', 'email']);
    }
}
