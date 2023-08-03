<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Service extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['name', 'instance_id', 'service_type_id', 'access_token'];

    public function getConnectedAttribute()
    {
        return $this->token()->exists() && $this->token->active;
    }

    public function instance(): BelongsTo
    {
        return $this->belongsTo(Instance::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id');
    }

    /**
     * Log options for spatie/activitylog
     *
     * @see https://spatie.be/docs/laravel-activitylog/v4/advanced-usage/logging-model-events
     * @return \Spatie\Activitylog\LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['name', 'access_token', 'type']);
    }

    public function token()
    {
        return $this->belongsTo(ServiceToken::class, 'service_token_id', 'id');
    }

    public function serviceToken()
    {
        return $this->token();
    }

    public function channels()
    {
        return $this->hasMany(Channel::class);
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }
}
