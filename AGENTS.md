# AGENTS.md

Instructions for AI coding agents (Claude, ChatGPT, Cursor, GitHub Copilot, Codex, Gemini and others) that use or modify `ashrafbendary/laravel-webrtc-ant-media`.

## What this package is

A Laravel wrapper for the Ant Media Server REST API (`{ANT_MEDIA_URL}/{ANT_MEDIA_APP}/rest/v2/...`). It runs on the **backend only**. Real-time audio/video in the browser or mobile app is handled by the official Ant Media WebRTC SDKs (JavaScript, React Native, Flutter, Android, iOS), not by this package.

## Building an app with this package

1. Install: `composer require ashrafbendary/laravel-webrtc-ant-media`, then `php artisan webrtc-ant-media:install`.
2. Configure `.env`: `ANT_MEDIA_ORIGIN_URL` (alias `ANT_MEDIA_URL`), optional `ANT_MEDIA_EDGE_URL`, `ANT_MEDIA_APP`, optional `ANT_MEDIA_TEST_APP`, `ANT_MEDIA_JWT_SECRET`, `ANT_MEDIA_STREAM_JWT_SECRET`. Use `AntMedia::test()` for test streams; never hard-code server URLs, use `AntMedia::urls()`.
3. Always use the facade `AshrafBendary\WebRtcAntMedia\Facades\AntMedia`. Do not hand-write HTTP calls to Ant Media when a package method exists (see the REST API coverage table in README.md).
4. A meeting room = `AntMedia::rooms()->create()`. Each participant publishes a subtrack and needs its own token.
5. Issue a short-lived token per participant with `AntMedia::tokens()->jwt(...)` (type `publish` for camera/mic, `play` for watch-only). Never send secrets to the frontend; only send the `streamId` and the token.
6. On the frontend, load the Ant Media WebRTC JS SDK and connect with that `streamId` and token. Get the WebSocket URLs from `AntMedia::urls()->forClient($streamId, $token)` (publish = origin, play = edge).
7. End meetings with `AntMedia::rooms()->end($streamId)`, then `AntMedia::tokens()->revokeAll($streamId)`.
8. Use webhook events (`LiveStreamStarted`, `LiveStreamEnded`, `RecordingReady`) instead of polling.

## Security rules (do not skip)

- Never expose the Ant Media REST API to the public internet; use the JWT REST API Filter.
- Never put `ANT_MEDIA_JWT_SECRET` or `ANT_MEDIA_STREAM_JWT_SECRET` in JavaScript, Blade output or API responses.
- Give tokens a short `exp` and authorize the Laravel user before issuing one (policies/gates).
- Use HTTPS (port 5443) in production. Port 5080 HTTP is for local testing only.
- For healthcare or personal data, host Ant Media Server in the required region and store recordings encrypted. For Saudi data that means a KSA region (AWS Bahrain/UAE are cross-border under PDPL).
- Rate-limit the app route that issues tokens, and return a token only for a room the current user may join (no IDOR on room or stream IDs).
- Webhooks: always set `ANT_MEDIA_WEBHOOK_SECRET` (the route rejects everything without it) and `ANT_MEDIA_WEBHOOK_ALLOWED_IPS`. Ant Media does not sign webhooks.
- Never pass request input straight into `broadcasts()->create()`, `broadcasts()->update()` or `endpoints()->add()`. Build the array yourself from validated fields; `streamUrl`, `ipAddr`, `listenerHookURL` and restream URLs can be abused for SSRF or to copy a meeting to an outside server. Allow-list restream hosts.
- Keep personal data out of stream names, stream IDs, room IDs and recording file names. Use random IDs and map them in your own database.
- Before `recordings()->start()`, store the participant's consent (purpose, version, channel, timestamp). Delete recordings with a scheduled retention job.
- Listing or downloading recordings (`vods()`, `urls()->recording()`) is a separate permission from joining a meeting. Log every access with actor id, record id, action, timestamp and IP only (no names, no payloads).
- Do not log webhook payloads or `$broadcast->toArray()`; they can contain stream names. Keep audit logs for at least 12 months (NCA ECC).
- Frontend: self-host the Ant Media JavaScript SDK (no public CDN), use your own STUN/TURN server in the same region, and allow camera, microphone and the Ant Media origin (Permissions-Policy and CSP `connect-src` / `media-src`) only on meeting pages.

## Do not invent

- Do not invent methods, config keys or events that are not documented in README.md or llms.txt.
- If a needed Ant Media endpoint is not wrapped, call it through the underlying client and say so, or check https://antmedia.io/rest/.
- Do not claim the package itself makes an app GDPR/HIPAA/PDPL compliant.

## Contributing to this package

- PHP 8.2+, Laravel 11/12/13, PSR-12, typed DTOs.
- Every new endpoint needs a test using `Http::fake()`; tests must never call a real server.
- Keep README.md and all translated READMEs (`README.ar.md`, `README.ur.md`, `README.hi.md`, `README.tr.md`, `README.ja.md`, `README.zh-CN.md`) and `llms.txt` in sync when the public API changes.
