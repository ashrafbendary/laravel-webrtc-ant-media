<?php

namespace AshrafBendary\WebRtcAntMedia\Data;

/**
 * A live stream, meeting room (main track) or participant (subtrack).
 * Any field Ant Media returns is available through $raw or get().
 */
final class Broadcast
{
    public function __construct(
        public readonly string $streamId,
        public readonly ?string $name = null,
        public readonly ?string $status = null,
        public readonly ?string $type = null,
        public readonly ?string $description = null,
        public readonly ?string $rtmpURL = null,
        public readonly ?string $mainTrackStreamId = null,
        public readonly array $subTrackStreamIds = [],
        public readonly array $endPointList = [],
        public readonly int $webRTCViewerCount = 0,
        public readonly int $hlsViewerCount = 0,
        public readonly array $raw = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            streamId: (string) ($data['streamId'] ?? ''),
            name: $data['name'] ?? null,
            status: $data['status'] ?? null,
            type: $data['type'] ?? null,
            description: $data['description'] ?? null,
            rtmpURL: $data['rtmpURL'] ?? null,
            mainTrackStreamId: $data['mainTrackStreamId'] ?? null,
            subTrackStreamIds: $data['subTrackStreamIds'] ?? [],
            endPointList: $data['endPointList'] ?? [],
            webRTCViewerCount: (int) ($data['webRTCViewerCount'] ?? 0),
            hlsViewerCount: (int) ($data['hlsViewerCount'] ?? 0),
            raw: $data,
        );
    }

    public function isLive(): bool
    {
        return $this->status === 'broadcasting';
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return data_get($this->raw, $key, $default);
    }

    public function toArray(): array
    {
        return $this->raw;
    }
}
