<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Collection\Collection;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'service_id',
        'channel_type_id',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function instance()
    {
        return $this->hasManyThrough(Instance::class, Service::class, 'id', 'id', 'service_id', 'instance_id');
    }

    public function type()
    {
        return $this->belongsTo(ChannelType::class, 'channel_type_id');
    }

    public function channelType()
    {
        return $this->type();
    }

    public function config(): Collection
    {
        return $this->type->config();
    }
}
