<?php

namespace Rahulonewayit\PushNotification\Providers;

use Rahulonewayit\PushNotification\PushNotification;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class PushNotificationServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $configPath = $this->app->make('path.config');

        $this->publishes([
            __DIR__.'/../Config/config.php' => $configPath.'/pushnotification.php',
            __DIR__.'/../Config/iosCertificates' => $configPath.'/iosCertificates/',
        ], 'config');
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->singleton('RahulonewayitPushNotification', function ($app) {
            return new PushNotification();
        });

        $this->app->bind(PushNotification::class, 'RahulonewayitPushNotification');
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [
            PushNotification::class,
            'RahulonewayitPushNotification',
        ];
    }
}
