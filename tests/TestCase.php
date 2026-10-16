<?php

namespace AshrafBendary\WebRtcAntMedia\Tests;

use AshrafBendary\WebRtcAntMedia\AntMediaServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [AntMediaServiceProvider::class];
    }

    protected function getPackageAliases($app): array
    {
        return ['AntMedia' => \AshrafBendary\WebRtcAntMedia\Facades\AntMedia::class];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('webrtc-ant-media.origin_url', 'https://origin.test:5443/');
        $app['config']->set('webrtc-ant-media.edge_url', 'https://edge.test:5443');
        $app['config']->set('webrtc-ant-media.app', 'LiveApp');
        $app['config']->set('webrtc-ant-media.jwt_secret', 'rest-secret');
        $app['config']->set('webrtc-ant-media.stream_jwt_secret', 'stream-secret');
        $app['config']->set('webrtc-ant-media.test.app', 'TestApp');
        $app['config']->set('webrtc-ant-media.retries', 0);
        $app['config']->set('webrtc-ant-media.webhook.secret', 'hook-secret');
    }

    protected static function decodeJwt(string $jwt): array
    {
        [, $payload] = explode('.', $jwt);

        return json_decode(base64_decode(strtr($payload, '-_', '+/')), true);
    }
}
