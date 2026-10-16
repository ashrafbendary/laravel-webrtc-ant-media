<?php

namespace AshrafBendary\WebRtcAntMedia\Resources;

use AshrafBendary\WebRtcAntMedia\Data\Result;

class Subscribers extends Resource
{
    /**
     * @param  array  $subscriber  ['subscriberId' => 'user_42', 'type' => 'publish'|'play', 'b32Secret' => ...]
     */
    public function add(string $streamId, array $subscriber): Result
    {
        return $this->result($this->client->post('broadcasts/'.self::encode($streamId).'/subscribers', $subscriber));
    }

    public function list(string $streamId, int $offset = 0, int $size = 50): array
    {
        return $this->client->get('broadcasts/'.self::encode($streamId)."/subscribers/list/{$offset}/{$size}") ?? [];
    }

    public function delete(string $streamId, string $subscriberId): Result
    {
        return $this->result($this->client->delete(
            'broadcasts/'.self::encode($streamId).'/subscribers/'.self::encode($subscriberId),
        ));
    }

    public function revokeAll(string $streamId): Result
    {
        return $this->result($this->client->delete('broadcasts/'.self::encode($streamId).'/subscribers'));
    }

    /**
     * @param  string  $type  "publish", "play" or "publish_play"
     */
    public function block(string $streamId, string $subscriberId, int $seconds, string $type = 'publish_play'): Result
    {
        return $this->result($this->client->put(
            'broadcasts/'.self::encode($streamId).'/subscribers/'.self::encode($subscriberId)."/block/{$seconds}/{$type}",
        ));
    }

    /**
     * Current TOTP code for a subscriber.
     */
    public function totp(string $streamId, string $subscriberId, string $type = 'play'): ?string
    {
        $result = $this->result($this->client->get(
            'broadcasts/'.self::encode($streamId).'/subscribers/'.self::encode($subscriberId).'/totp',
            ['type' => $type],
        ));

        return $result->success ? $result->dataId : null;
    }

    public function connectionEvents(string $streamId, int $offset = 0, int $size = 50, ?string $subscriberId = null): array
    {
        return $this->client->get(
            'broadcasts/'.self::encode($streamId)."/connection-events/{$offset}/{$size}",
            ['subscriberId' => $subscriberId],
        ) ?? [];
    }
}
