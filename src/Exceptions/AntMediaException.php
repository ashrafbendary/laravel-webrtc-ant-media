<?php

namespace AshrafBendary\WebRtcAntMedia\Exceptions;

use Illuminate\Http\Client\Response;
use RuntimeException;

class AntMediaException extends RuntimeException
{
    public ?Response $response = null;

    public static function fromResponse(Response $response, string $method, string $path): self
    {
        $exception = new self(sprintf(
            'Ant Media request %s %s failed with HTTP %d: %s',
            $method,
            $path,
            $response->status(),
            mb_strimwidth((string) $response->body(), 0, 300, '...'),
        ), $response->status());

        $exception->response = $response;

        return $exception;
    }
}
