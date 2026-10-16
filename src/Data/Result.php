<?php

namespace AshrafBendary\WebRtcAntMedia\Data;

/**
 * The standard {success, message, dataId, errorId} reply of Ant Media.
 */
final class Result
{
    public function __construct(
        public readonly bool $success,
        public readonly ?string $message = null,
        public readonly ?string $dataId = null,
        public readonly ?int $errorId = null,
        public readonly array $raw = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            success: (bool) ($data['success'] ?? false),
            message: isset($data['message']) ? (string) $data['message'] : null,
            dataId: isset($data['dataId']) ? (string) $data['dataId'] : null,
            errorId: isset($data['errorId']) ? (int) $data['errorId'] : null,
            raw: $data,
        );
    }

    public function toArray(): array
    {
        return $this->raw;
    }
}
