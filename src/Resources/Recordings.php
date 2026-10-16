<?php

namespace AshrafBendary\WebRtcAntMedia\Resources;

use AshrafBendary\WebRtcAntMedia\Data\Result;

class Recordings extends Resource
{
    /**
     * @param  string  $type  "mp4" or "webm"
     */
    public function start(string $streamId, string $type = 'mp4', ?string $fileName = null, ?int $resolutionHeight = null): Result
    {
        return $this->result($this->client->put('broadcasts/'.self::encode($streamId).'/recording/true', null, [
            'recordType' => $type,
            'fileName' => $fileName,
            'resolutionHeight' => $resolutionHeight,
        ]));
    }

    public function stop(string $streamId, string $type = 'mp4', ?int $resolutionHeight = null): Result
    {
        return $this->result($this->client->put('broadcasts/'.self::encode($streamId).'/recording/false', null, [
            'recordType' => $type,
            'resolutionHeight' => $resolutionHeight,
        ]));
    }

    /**
     * Convert an HLS recording (file name without .m3u8) to MP4.
     */
    public function hlsToMp4(string $hlsFileName, bool $deleteHlsFiles = false): mixed
    {
        return $this->client->post('broadcasts/'.self::encode($hlsFileName).'/hls-to-mp4', null, [
            'deleteHLSFiles' => $deleteHlsFiles,
        ]);
    }
}
