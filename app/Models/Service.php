<?php

namespace App\Models;

use App\Webhooks\WebhookDriver;
use App\Webhooks\WebhookDriverFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Psy\Util\Str;
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
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()->logOnly(['name', 'access_token', 'type']);
    }

    public function token()
    {
        return $this->belongsTo(ServiceToken::class, 'service_token_id', 'id');
    }

    public function channels()
    {
        return $this->hasMany(Channel::class);
    }
}
