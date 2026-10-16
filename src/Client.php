<?php

namespace AshrafBendary\WebRtcAntMedia;

use AshrafBendary\WebRtcAntMedia\Exceptions\AntMediaException;
use AshrafBendary\WebRtcAntMedia\Support\Jwt;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 * Thin HTTP client for one Ant Media application:
 * {originUrl}/{app}/rest/v2/...
 *
 * Use it directly for any endpoint the package does not wrap:
 * AntMedia::client()->get('broadcasts/{id}/ip-camera-error').
 */
class Client
{
    public function __construct(
        public readonly string $app,
        public readonly string $originUrl,
        public readonly string $edgeUrl,
        public readonly ?string $jwtSecret = null,
        public readonly ?string $streamJwtSecret = null,
        public readonly int $timeout = 15,
        public readonly int $retries = 1,
        public readonly int $restTokenTtl = 60,
    ) {
    }

    public function baseUrl(): string
    {
        return $this->originUrl.'/'.$this->app.'/rest/v2';
    }

    public function get(string $path, array $query = []): mixed
    {
        return $this->send('GET', $path, $query);
    }

    public function post(string $path, mixed $body = null, array $query = []): mixed
    {
        return $this->send('POST', $path, $query, $body);
    }

    public function put(string $path, mixed $body = null, array $query = []): mixed
    {
        return $this->send('PUT', $path, $query, $body);
    }

    public function delete(string $path, array $query = []): mixed
    {
        return $this->send('DELETE', $path, $query);
    }

    /**
     * Upload a file as multipart/form-data (field "file").
     */
    public function upload(string $path, string $filePath, array $query = [], array $fields = []): mixed
    {
        $request = $this->request(json: false)->attach('file', fopen($filePath, 'r'), basename($filePath));

        $response = $request->post($this->url($path, $query), $fields);

        return $this->decode($response, 'POST', $path);
    }

    /**
     * Send a request and return the decoded JSON (array, scalar or null on 404).
     */
    public function send(string $method, string $path, array $query = [], mixed $body = null): mixed
    {
        // Only GET is retried, so a slow POST never creates a stream twice.
        $request = $this->request(retry: $method === 'GET');

        if (is_string($body)) {
            $request = $request->withBody($body, 'application/json');
            $body = null;
        }

        $url = $this->url($path, $query);

        $response = match ($method) {
            'GET' => $request->get($url),
            'POST' => $request->post($url, $body ?? []),
            'PUT' => $request->put($url, $body ?? []),
            'DELETE' => $request->delete($url),
        };

        return $this->decode($response, $method, $path);
    }

    /**
     * Short-lived HS256 token for the JWT REST API Filter.
     */
    public function restToken(): ?string
    {
        if (blank($this->jwtSecret)) {
            return null;
        }

        return Jwt::encode(['exp' => time() + $this->restTokenTtl], $this->jwtSecret);
    }

    protected function request(bool $json = true, bool $retry = false): PendingRequest
    {
        $request = Http::acceptJson()->timeout($this->timeout);

        if ($json) {
            $request = $request->asJson();
        }

        if ($retry && $this->retries > 0) {
            $request = $request->retry($this->retries, 200, throw: false);
        }

        if ($token = $this->restToken()) {
            $request = $request->withToken($token);
        }

        return $request;
    }

    protected function url(string $path, array $query = []): string
    {
        $url = $this->baseUrl().'/'.ltrim($path, '/');

        $query = array_filter($query, fn ($value) => $value !== null);

        if ($query === []) {
            return $url;
        }

        $query = array_map(fn ($value) => is_bool($value) ? ($value ? 'true' : 'false') : $value, $query);

        return $url.'?'.http_build_query($query, '', '&', PHP_QUERY_RFC3986);
    }

    protected function decode(Response $response, string $method, string $path): mixed
    {
        if ($response->status() === 404 && $method === 'GET') {
            return null;
        }

        if ($response->failed()) {
            throw AntMediaException::fromResponse($response, $method, $path);
        }

        $body = trim((string) $response->body());

        if ($body === '') {
            return null;
        }

        return $response->json() ?? $body;
    }
}
