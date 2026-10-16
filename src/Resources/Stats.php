<?php

namespace AshrafBendary\WebRtcAntMedia\Resources;

class Stats extends Resource
{
    /**
     * WebRTC, HLS, RTMP and DASH viewer counts of one stream.
     */
    public function broadcast(string $streamId): array
    {
        return $this->client->get('broadcasts/'.self::encode($streamId).'/broadcast-statistics') ?? [];
    }

    public function total(): array
    {
        return $this->client->get('broadcasts/total-broadcast-statistics') ?? [];
    }

    public function webrtcClients(string $streamId, int $offset = 0, int $size = 50): array
    {
        return $this->client->get('broadcasts/'.self::encode($streamId)."/webrtc-client-stats/{$offset}/{$size}") ?? [];
    }

    public function lowLevelSend(): array
    {
        return $this->client->get('broadcasts/webrtc-send-low-level-stats') ?? [];
    }

    public function lowLevelReceive(): array
    {
        return $this->client->get('broadcasts/webrtc-receive-low-level-stats') ?? [];
    }
}
