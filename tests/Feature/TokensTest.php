<?php

namespace AshrafBendary\WebRtcAntMedia\Tests\Feature;

use AshrafBendary\WebRtcAntMedia\Facades\AntMedia;
use AshrafBendary\WebRtcAntMedia\Tests\TestCase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

class TokensTest extends TestCase
{
    public function test_jwt_is_signed_locally_with_the_stream_secret(): void
    {
        Http::fake();
        $expires = now()->addHours(2);

        $token = AntMedia::tokens()->jwt('room1', 'publish', $expires, roomId: 'room1');

        [$header, $payload, $signature] = explode('.', $token);
        $expected = rtrim(strtr(base64_encode(hash_hmac('sha256', "$header.$payload", 'stream-secret', true)), '+/', '-_'), '=');

        $this->assertSame($expected, $signature);
        $this->assertSame([
            'streamId' => 'room1',
            'type' => 'publish',
            'roomId' => 'room1',
            'exp' => $expires->getTimestamp(),
        ], self::decodeJwt($token));
        Http::assertNothingSent();
    }

    public function test_jwt_comes_from_server_when_requested(): void
    {
        Http::fake(['*' => Http::response(['tokenId' => 'server-jwt'])]);

        $token = AntMedia::tokens()->jwt('s1', 'play', 1700000000, fromServer: true);

        $this->assertSame('server-jwt', $token);
        Http::assertSent(fn (Request $r) => $r->url() === 'https://origin.test:5443/LiveApp/rest/v2/broadcasts/s1/jwt-token?expireDate=1700000000&type=play');
    }

    public function test_jwt_falls_back_to_server_without_stream_secret(): void
    {
        config()->set('webrtc-ant-media.stream_jwt_secret', null);
        $this->app->forgetInstance(\AshrafBendary\WebRtcAntMedia\AntMedia::class);
        AntMedia::clearResolvedInstances();
        Http::fake(['*' => Http::response(['tokenId' => 'server-jwt'])]);

        $this->assertSame('server-jwt', AntMedia::tokens()->jwt('s1'));
    }

    public function test_one_time_token(): void
    {
        Http::fake(['*' => Http::response(['tokenId' => 'ott', 'streamId' => 's1'])]);

        $this->assertSame('ott', AntMedia::tokens()->oneTime('s1', 'publish', 1700000000, roomId: 'r1'));
        Http::assertSent(fn (Request $r) => $r->url() === 'https://origin.test:5443/LiveApp/rest/v2/broadcasts/s1/token?expireDate=1700000000&type=publish&roomId=r1');
    }

    public function test_validate_returns_bool(): void
    {
        Http::fake(['*' => Http::response(['success' => false])]);

        $this->assertFalse(AntMedia::tokens()->validate('bad', 's1'));
        Http::assertSent(fn (Request $r) => $r['tokenId'] === 'bad' && $r['streamId'] === 's1' && $r['type'] === 'play');
    }
}
