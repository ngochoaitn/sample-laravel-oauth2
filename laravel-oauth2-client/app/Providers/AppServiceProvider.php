<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Passport\PassportExtendSocialite;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //

        // $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');

        // $socialite->extend(
        //     'passport',
        //     function ($app) use ($socialite) {
        //         $config = $app['config']['services.passport'];
        //         return $socialite->buildProvider(PassportExtendSocialite::class, $config);
        //     }
        // );
        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            // die('okoko');
            $event->extendSocialite('laravelpassport', \SocialiteProviders\LaravelPassport\Provider::class);
        });

        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('zoho', \SocialiteProviders\Zoho\Provider::class);
        });
    }
}
