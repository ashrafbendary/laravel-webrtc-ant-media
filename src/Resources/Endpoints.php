<?php

namespace AshrafBendary\WebRtcAntMedia\Resources;

use AshrafBendary\WebRtcAntMedia\Data\Result;

/**
 * Restream to RTMP / SRT destinations (YouTube, Facebook, Twitch, ...).
 */
class Endpoints extends Resource
{
    /**
     * Result::$dataId holds the endpoint service id.
     */
    public function add(string $streamId, string $url, ?int $resolutionHeight = null): Result
    {
        return $this->result($this->client->post(
            'broadcasts/'.self::encode($streamId).'/endpoint',
            ['endpointUrl' => $url],
            ['resolutionHeight' => $resolutionHeight],
        ));
    }

    /**
     * @param  string  $endpoint  the endpoint service id, or the RTMP/SRT URL you added
     */
    public function remove(string $streamId, string $endpoint, ?int $resolutionHeight = null): Result
    {
        if (str_contains($endpoint, '://')) {
            $endpoint = $this->serviceIdFor($streamId, $endpoint) ?? $endpoint;
        }

        return $this->result($this->client->delete('broadcasts/'.self::encode($streamId).'/endpoint', [
            'endpointServiceId' => $endpoint,
            'resolutionHeight' => $resolutionHeight,
        ]));
    }

    protected function serviceIdFor(string $streamId, string $url): ?string
    {
        $broadcast = (new Broadcasts($this->client))->get($streamId);

        foreach ($broadcast?->endPointList ?? [] as $item) {
            if (($item['endpointUrl'] ?? null) === $url) {
                return $item['endpointServiceId'] ?? null;
            }
        }

        return null;
    }
}
