<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Auth::viaRequest('token', function (Request $request) {
            $token = false;

            if ($request->has('token')) {
               $token = $request->input('token');
            } elseif(session()->get('token')) {
               $token = session()->get('token');
            }

            if (!$token) {
                return null;
            }

            $token = PersonalAccessToken::findToken($token);

            if (!$token) {
                return null;
            }

            $user = $token->tokenable;

            return $user;
        });
    }
}
