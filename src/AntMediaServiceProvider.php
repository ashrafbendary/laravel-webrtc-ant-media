<?php

namespace AshrafBendary\WebRtcAntMedia;

use AshrafBendary\WebRtcAntMedia\Commands\InstallCommand;
use Illuminate\Support\ServiceProvider;

class AntMediaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/webrtc-ant-media.php', 'webrtc-ant-media');

        $this->app->singleton(AntMedia::class, fn ($app) => new AntMedia($app['config']->get('webrtc-ant-media', [])));
    }

    public function boot(): void
    {
        if (config('webrtc-ant-media.webhook.enabled', true)) {
            $this->loadRoutesFrom(__DIR__.'/../routes/webhook.php');
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/webrtc-ant-media.php' => config_path('webrtc-ant-media.php'),
            ], 'webrtc-ant-media-config');

            $this->commands([InstallCommand::class]);
        }
    }
}
