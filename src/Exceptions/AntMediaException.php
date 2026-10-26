<?php

namespace AshrafBendary\WebRtcAntMedia\Exceptions;

use Illuminate\Http\Client\Response;
use RuntimeException;

class AntMediaException extends RuntimeException
{
    public ?Response $response = null;

    public static function fromResponse(Response $response, string $method, string $path): self
    {
        // JSON bodies may hold stream names or other personal data, so only their
        // "message" goes into the exception text (and so into logs). The full
        // response stays available on $exception->response.
        $json = $response->json();
        $detail = is_array($json)
            ? (string) ($json['message'] ?? '')
            : mb_strimwidth((string) $response->body(), 0, 300, '...');

        $exception = new self(sprintf(
            'Ant Media request %s %s failed with HTTP %d: %s',
            $method,
            $path,
            $response->status(),
            $detail,
        ), $response->status());

        $exception->response = $response;

        return $exception;
    }
}
