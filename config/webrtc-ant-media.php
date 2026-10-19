<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Servers
    |--------------------------------------------------------------------------
    |
    | origin_url: the Ant Media origin server. All REST API calls and WebRTC
    |             publishing go here. Use https://host:5443 in production.
    | edge_url:   optional edge server (or edge load balancer) used for playback
    |             URLs (WebRTC play, HLS, embedded player). Falls back to origin.
    |
    */

    'origin_url' => env('ANT_MEDIA_ORIGIN_URL', env('ANT_MEDIA_URL', 'http://localhost:5080')),

    'edge_url' => env('ANT_MEDIA_EDGE_URL'),

    /*
    |--------------------------------------------------------------------------
    | Main application
    |--------------------------------------------------------------------------
    |
    | The Ant Media application your Laravel app uses, for example "LiveApp",
    | "WebRTCAppEE", "live" or a custom app built from StreamApp.
    |
    */

    'app' => env('ANT_MEDIA_APP', 'LiveApp'),

    // Secret from Application Settings > JWT REST API Filter (HS256).
    'jwt_secret' => env('ANT_MEDIA_JWT_SECRET'),

    // Secret from Application Settings > Publish/Play JWT token security.
    'stream_jwt_secret' => env('ANT_MEDIA_STREAM_JWT_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Test application
    |--------------------------------------------------------------------------
    |
    | A second Ant Media application for testing streams without touching the
    | main one. Use it with AntMedia::test(), or set ANT_MEDIA_USE_TEST_APP=true
    | (for example in local/staging) to send every call to the test app.
    | Every empty value falls back to the main settings above.
    |
    */

    'test' => [
        'app' => env('ANT_MEDIA_TEST_APP'),
        'origin_url' => env('ANT_MEDIA_TEST_ORIGIN_URL'),
        'edge_url' => env('ANT_MEDIA_TEST_EDGE_URL'),
        'jwt_secret' => env('ANT_MEDIA_TEST_JWT_SECRET'),
        'stream_jwt_secret' => env('ANT_MEDIA_TEST_STREAM_JWT_SECRET'),
    ],

    'use_test_app' => (bool) env('ANT_MEDIA_USE_TEST_APP', false),

    /*
    |--------------------------------------------------------------------------
    | HTTP client
    |--------------------------------------------------------------------------
    */

    'timeout' => (int) env('ANT_MEDIA_TIMEOUT', 15),

    // Retries for GET requests only (POST/PUT/DELETE are never retried).
    'retries' => (int) env('ANT_MEDIA_RETRIES', 1),

    // Lifetime in seconds of the JWT the package signs for each REST call.
    'rest_token_ttl' => 60,

    /*
    |--------------------------------------------------------------------------
    | Webhook
    |--------------------------------------------------------------------------
    |
    | Set Ant Media Application Settings > Webhook URL to:
    | https://your-app.com/ant-media/webhook?secret=ANT_MEDIA_WEBHOOK_SECRET
    |
    | secret:      required. While it is empty every webhook is rejected (403).
    | allowed_ips: comma-separated IPs / CIDRs of your Ant Media servers. When
    |              set, webhooks from any other IP are rejected (403). Behind a
    |              load balancer, configure Laravel's trusted proxies first.
    |
    */

    'webhook' => [
        'enabled' => (bool) env('ANT_MEDIA_WEBHOOK_ENABLED', true),
        'path' => 'ant-media/webhook',
        'secret' => env('ANT_MEDIA_WEBHOOK_SECRET'),
        'allowed_ips' => array_values(array_filter(array_map('trim', explode(',', (string) env('ANT_MEDIA_WEBHOOK_ALLOWED_IPS', ''))))),
        'middleware' => ['api'],
    ],

];
