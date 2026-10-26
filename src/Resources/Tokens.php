<?php

namespace AshrafBendary\WebRtcAntMedia\Resources;

use AshrafBendary\WebRtcAntMedia\Data\Result;
use AshrafBendary\WebRtcAntMedia\Exceptions\AntMediaException;
use AshrafBendary\WebRtcAntMedia\Support\Jwt;
use DateTimeInterface;

/**
 * Publish / play tokens. Send only the streamId and the token to the frontend.
 */
class Tokens extends Resource
{
    /**
     * JWT stream token. Signed locally with ANT_MEDIA_STREAM_JWT_SECRET (no server
     * round trip). Without that secret, or with $fromServer, Ant Media signs it.
     */
    public function jwt(
        string $streamId,
        string $type = 'play',
        DateTimeInterface|int|null $expiresAt = null,
        ?string $roomId = null,
        bool $fromServer = false,
    ): string {
        $exp = self::timestamp($expiresAt);

        if (! $fromServer && filled($this->client->streamJwtSecret)) {
            return Jwt::encode(array_filter([
                'streamId' => $streamId,
                'type' => $type,
                'roomId' => $roomId,
                'exp' => $exp,
            ], fn ($v) => $v !== null), $this->client->streamJwtSecret);
        }

        return $this->tokenId($this->client->get('broadcasts/'.self::encode($streamId).'/jwt-token', [
            'expireDate' => $exp,
            'type' => $type,
            'roomId' => $roomId,
        ]));
    }

    /**
     * One-time token generated and stored by Ant Media Server.
     */
    public function oneTime(
        string $streamId,
        string $type = 'play',
        DateTimeInterface|int|null $expiresAt = null,
        ?string $roomId = null,
    ): string {
        return $this->tokenId($this->client->get('broadcasts/'.self::encode($streamId).'/token', [
            'expireDate' => self::timestamp($expiresAt),
            'type' => $type,
            'roomId' => $roomId,
        ]));
    }

    public function validate(string $token, ?string $streamId = null, string $type = 'play'): bool
    {
        $response = $this->client->post('broadcasts/validate-token', array_filter([
            'tokenId' => $token,
            'streamId' => $streamId,
            'type' => $type,
        ], fn ($v) => $v !== null));

        return $this->result($response)->success;
    }

    public function list(string $streamId, int $offset = 0, int $size = 50): array
    {
        return $this->client->get('broadcasts/'.self::encode($streamId)."/tokens/list/{$offset}/{$size}") ?? [];
    }

    public function revokeAll(string $streamId): Result
    {
        return $this->result($this->client->delete('broadcasts/'.self::encode($streamId).'/tokens'));
    }

    protected function tokenId(mixed $response): string
    {
        if (! is_array($response) || empty($response['tokenId'])) {
            throw new AntMediaException('Ant Media did not return a token.');
        }

        return $response['tokenId'];
    }

    protected static function timestamp(DateTimeInterface|int|null $expiresAt): int
    {
        return match (true) {
            $expiresAt instanceof DateTimeInterface => $expiresAt->getTimestamp(),
            is_int($expiresAt) => $expiresAt,
            default => time() + 3600,
        };
    }
}
