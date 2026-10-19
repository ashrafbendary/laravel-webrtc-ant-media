<?php

namespace AshrafBendary\WebRtcAntMedia\Http\Controllers;

use AshrafBendary\WebRtcAntMedia\Events\LiveStreamEnded;
use AshrafBendary\WebRtcAntMedia\Events\LiveStreamStarted;
use AshrafBendary\WebRtcAntMedia\Events\RecordingReady;
use AshrafBendary\WebRtcAntMedia\Events\WebhookReceived;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\IpUtils;

/**
 * Receives Ant Media webhooks (form or JSON) and fires Laravel events.
 * Fails closed: without ANT_MEDIA_WEBHOOK_SECRET every request is rejected.
 */
class WebhookController
{
    public function __invoke(Request $request): JsonResponse
    {
        $secret = (string) config('webrtc-ant-media.webhook.secret');
        $allowedIps = (array) config('webrtc-ant-media.webhook.allowed_ips', []);

        if ($allowedIps !== [] && ! IpUtils::checkIp((string) $request->ip(), $allowedIps)) {
            return response()->json(['message' => 'Webhook sender not allowed.'], 403);
        }

        if ($secret === '' || ! hash_equals($secret, (string) $request->query('secret', $request->header('X-Ant-Media-Secret', '')))) {
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
