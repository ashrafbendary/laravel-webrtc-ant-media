<?php

namespace AshrafBendary\WebRtcAntMedia\Events;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Fired for every Ant Media webhook call, including actions without a
 * dedicated event (playStarted, subtrackAddedInTheMainTrack, endpointFailed, ...).
 */
class WebhookReceived
{
    use Dispatchable;

    public function __construct(
        public readonly string $action,
        public readonly ?string $streamId,
        public readonly array $payload,
    ) {
    }
}
