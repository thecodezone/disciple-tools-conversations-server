<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceToken extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'service',
        'service_id',
        'token',
        'refresh_token',
        'expires_at',
        'name'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query) {
        return $query->where('expires_at', '>', now());
    }

    public function getActiveAttribute() {
        return $this->expires_at > now();
    }
}
