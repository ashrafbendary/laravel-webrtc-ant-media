<?php

namespace AshrafBendary\WebRtcAntMedia\Http\Controllers;

use AshrafBendary\WebRtcAntMedia\Events\LiveStreamEnded;
use AshrafBendary\WebRtcAntMedia\Events\LiveStreamStarted;
use AshrafBendary\WebRtcAntMedia\Events\RecordingReady;
use AshrafBendary\WebRtcAntMedia\Events\WebhookReceived;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Receives Ant Media webhooks (form or JSON) and fires Laravel events.
 */
class WebhookController
{
    public function __invoke(Request $request): JsonResponse
    {
        $secret = config('webrtc-ant-media.webhook.secret');

        if (filled($secret) && ! hash_equals((string) $secret, (string) $request->query('secret', $request->header('X-Ant-Media-Secret', '')))) {
            return response()->json(['message' => 'Invalid webhook secret.'], 403);
        }

        $payload = $request->except('secret');
        $action = (string) ($payload['action'] ?? '');
        $streamId = isset($payload['id']) ? (string) $payload['id'] : null;
        $app = $payload['app'] ?? null;

        if ($action === '') {
            return response()->json(['message' => 'Missing action.'], 422);
        }

        event(new WebhookReceived($action, $streamId, $payload));

        match ($action) {
            'liveStreamStarted' => event(new LiveStreamStarted((string) $streamId, $payload['roomId'] ?? null, $app, $payload)),
            'liveStreamEnded' => event(new LiveStreamEnded((string) $streamId, $payload['roomId'] ?? null, $app, $payload)),
            'vodReady' => event(new RecordingReady((string) $streamId, $payload['vodId'] ?? null, $payload['vodName'] ?? null, $app, $payload)),
            default => null,
        };

        return response()->json(['success' => true]);
    }
}
