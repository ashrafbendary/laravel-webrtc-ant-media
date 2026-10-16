<?php

namespace AshrafBendary\WebRtcAntMedia\Resources;

use AshrafBendary\WebRtcAntMedia\Data\Broadcast;
use AshrafBendary\WebRtcAntMedia\Data\Result;

/**
 * Video meeting rooms. A room is a main track; each participant publishes a subtrack.
 */
class Rooms extends Resource
{
    public function create(?string $name = null, ?string $streamId = null, array $data = []): Broadcast
    {
        $data = array_filter(['name' => $name, 'streamId' => $streamId], fn ($v) => $v !== null) + $data;

        return (new Broadcasts($this->client))->create($data);
    }

    public function get(string $roomId): ?Broadcast
    {
        return (new Broadcasts($this->client))->get($roomId);
    }

    public function addParticipant(string $roomId, string $participantStreamId): Result
    {
        return $this->result($this->client->post('broadcasts/'.self::encode($roomId).'/subtrack', null, [
            'id' => $participantStreamId,
        ]));
    }

    public function removeParticipant(string $roomId, string $participantStreamId): Result
    {
        return $this->result($this->client->delete('broadcasts/'.self::encode($roomId).'/subtrack', [
            'id' => $participantStreamId,
        ]));
    }

    /**
     * @return array<int, Broadcast>
     */
    public function participants(string $roomId, int $offset = 0, int $size = 50, ?string $role = null): array
    {
        return $this->broadcasts($this->client->get(
            'broadcasts/'.self::encode($roomId)."/subtracks/{$offset}/{$size}",
            ['role' => $role],
        ));
    }

    /**
     * @return array<int, Broadcast>
     */
    public function activeParticipants(string $roomId, int $offset = 0, int $size = 50, ?string $role = null): array
    {
        return $this->broadcasts($this->client->get(
            'broadcasts/'.self::encode($roomId)."/active-subtracks/{$offset}/{$size}",
            ['role' => $role],
        ));
    }

    public function activeParticipantsCount(string $roomId, ?string $role = null): int
    {
        return $this->number($this->client->get(
            'broadcasts/'.self::encode($roomId).'/active-subtracks-count',
            ['role' => $role],
        ));
    }

    /**
     * End the meeting for everyone (stops the main track and all subtracks).
     */
    public function end(string $roomId): Result
    {
        return (new Broadcasts($this->client))->stop($roomId, stopSubtracks: true);
    }

    public function delete(string $roomId): Result
    {
        return (new Broadcasts($this->client))->delete($roomId, deleteSubtracks: true);
    }
}
