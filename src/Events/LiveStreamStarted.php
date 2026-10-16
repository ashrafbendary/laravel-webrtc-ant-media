<?php

namespace AshrafBendary\WebRtcAntMedia\Events;

use Illuminate\Foundation\Events\Dispatchable;

class LiveStreamStarted
{
    use Dispatchable;

    public function __construct(
        public readonly string $streamId,
        public readonly ?string $roomId,
        public readonly ?string $app,
        public readonly array $payload,
    ) {
    }
}
