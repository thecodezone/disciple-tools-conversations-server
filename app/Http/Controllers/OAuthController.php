<?php

namespace App\Http\Controllers;

use App\Events\OAuthSuccess;
use App\Models\ServiceToken;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Url\Url;

class OAuthController extends Controller
{
    const OAUTH_RETURN_KEY = 'OAUTH_RETURN';

    protected $callbackDataDefaults = [
        'service' => null,
        'serviceId' => null,
        'instanceId' => null,
        'returnUrl' => null,
    ];

    /**
     * Redirect to the OAuth provider
     *
     * @param string $service
     *
     * @return mixed
     */
    public function redirect(string $service, Request $request)
    {
        if (! in_array($service, array_keys(config('services')))) {
            abort(404);
        }

        session()->put(self::OAUTH_RETURN_KEY, $request->input('returnUrl', config('app.url')));

        return Socialite::driver($service)
            ->scopes(config("services.$service.scopes", []))
            ->redirect();
    }

    /**
     * Handle the OAuth callback
     *
     * @param string $service
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback(string $service, Request $request)
    {
        if (! in_array($service, array_keys(config('services')))) {
            abort(404);
        }

        $redirectTo = session()->pull(self::OAUTH_RETURN_KEY, config('app.url'));
        $socialUser = Socialite::driver($service)->user();
        $user = $request->user();

        if (! $socialUser->token || ! $user) {
            abort(401, 'Unauthorized');
        }

        $token = ServiceToken::updateOrCreate([
            'user_id' => $request->user()->id,
            'service' => $service,
        ], [
            'name' => $socialUser->name ?? "{$service} token",
            'service_id' => $socialUser->id,
            'token' => $socialUser->token,
            'refresh_token' => $socialUser->refreshToken,
            'expires_at' => now()->addSeconds($socialUser->expiresIn),
        ]);

        OAuthSuccess::dispatch($user, $token);
        $query = $request->query();
        $query['serviceTokenId'] = $token->id;
        $returnTo = Url::fromString($redirectTo)->withQueryParameters($query);

        return redirect()->to($returnTo);
    }
}
