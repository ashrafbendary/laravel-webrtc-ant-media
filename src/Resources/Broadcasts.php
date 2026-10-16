<?php

namespace AshrafBendary\WebRtcAntMedia\Resources;

use AshrafBendary\WebRtcAntMedia\Data\Broadcast;
use AshrafBendary\WebRtcAntMedia\Data\Result;
use AshrafBendary\WebRtcAntMedia\Exceptions\AntMediaException;

class Broadcasts extends Resource
{
    /**
     * Create a live stream. $data accepts any Ant Media Broadcast field
     * (name, streamId, description, type, streamUrl, ipAddr, ...).
     */
    public function create(array $data = [], bool $autoStart = false): Broadcast
    {
        $response = $this->client->post('broadcasts/create', $data ?: '{}', ['autoStart' => $autoStart ?: null]);

        if (! is_array($response) || empty($response['streamId'])) {
            throw new AntMediaException('Ant Media did not return a broadcast: '.json_encode($response));
        }

        return Broadcast::fromArray($response);
    }

    public function get(string $streamId): ?Broadcast
    {
        $response = $this->client->get('broadcasts/'.self::encode($streamId));

        return is_array($response) && isset($response['streamId']) ? Broadcast::fromArray($response) : null;
    }

    /**
     * @return array<int, Broadcast>
     */
    public function list(
        int $offset = 0,
        int $size = 50,
        ?string $type = null,
        ?string $sortBy = null,
        ?string $order = null,
        ?string $search = null,
    ): array {
        return $this->broadcasts($this->client->get("broadcasts/list/{$offset}/{$size}", [
            'type_by' => $type,
            'sort_by' => $sortBy,
            'order_by' => $order,
            'search' => $search,
        ]));
    }

    public function update(string $streamId, array $data): Result
    {
        return $this->result($this->client->put('broadcasts/'.self::encode($streamId), $data));
    }

    public function delete(string $streamId, bool $deleteSubtracks = false): Result
    {
        return $this->result($this->client->delete('broadcasts/'.self::encode($streamId), [
            'deleteSubtracks' => $deleteSubtracks ?: null,
        ]));
    }

    public function deleteMany(array $streamIds): Result
    {
        return $this->result($this->client->delete('broadcasts', ['ids' => implode(',', $streamIds)]));
    }

    /**
     * Start pulling a stream source, IP camera or playlist.
     */
    public function start(string $streamId): Result
    {
        return $this->result($this->client->post('broadcasts/'.self::encode($streamId).'/start'));
    }

    public function stop(string $streamId, bool $stopSubtracks = false): Result
    {
        return $this->result($this->client->post('broadcasts/'.self::encode($streamId).'/stop', null, [
            'stopSubtracks' => $stopSubtracks ?: null,
        ]));
    }

    public function count(): int
    {
        return $this->number($this->client->get('broadcasts/count'));
    }

    public function activeCount(): int
    {
        return $this->number($this->client->get('broadcasts/active-live-stream-count'));
    }

    /**
     * Width, height, bitrate and codec of the incoming stream.
     */
    public function info(string $streamId): array
    {
        return $this->client->get('broadcasts/'.self::encode($streamId).'/stream-info') ?? [];
    }

    /**
     * Send a WebRTC data channel message to everyone on the stream or room.
     */
    public function sendMessage(string $streamId, array|string $message): Result
    {
        $body = is_array($message) ? json_encode($message) : $message;

        return $this->result($this->client->post('broadcasts/'.self::encode($streamId).'/data', $body));
    }
}
