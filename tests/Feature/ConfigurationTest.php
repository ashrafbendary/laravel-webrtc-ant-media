<?php

namespace AshrafBendary\WebRtcAntMedia\Tests\Feature;

use AshrafBendary\WebRtcAntMedia\Facades\AntMedia;
use AshrafBendary\WebRtcAntMedia\Tests\TestCase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

class ConfigurationTest extends TestCase
{
    public function test_rest_calls_go_to_the_origin_main_app_with_a_signed_bearer_token(): void
    {
        Http::fake(['*' => Http::response(['number' => 3])]);

        $this->assertSame(3, AntMedia::broadcasts()->count());

        Http::assertSent(function (Request $request) {
            $token = substr($request->header('Authorization')[0], 7);
            [$header, $payload, $signature] = explode('.', $token);
            $expected = rtrim(strtr(base64_encode(hash_hmac('sha256', "$header.$payload", 'rest-secret', true)), '+/', '-_'), '=');

            return $request->url() === 'https://origin.test:5443/LiveApp/rest/v2/broadcasts/count'
                && $signature === $expected
                && self::decodeJwt($token)['exp'] > time();
        });
    }

    public function test_test_app_is_used_on_demand(): void
    {
        Http::fake(['*' => Http::response(['number' => 1])]);

        AntMedia::test()->broadcasts()->count();

        Http::assertSent(fn (Request $r) => $r->url() === 'https://origin.test:5443/TestApp/rest/v2/broadcasts/count');
        $this->assertTrue(AntMedia::test()->isTest());
        $this->assertSame('TestApp', AntMedia::test()->appName());
    }

    public function test_use_test_app_switches_the_default_and_main_switches_back(): void
    {
        config()->set('webrtc-ant-media.use_test_app', true);
        config()->set('webrtc-ant-media.test.origin_url', 'https://test-origin.test');
        $this->app->forgetInstance(\AshrafBendary\WebRtcAntMedia\AntMedia::class);
        AntMedia::clearResolvedInstances();

        $this->assertSame('TestApp', AntMedia::appName());
        $this->assertSame('https://test-origin.test', AntMedia::client()->originUrl);
        $this->assertSame('LiveApp', AntMedia::main()->appName());
        $this->assertSame('https://origin.test:5443', AntMedia::main()->client()->originUrl);
    }

    public function test_any_app_can_be_targeted_by_name(): void
    {
        Http::fake(['*' => Http::response(['number' => 0])]);

        AntMedia::app('WebRTCAppEE')->vods()->count();

        Http::assertSent(fn (Request $r) => $r->url() === 'https://origin.test:5443/WebRTCAppEE/rest/v2/vods/count');
    }

    public function test_no_authorization_header_without_jwt_secret(): void
    {
        config()->set('webrtc-ant-media.jwt_secret', null);
        $this->app->forgetInstance(\AshrafBendary\WebRtcAntMedia\AntMedia::class);
        AntMedia::clearResolvedInstances();
        Http::fake(['*' => Http::response(['number' => 0])]);

        AntMedia::broadcasts()->count();

        Http::assertSent(fn (Request $r) => ! $r->hasHeader('Authorization'));
    }

    public function test_urls_use_origin_for_publishing_and_edge_for_playback(): void
    {
        $urls = AntMedia::urls();

        $this->assertSame('wss://origin.test:5443/LiveApp/websocket', $urls->publishWebSocket());
        $this->assertSame('wss://edge.test:5443/LiveApp/websocket', $urls->playWebSocket());
        $this->assertSame('https://edge.test:5443/LiveApp/streams/room1.m3u8', $urls->hls('room1'));
        $this->assertSame('https://edge.test:5443/LiveApp/play.html?id=room1&token=abc', $urls->player('room1', 'abc'));
        $this->assertSame('https://edge.test:5443/LiveApp/streams/room1.mp4', $urls->recording('room1.mp4'));
        $this->assertSame('rtmp://origin.test/LiveApp/room1', $urls->rtmp('room1'));

        $client = $urls->forClient('room1', 'abc');
        $this->assertSame('abc', $client['token']);
        $this->assertArrayNotHasKey('jwtSecret', $client);
    }

    public function test_edge_falls_back_to_origin(): void
    {
        config()->set('webrtc-ant-media.edge_url', null);
        config()->set('webrtc-ant-media.origin_url', 'http://localhost:5080');
        $this->app->forgetInstance(\AshrafBendary\WebRtcAntMedia\AntMedia::class);
        AntMedia::clearResolvedInstances();

        $this->assertSame('ws://localhost:5080/LiveApp/websocket', AntMedia::urls()->playWebSocket());
    }

    public function test_only_get_requests_are_retried(): void
    {
        config()->set('webrtc-ant-media.retries', 2);
        $this->app->forgetInstance(\AshrafBendary\WebRtcAntMedia\AntMedia::class);
        AntMedia::clearResolvedInstances();
        Http::fake(['*' => Http::sequence()
            ->push(null, 500)->push(['number' => 5])
            ->push(['success' => false], 500)->push(['streamId' => 'dup'])]);

        $this->assertSame(5, AntMedia::broadcasts()->count());

        try {
            AntMedia::broadcasts()->create(['name' => 'x']);
            $this->fail('Expected exception');
        } catch (\AshrafBendary\WebRtcAntMedia\Exceptions\AntMediaException) {
        }

        Http::assertSentCount(3);
    }
}
