<?php

namespace App\Models;

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

    public function getRouteKeyName()
    {
        return 'name';
    }

    protected $fillable = [
        'slug',
        'name',
    ];

    public function config(): array
    {
        return collect(config('webhook-client.configs'))->firstWhere('name', $this->name);
    }
}
