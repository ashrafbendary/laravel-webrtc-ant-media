<?php

namespace AshrafBendary\WebRtcAntMedia\Tests\Feature;

use AshrafBendary\WebRtcAntMedia\Data\Broadcast;
use AshrafBendary\WebRtcAntMedia\Exceptions\AntMediaException;
use AshrafBendary\WebRtcAntMedia\Facades\AntMedia;
use AshrafBendary\WebRtcAntMedia\Tests\TestCase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;

class EndpointsTest extends TestCase
{
    private const BASE = 'https://origin.test:5443/LiveApp/rest/v2/';

    public static function calls(): array
    {
        $ok = ['success' => true, 'dataId' => 'x'];

        return [
            'broadcasts.get' => [fn () => AntMedia::broadcasts()->get('s1'), 'GET', 'broadcasts/s1', ['streamId' => 's1']],
            'broadcasts.list' => [fn () => AntMedia::broadcasts()->list(0, 10, type: 'liveStream', sortBy: 'date', order: 'desc'), 'GET', 'broadcasts/list/0/10?type_by=liveStream&sort_by=date&order_by=desc', [['streamId' => 's1']]],
            'broadcasts.update' => [fn () => AntMedia::broadcasts()->update('s1', ['name' => 'x']), 'PUT', 'broadcasts/s1', $ok],
            'broadcasts.delete' => [fn () => AntMedia::broadcasts()->delete('s1'), 'DELETE', 'broadcasts/s1', $ok],
            'broadcasts.deleteMany' => [fn () => AntMedia::broadcasts()->deleteMany(['a', 'b']), 'DELETE', 'broadcasts?ids=a%2Cb', $ok],
            'broadcasts.start' => [fn () => AntMedia::broadcasts()->start('s1'), 'POST', 'broadcasts/s1/start', $ok],
            'broadcasts.stop' => [fn () => AntMedia::broadcasts()->stop('s1'), 'POST', 'broadcasts/s1/stop', $ok],
            'broadcasts.count' => [fn () => AntMedia::broadcasts()->count(), 'GET', 'broadcasts/count', ['number' => 4]],
            'broadcasts.activeCount' => [fn () => AntMedia::broadcasts()->activeCount(), 'GET', 'broadcasts/active-live-stream-count', ['number' => 2]],
            'broadcasts.info' => [fn () => AntMedia::broadcasts()->info('s1'), 'GET', 'broadcasts/s1/stream-info', [['videoHeight' => 720]]],
            'broadcasts.sendMessage' => [fn () => AntMedia::broadcasts()->sendMessage('s1', ['text' => 'hi']), 'POST', 'broadcasts/s1/data', $ok],
            'rooms.addParticipant' => [fn () => AntMedia::rooms()->addParticipant('r1', 'p1'), 'POST', 'broadcasts/r1/subtrack?id=p1', $ok],
            'rooms.removeParticipant' => [fn () => AntMedia::rooms()->removeParticipant('r1', 'p1'), 'DELETE', 'broadcasts/r1/subtrack?id=p1', $ok],
            'rooms.participants' => [fn () => AntMedia::rooms()->participants('r1'), 'GET', 'broadcasts/r1/subtracks/0/50', [['streamId' => 'p1']]],
            'rooms.activeParticipants' => [fn () => AntMedia::rooms()->activeParticipants('r1'), 'GET', 'broadcasts/r1/active-subtracks/0/50', [['streamId' => 'p1']]],
            'rooms.activeParticipantsCount' => [fn () => AntMedia::rooms()->activeParticipantsCount('r1'), 'GET', 'broadcasts/r1/active-subtracks-count', ['number' => 1]],
            'rooms.end' => [fn () => AntMedia::rooms()->end('r1'), 'POST', 'broadcasts/r1/stop?stopSubtracks=true', $ok],
            'rooms.delete' => [fn () => AntMedia::rooms()->delete('r1'), 'DELETE', 'broadcasts/r1?deleteSubtracks=true', $ok],
            'tokens.list' => [fn () => AntMedia::tokens()->list('s1'), 'GET', 'broadcasts/s1/tokens/list/0/50', []],
            'tokens.revokeAll' => [fn () => AntMedia::tokens()->revokeAll('s1'), 'DELETE', 'broadcasts/s1/tokens', $ok],
            'tokens.validate' => [fn () => AntMedia::tokens()->validate('t1', 's1'), 'POST', 'broadcasts/validate-token', $ok],
            'recordings.start' => [fn () => AntMedia::recordings()->start('s1', 'mp4', 'file1'), 'PUT', 'broadcasts/s1/recording/true?recordType=mp4&fileName=file1', $ok],
            'recordings.stop' => [fn () => AntMedia::recordings()->stop('s1', 'webm'), 'PUT', 'broadcasts/s1/recording/false?recordType=webm', $ok],
            'recordings.hlsToMp4' => [fn () => AntMedia::recordings()->hlsToMp4('s1', true), 'POST', 'broadcasts/s1/hls-to-mp4?deleteHLSFiles=true', $ok],
            'endpoints.add' => [fn () => AntMedia::endpoints()->add('s1', 'rtmp://yt/live2/key', 720), 'POST', 'broadcasts/s1/endpoint?resolutionHeight=720', $ok],
            'endpoints.remove' => [fn () => AntMedia::endpoints()->remove('s1', 'svc1'), 'DELETE', 'broadcasts/s1/endpoint?endpointServiceId=svc1', $ok],
            'subscribers.add' => [fn () => AntMedia::subscribers()->add('s1', ['subscriberId' => 'user_42', 'type' => 'publish']), 'POST', 'broadcasts/s1/subscribers', $ok],
            'subscribers.list' => [fn () => AntMedia::subscribers()->list('s1'), 'GET', 'broadcasts/s1/subscribers/list/0/50', []],
            'subscribers.delete' => [fn () => AntMedia::subscribers()->delete('s1', 'user_42'), 'DELETE', 'broadcasts/s1/subscribers/user_42', $ok],
            'subscribers.revokeAll' => [fn () => AntMedia::subscribers()->revokeAll('s1'), 'DELETE', 'broadcasts/s1/subscribers', $ok],
            'subscribers.block' => [fn () => AntMedia::subscribers()->block('s1', 'user_42', 600), 'PUT', 'broadcasts/s1/subscribers/user_42/block/600/publish_play', $ok],
            'subscribers.connectionEvents' => [fn () => AntMedia::subscribers()->connectionEvents('s1'), 'GET', 'broadcasts/s1/connection-events/0/50', []],
            'stats.broadcast' => [fn () => AntMedia::stats()->broadcast('s1'), 'GET', 'broadcasts/s1/broadcast-statistics', ['totalWebRTCWatchersCount' => 1]],
            'stats.total' => [fn () => AntMedia::stats()->total(), 'GET', 'broadcasts/total-broadcast-statistics', []],
            'stats.webrtcClients' => [fn () => AntMedia::stats()->webrtcClients('s1'), 'GET', 'broadcasts/s1/webrtc-client-stats/0/50', []],
            'stats.lowLevelSend' => [fn () => AntMedia::stats()->lowLevelSend(), 'GET', 'broadcasts/webrtc-send-low-level-stats', []],
            'stats.lowLevelReceive' => [fn () => AntMedia::stats()->lowLevelReceive(), 'GET', 'broadcasts/webrtc-receive-low-level-stats', []],
            'cameras.discover' => [fn () => AntMedia::cameras()->discover(), 'GET', 'broadcasts/onvif-devices', ['192.168.1.50']],
            'cameras.profiles' => [fn () => AntMedia::cameras()->profiles('c1'), 'GET', 'broadcasts/c1/ip-camera/device-profiles', ['p1']],
            'cameras.move' => [fn () => AntMedia::cameras()->move('c1', x: 0.2), 'POST', 'broadcasts/c1/ip-camera/move?valueX=0.2&valueY=0&valueZ=0&movement=relative', $ok],
            'cameras.stopMove' => [fn () => AntMedia::cameras()->stopMove('c1'), 'POST', 'broadcasts/c1/ip-camera/stop-move', $ok],
            'vods.list' => [fn () => AntMedia::vods()->list(0, 20, streamId: 's1'), 'GET', 'vods/list/0/20?streamId=s1', []],
            'vods.get' => [fn () => AntMedia::vods()->get('v1'), 'GET', 'vods/v1', ['vodId' => 'v1']],
            'vods.importDirectory' => [fn () => AntMedia::vods()->importDirectory('/tmp/x'), 'POST', 'vods/directory?directory=%2Ftmp%2Fx', $ok],
            'vods.delete' => [fn () => AntMedia::vods()->delete('v1'), 'DELETE', 'vods/v1', $ok],
            'vods.deleteMany' => [fn () => AntMedia::vods()->deleteMany(['v1', 'v2']), 'DELETE', 'vods?ids=v1%2Cv2', $ok],
            'vods.count' => [fn () => AntMedia::vods()->count(), 'GET', 'vods/count', ['number' => 9]],
        ];
    }

    #[DataProvider('calls')]
    public function test_endpoint(callable $call, string $method, string $path, mixed $response): void
    {
        Http::fake(['*' => Http::response($response)]);

        $call();

        Http::assertSent(fn (Request $r) => $r->method() === $method && $r->url() === self::BASE.$path);
    }

    public function test_create_broadcast_returns_a_dto(): void
    {
        Http::fake(['*' => Http::response(['streamId' => 'abc', 'name' => 'Launch', 'status' => 'created', 'rtmpURL' => 'rtmp://x/LiveApp/abc'])]);

        $stream = AntMedia::broadcasts()->create(['name' => 'Launch'], autoStart: true);

        $this->assertInstanceOf(Broadcast::class, $stream);
        $this->assertSame('abc', $stream->streamId);
        $this->assertSame('rtmp://x/LiveApp/abc', $stream->rtmpURL);
        $this->assertFalse($stream->isLive());
        Http::assertSent(fn (Request $r) => $r->url() === self::BASE.'broadcasts/create?autoStart=true' && $r['name'] === 'Launch');
    }

    public function test_create_room_sends_name_and_custom_id(): void
    {
        Http::fake(['*' => Http::response(['streamId' => 'room-1', 'name' => 'Team'])]);

        $room = AntMedia::rooms()->create(name: 'Team', streamId: 'room-1');

        $this->assertSame('room-1', $room->streamId);
        Http::assertSent(fn (Request $r) => $r->url() === self::BASE.'broadcasts/create' && $r['streamId'] === 'room-1' && $r['name'] === 'Team');
    }

    public function test_create_with_no_data_sends_an_empty_object(): void
    {
        Http::fake(['*' => Http::response(['streamId' => 'auto'])]);

        AntMedia::broadcasts()->create();

        Http::assertSent(fn (Request $r) => $r->body() === '{}');
    }

    public function test_get_returns_null_when_not_found(): void
    {
        Http::fake(['*' => Http::response(null, 404)]);

        $this->assertNull(AntMedia::broadcasts()->get('missing'));
    }

    public function test_failed_requests_throw(): void
    {
        Http::fake(['*' => Http::response('Invalid App JWT Token', 403)]);

        $this->expectException(AntMediaException::class);
        $this->expectExceptionCode(403);

        AntMedia::broadcasts()->count();
    }

    public function test_send_message_posts_raw_json(): void
    {
        Http::fake(['*' => Http::response(['success' => true])]);

        AntMedia::broadcasts()->sendMessage('s1', ['type' => 'chat', 'text' => 'hi']);

        Http::assertSent(fn (Request $r) => $r->body() === '{"type":"chat","text":"hi"}');
    }

    public function test_endpoint_add_sends_url_and_remove_resolves_url_to_service_id(): void
    {
        Http::fake([
            self::BASE.'broadcasts/s1/endpoint*' => Http::response(['success' => true, 'dataId' => 'svc9']),
            self::BASE.'broadcasts/s1' => Http::response(['streamId' => 's1', 'endPointList' => [
                ['endpointUrl' => 'rtmp://yt/live2/key', 'endpointServiceId' => 'svc9'],
            ]]),
        ]);

        $this->assertSame('svc9', AntMedia::endpoints()->add('s1', 'rtmp://yt/live2/key')->dataId);
        AntMedia::endpoints()->remove('s1', 'rtmp://yt/live2/key');

        Http::assertSent(fn (Request $r) => $r->method() === 'POST' && $r['endpointUrl'] === 'rtmp://yt/live2/key');
        Http::assertSent(fn (Request $r) => $r->method() === 'DELETE' && $r->url() === self::BASE.'broadcasts/s1/endpoint?endpointServiceId=svc9');
    }

    public function test_totp_returns_the_code(): void
    {
        Http::fake(['*' => Http::response(['success' => true, 'dataId' => '123456'])]);

        $this->assertSame('123456', AntMedia::subscribers()->totp('s1', 'user_42', 'publish'));
        Http::assertSent(fn (Request $r) => $r->url() === self::BASE.'broadcasts/s1/subscribers/user_42/totp?type=publish');
    }

    public function test_vod_upload_is_multipart(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'vod').'.mp4';
        file_put_contents($file, 'fake');
        Http::fake(['*' => Http::response(['success' => true, 'dataId' => 'v1'])]);

        $result = AntMedia::vods()->upload($file, name: 'Intro');

        $this->assertSame('v1', $result->dataId);
        Http::assertSent(fn (Request $r) => $r->isMultipart() && $r->url() === self::BASE.'vods/create?name=Intro');
        @unlink($file);
    }

    public function test_ids_are_url_encoded(): void
    {
        Http::fake(['*' => Http::response(['success' => true])]);

        AntMedia::broadcasts()->stop('a b/c');

        Http::assertSent(fn (Request $r) => $r->url() === self::BASE.'broadcasts/a%20b%2Fc/stop');
    }
}
