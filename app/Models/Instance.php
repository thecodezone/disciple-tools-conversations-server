<?php

namespace App\Models;

use App\Sdks\DtSdk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Instance extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['name', 'endpoint', 'verification_token'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function channels(): HasManyThrough
    {
        return $this->hasManyThrough(Channel::class, Service::class);
    }

    /**
     * Log options for spatie/activitylog
     *
     * @see https://spatie.be/docs/laravel-activitylog/v4/advanced-usage/logging-model-events
     * @return \Spatie\Activitylog\LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['name', 'email']);
    }

    /**
     * Return the SDK for the DT instance
     */
    public function sdk()
    {
        return app(DtSdk::class, ['instance' => $this]);
    }
}
