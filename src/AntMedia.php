<?php

namespace AshrafBendary\WebRtcAntMedia;

use AshrafBendary\WebRtcAntMedia\Resources\Broadcasts;
use AshrafBendary\WebRtcAntMedia\Resources\Cameras;
use AshrafBendary\WebRtcAntMedia\Resources\Endpoints;
use AshrafBendary\WebRtcAntMedia\Resources\Recordings;
use AshrafBendary\WebRtcAntMedia\Resources\Rooms;
use AshrafBendary\WebRtcAntMedia\Resources\Stats;
use AshrafBendary\WebRtcAntMedia\Resources\Subscribers;
use AshrafBendary\WebRtcAntMedia\Resources\Tokens;
use AshrafBendary\WebRtcAntMedia\Resources\Vods;

/**
 * Entry point behind the AntMedia facade.
 *
 * AntMedia::broadcasts()->create(...)          main app (or test app when ANT_MEDIA_USE_TEST_APP=true)
 * AntMedia::test()->broadcasts()->create(...)  test app
 * AntMedia::app('WebRTCAppEE')->...            any other app on the same servers
 */
class AntMedia
{
    protected ?Client $client = null;

    public function __construct(protected array $config, protected ?bool $useTest = null, protected ?string $appName = null)
    {
    }

    /**
     * Use the test application (ANT_MEDIA_TEST_APP).
     */
    public function test(): static
    {
        return new static($this->config, true);
    }

    /**
     * Use the main application (ANT_MEDIA_APP), even when ANT_MEDIA_USE_TEST_APP=true.
     */
    public function main(): static
    {
        return new static($this->config, false);
    }

    /**
     * Use any application by name on the configured servers.
     */
    public function app(string $name): static
    {
        return new static($this->config, $this->useTest, $name);
    }

    public function isTest(): bool
    {
        return $this->useTest ?? (bool) ($this->config['use_test_app'] ?? false);
    }

    public function appName(): string
    {
        return $this->client()->app;
    }

    public function client(): Client
    {
        return $this->client ??= $this->makeClient();
    }

    public function broadcasts(): Broadcasts
    {
        return new Broadcasts($this->client());
    }

    public function rooms(): Rooms
    {
        return new Rooms($this->client());
    }

    public function tokens(): Tokens
    {
        return new Tokens($this->client());
    }

    public function recordings(): Recordings
    {
        return new Recordings($this->client());
    }

    public function vods(): Vods
    {
        return new Vods($this->client());
    }

    public function endpoints(): Endpoints
    {
        return new Endpoints($this->client());
    }

    public function subscribers(): Subscribers
    {
        return new Subscribers($this->client());
    }

    public function stats(): Stats
    {
        return new Stats($this->client());
    }

    public function cameras(): Cameras
    {
        return new Cameras($this->client());
    }

    public function urls(): Urls
    {
        return new Urls($this->client());
    }

    protected function makeClient(): Client
    {
        $main = $this->config;
        $test = $this->isTest() ? array_filter($this->config['test'] ?? [], fn ($v) => filled($v)) : [];

        $pick = fn (string $key) => $test[$key] ?? $main[$key] ?? null;

        $origin = rtrim((string) $pick('origin_url'), '/');
        $edge = rtrim((string) ($pick('edge_url') ?: $origin), '/');

        return new Client(
            app: trim($this->appName ?? (string) $pick('app'), '/'),
            originUrl: $origin,
            edgeUrl: $edge,
            jwtSecret: $pick('jwt_secret'),
            streamJwtSecret: $pick('stream_jwt_secret'),
            timeout: (int) ($main['timeout'] ?? 15),
            retries: (int) ($main['retries'] ?? 1),
            restTokenTtl: (int) ($main['rest_token_ttl'] ?? 60),
        );
    }
}
