<?php

namespace AshrafBendary\WebRtcAntMedia\Support;

/**
 * Minimal HS256 JWT encoder, enough for Ant Media REST and stream tokens.
 */
final class Jwt
{
    public static function encode(array $payload, string $secret): string
    {
        $segments = [
            self::base64Url(json_encode(['alg' => 'HS256', 'typ' => 'JWT'])),
            self::base64Url(json_encode($payload)),
        ];

        $signature = hash_hmac('sha256', implode('.', $segments), $secret, true);
        $segments[] = self::base64Url($signature);

        return implode('.', $segments);
    }

    private static function base64Url(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}
