<?php

namespace AshrafBendary\WebRtcAntMedia\Tests\Feature;

use AshrafBendary\WebRtcAntMedia\Events\LiveStreamEnded;
use AshrafBendary\WebRtcAntMedia\Events\LiveStreamStarted;
use AshrafBendary\WebRtcAntMedia\Events\RecordingReady;
use AshrafBendary\WebRtcAntMedia\Events\WebhookReceived;
use AshrafBendary\WebRtcAntMedia\Tests\TestCase;
use Illuminate\Support\Facades\Event;

class WebhookTest extends TestCase
{
    public function test_live_stream_started_from_form_payload(): void
    {
        Event::fake();

        $this->post('/ant-media/webhook?secret=hook-secret', [
            'action' => 'liveStreamStarted',
            'id' => 'p1',
            'roomId' => 'room1',
            'app' => 'LiveApp',
        ])->assertOk();

        Event::assertDispatched(LiveStreamStarted::class, fn ($e) => $e->streamId === 'p1' && $e->roomId === 'room1' && $e->app === 'LiveApp');
        Event::assertDispatched(WebhookReceived::class, fn ($e) => $e->action === 'liveStreamStarted' && ! isset($e->payload['secret']));
    }

    public function test_live_stream_ended_and_vod_ready_from_json(): void
    {
        Event::fake();

        $this->postJson('/ant-media/webhook?secret=hook-secret', ['action' => 'liveStreamEnded', 'id' => 's1'])->assertOk();
        $this->postJson('/ant-media/webhook?secret=hook-secret', ['action' => 'vodReady', 'id' => 's1', 'vodId' => 'v1', 'vodName' => 's1.mp4'])->assertOk();

        Event::assertDispatched(LiveStreamEnded::class, fn ($e) => $e->streamId === 's1');
        Event::assertDispatched(RecordingReady::class, fn ($e) => $e->vodId === 'v1' && $e->vodName === 's1.mp4');
    }

    public function test_other_actions_fire_only_the_generic_event(): void
    {
        Event::fake();

        $this->postJson('/ant-media/webhook?secret=hook-secret', ['action' => 'subtrackAddedInTheMainTrack', 'id' => 'p2'])->assertOk();

        Event::assertDispatched(WebhookReceived::class, fn ($e) => $e->action === 'subtrackAddedInTheMainTrack' && $e->streamId === 'p2');
        Event::assertNotDispatched(LiveStreamStarted::class);
    }

    public function test_wrong_secret_is_rejected(): void
    {
        Event::fake();

        $this->postJson('/ant-media/webhook?secret=wrong', ['action' => 'liveStreamStarted', 'id' => 's1'])->assertForbidden();
        $this->postJson('/ant-media/webhook', ['action' => 'liveStreamStarted', 'id' => 's1'])->assertForbidden();

        Event::assertNotDispatched(WebhookReceived::class);
        Event::assertNotDispatched(LiveStreamStarted::class);
    }

    public function test_missing_action_is_rejected(): void
    {
        $this->postJson('/ant-media/webhook?secret=hook-secret', ['id' => 's1'])->assertStatus(422);
    }

    public function test_install_command_publishes_config(): void
    {
        $this->artisan('webrtc-ant-media:install')->assertSuccessful();

        $this->assertFileExists(config_path('webrtc-ant-media.php'));
        @unlink(config_path('webrtc-ant-media.php'));
    }
}
