<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChannelType extends Model
{
    use HasFactory, SoftDeletes;

    //Set primary key
    protected $primaryKey = 'name';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'slug',
        'name',
    ];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function id()
    {
        return Attribute::make(
            get: fn ($value) => $this->name,
            set: fn ($value) => $this->name = $value,
        );
    }

    //Proxy name to ID because for convenience and consistency
    //In new mutation style

    public function config(): array
    {
        return collect(config('webhook-client.configs'))->firstWhere('name', $this->name);
    }
}
