<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChannelType extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'classname',
    ];

    public function driver(): \App\Channels\Channel {
        return app()->make($this->classname);
    }
}
