<?php

namespace AshrafBendary\WebRtcAntMedia\Resources;

use AshrafBendary\WebRtcAntMedia\Data\Result;

/**
 * Video on demand: recordings and uploaded files.
 */
class Vods extends Resource
{
    public function list(
        int $offset = 0,
        int $size = 50,
        ?string $streamId = null,
        ?string $sortBy = null,
        ?string $order = null,
        ?string $search = null,
    ): array {
        return $this->client->get("vods/list/{$offset}/{$size}", [
            'streamId' => $streamId,
            'sort_by' => $sortBy,
            'order_by' => $order,
            'search' => $search,
        ]) ?? [];
    }

    public function get(string $vodId): ?array
    {
        return $this->client->get('vods/'.self::encode($vodId));
    }

    public function upload(string $filePath, ?string $name = null, ?array $metadata = null): Result
    {
        $fields = $metadata === null ? [] : ['metadata' => json_encode($metadata)];

        return $this->result($this->client->upload('vods/create', $filePath, [
            'name' => $name ?? basename($filePath),
        ], $fields));
    }

    public function importDirectory(string $directory): Result
    {
        return $this->result($this->client->post('vods/directory', null, ['directory' => $directory]));
    }

    public function delete(string $vodId): Result
    {
        return $this->result($this->client->delete('vods/'.self::encode($vodId)));
    }

    public function deleteMany(array $vodIds): Result
    {
        return $this->result($this->client->delete('vods', ['ids' => implode(',', $vodIds)]));
    }

    public function count(): int
    {
        return $this->number($this->client->get('vods/count'));
    }
}
