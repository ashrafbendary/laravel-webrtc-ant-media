<?php

namespace AshrafBendary\WebRtcAntMedia;

/**
 * Ready-made URLs for the frontend. Publishing uses the origin server,
 * playback uses the edge server (or origin when no edge is configured).
 */
class Urls
{
    public function __construct(protected Client $client)
    {
    }

    /**
     * WebSocket URL for publishing (camera/mic) with the Ant Media WebRTC SDK.
     */
    public function publishWebSocket(): string
    {
        return self::toWebSocket($this->client->originUrl).'/'.$this->client->app.'/websocket';
    }

    /**
     * WebSocket URL for playing (watching) with the Ant Media WebRTC SDK.
     */
    public function playWebSocket(): string
    {
        return self::toWebSocket($this->client->edgeUrl).'/'.$this->client->app.'/websocket';
    }

    /**
     * Ant Media embedded player page (play.html from StreamApp).
     */
    public function player(string $streamId, ?string $token = null, array $options = []): string
    {
        $query = array_filter(['id' => $streamId, 'token' => $token] + $options, fn ($v) => $v !== null);

        return $this->client->edgeUrl.'/'.$this->client->app.'/play.html?'.http_build_query($query);
    }

    public function hls(string $streamId, ?string $token = null): string
    {
        $url = $this->client->edgeUrl.'/'.$this->client->app.'/streams/'.rawurlencode($streamId).'.m3u8';

        return $token ? $url.'?token='.rawurlencode($token) : $url;
    }

    /**
     * URL of a recorded file (VoD), e.g. "stream1.mp4".
     */
    public function recording(string $fileName): string
    {
        return $this->client->edgeUrl.'/'.$this->client->app.'/streams/'.rawurlencode($fileName);
    }

    /**
     * RTMP ingest URL for OBS or other encoders.
     */
    public function rtmp(string $streamId): string
    {
        $host = parse_url($this->client->originUrl, PHP_URL_HOST);

        return 'rtmp://'.$host.'/'.$this->client->app.'/'.$streamId;
    }

    /**
     * Everything the frontend needs, safe to return as JSON (no secrets).
     */
    public function forClient(string $streamId, ?string $token = null): array
    {
        return [
            'streamId' => $streamId,
            'token' => $token,
            'app' => $this->client->app,
            'publishWebSocketUrl' => $this->publishWebSocket(),
            'playWebSocketUrl' => $this->playWebSocket(),
            'hlsUrl' => $this->hls($streamId, $token),
        ];
    }

    protected static function toWebSocket(string $url): string
    {
        return preg_replace(['#^https://#i', '#^http://#i'], ['wss://', 'ws://'], $url);
    }
}
