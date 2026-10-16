<?php

namespace AshrafBendary\WebRtcAntMedia\Resources;

use AshrafBendary\WebRtcAntMedia\Client;
use AshrafBendary\WebRtcAntMedia\Data\Broadcast;
use AshrafBendary\WebRtcAntMedia\Data\Result;

abstract class Resource
{
    public function __construct(protected Client $client)
    {
    }

    protected function result(mixed $response): Result
    {
        return Result::fromArray(is_array($response) ? $response : ['success' => false]);
    }

    /**
     * @return array<int, Broadcast>
     */
    protected function broadcasts(mixed $response): array
    {
        return array_map(
            fn (array $item) => Broadcast::fromArray($item),
            is_array($response) ? array_values($response) : [],
        );
    }

    protected function number(mixed $response): int
    {
        return (int) (is_array($response) ? ($response['number'] ?? 0) : $response);
    }

    protected static function encode(string $id): string
    {
        return rawurlencode($id);
    }
}
