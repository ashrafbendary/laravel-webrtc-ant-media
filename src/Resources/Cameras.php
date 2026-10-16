<?php

namespace AshrafBendary\WebRtcAntMedia\Resources;

use AshrafBendary\WebRtcAntMedia\Data\Result;

/**
 * IP cameras (RTSP / ONVIF). Create a camera with
 * AntMedia::broadcasts()->create(['type' => 'ipCamera', ...]).
 */
class Cameras extends Resource
{
    public function discover(): array
    {
        return $this->client->get('broadcasts/onvif-devices') ?? [];
    }

    public function profiles(string $streamId): array
    {
        return $this->client->get('broadcasts/'.self::encode($streamId).'/ip-camera/device-profiles') ?? [];
    }

    /**
     * @param  string  $movement  "relative", "absolute" or "continuous"
     */
    public function move(string $streamId, float $x = 0, float $y = 0, float $zoom = 0, string $movement = 'relative'): Result
    {
        return $this->result($this->client->post('broadcasts/'.self::encode($streamId).'/ip-camera/move', null, [
            'valueX' => $x,
            'valueY' => $y,
            'valueZ' => $zoom,
            'movement' => $movement,
        ]));
    }

    public function stopMove(string $streamId): Result
    {
        return $this->result($this->client->post('broadcasts/'.self::encode($streamId).'/ip-camera/stop-move'));
    }
}
