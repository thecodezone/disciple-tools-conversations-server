<?php

namespace App\Models;

use App\Services\ServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Services\Service as ServiceInterface;

class Service extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['name', 'instance_id', 'access_token', 'type'];

    public function getNamespaceAttribute(): string {
        return config('services.drivers')[$this->type];
    }

    public function driver(): Service {
        return app(ServiceFactory::class)->make($this->type);
    }


    public function instance(): BelongsTo
    {
        return $this->belongsTo(Instance::class);
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
}
