<?php

namespace AshrafBendary\WebRtcAntMedia\Events;

use Illuminate\Foundation\Events\Dispatchable;

class RecordingReady
{
    use Dispatchable;

    public function __construct(
        public readonly string $streamId,
        public readonly ?string $vodId,
        public readonly ?string $vodName,
        public readonly ?string $app,
        public readonly array $payload,
    ) {
    }
}
