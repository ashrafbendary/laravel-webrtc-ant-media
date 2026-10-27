# Laravel WebRTC Ant Media

**English** | [العربية](README.ar.md) | [اردو](README.ur.md) | [हिन्दी](README.hi.md) | [Türkçe](README.tr.md) | [日本語](README.ja.md) | [简体中文](README.zh-CN.md)

### Build a Zoom, Google Meet or Microsoft Teams style video meeting app in Laravel. Self-hosted, scalable WebRTC video conferencing, live streaming and recording powered by Ant Media Server.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](https://packagist.org/packages/ashrafbendary/laravel-webrtc-ant-media)
[![Total Downloads](https://img.shields.io/packagist/dt/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](https://packagist.org/packages/ashrafbendary/laravel-webrtc-ant-media)
[![PHP Version](https://img.shields.io/packagist/php-v/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](https://packagist.org/packages/ashrafbendary/laravel-webrtc-ant-media)
[![License](https://img.shields.io/packagist/l/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](LICENSE)

**Laravel WebRTC Ant Media** is a Laravel package (PHP SDK) for the [Ant Media Server REST API](https://docs.antmedia.io/guides/developer-sdk-and-api/rest-api-guide/). It lets any Laravel application create **video meetings, video calls, webinars, live streams, telemedicine consultations and online classes** with a clean Laravel facade, without paying per-minute fees to Zoom, Twilio, Agora or Vonage.

> Unofficial community package. Not affiliated with Ant Media Inc. "Zoom", "Google Meet" and "Microsoft Teams" are trademarks of their owners and are mentioned only for comparison.

---

## Table of Contents

- [Why this package](#why-this-package)
- [Use cases](#use-cases)
- [Features](#features)
- [How it compares](#how-it-compares)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
  - [Origin, edge, main app and test app](#origin-edge-main-app-and-test-app)
  - [StreamApp and the conference application](#streamapp-and-the-conference-application)
- [Quick start: create a video meeting room](#quick-start-create-a-video-meeting-room)
- [Usage](#usage)
  - [Frontend URLs (WebSocket, HLS, player)](#frontend-urls-websocket-hls-player)
  - [Live streams (broadcasts)](#live-streams-broadcasts)
  - [Video conference rooms (multi-party meetings)](#video-conference-rooms-multi-party-meetings)
  - [Secure access tokens (JWT, one-time token, TOTP)](#secure-access-tokens-jwt-one-time-token-totp)
  - [Recording (MP4 / WebM)](#recording-mp4--webm)
  - [Video on demand (VoD)](#video-on-demand-vod)
  - [Restream to YouTube, Facebook, RTMP and SRT](#restream-to-youtube-facebook-rtmp-and-srt)
  - [Participants and subscribers](#participants-and-subscribers)
  - [Data channel messages (in-meeting chat)](#data-channel-messages-in-meeting-chat)
  - [Statistics and analytics](#statistics-and-analytics)
  - [IP cameras, RTSP and ONVIF](#ip-cameras-rtsp-and-onvif)
  - [Webhooks and Laravel events](#webhooks-and-laravel-events)
- [REST API coverage](#rest-api-coverage)
- [Security, privacy and compliance](#security-privacy-and-compliance)
- [Using this package with AI coding assistants](#using-this-package-with-ai-coding-assistants)
- [FAQ](#faq)
- [Testing](#testing)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

---

## Why this package

Most Laravel video call packages are **peer-to-peer (P2P) WebRTC**. P2P works for 2 or 3 people, then breaks: every participant uploads video to every other participant.

This package uses **Ant Media Server as a WebRTC SFU / media server**, so you get:

- **Scalable video conferencing** with many participants in one room
- **Ultra-low latency live streaming** (WebRTC, around 0.5 seconds) to large audiences
- **Server-side recording** to MP4 or WebM
- **HLS, RTMP, SRT and WebRTC** in one platform
- **Self-hosted** on your own servers or cloud (AWS, Google Cloud, Azure, Oracle Cloud, on-premise), so your video data never leaves your infrastructure

## Use cases

| Use case | What you can build |
|---|---|
| **Telemedicine / telehealth** | Doctor and patient video consultation, virtual clinic, remote second opinion |
| **eLearning / online classes** | Virtual classroom, live lectures, LMS video rooms, recorded courses |
| **Webinars and virtual events** | One-to-many live broadcast with interactive presenters |
| **Team meetings** | Self-hosted Zoom / Google Meet / Teams alternative for your company |
| **Customer support** | Video call support, video KYC, remote inspection |
| **Live commerce** | Live shopping streams with real-time chat |
| **Surveillance** | IP camera (RTSP / ONVIF) live view and recording inside Laravel |
| **Social and creator apps** | Live streaming, go-live features, restream to YouTube and Facebook |

## Features

- Laravel facade, service container binding and auto-discovery
- **Origin and edge servers** plus a **main app and a test app**, all from `.env`
- Ready-made frontend URLs (publish/play WebSocket, HLS, embedded player, RTMP)
- Create, update, list, start, stop and delete **live streams (broadcasts)**
- **Video conference rooms** using Ant Media main track and subtracks
- **JWT**, **one-time token** and **TOTP** stream security for publish and play
- **JWT REST API authentication** (HS256) handled automatically
- Start and stop **recording** per stream (MP4 or WebM), convert HLS to MP4
- **VoD** management: upload, import, list, delete recordings
- **Restream / multistream** to RTMP and SRT endpoints (YouTube Live, Facebook Live, Twitch, LinkedIn Live)
- **Subscriber management**: add, list, block and revoke participants
- **WebRTC data channel** messages for in-meeting chat, reactions and signals
- **Live statistics**: viewers (WebRTC, HLS, RTMP), bitrate, client stats, connection events
- **IP camera** support: RTSP pull, ONVIF discovery, PTZ move
- **Playlists** and seek control for stream sources
- **Webhook receiver** that fires native Laravel events
- Typed DTOs, Laravel HTTP client, retry and timeout configuration
- Works with **Laravel 11, 12 and 13**, PHP 8.2+
- Pairs with Ant Media JavaScript, React, React Native, Flutter, Android and iOS WebRTC SDKs

## How it compares

| | This package | Zoom / Google Meet / Teams | Twilio / Agora / Vonage | P2P Laravel WebRTC packages |
|---|---|---|---|---|
| Self-hosted | Yes | No | No | Yes |
| Data stays on your servers | Yes | No | No | Yes |
| Per-minute fees | No | Subscription | Yes | No |
| Large meetings (SFU) | Yes | Yes | Yes | No (2 to 3 users) |
| Live streaming to thousands | Yes | Limited | Extra cost | No |
| Server-side recording | Yes | Yes | Extra cost | No |
| Embedded in your Laravel app | Yes | Limited | Yes | Yes |
| White label / your branding | Yes | No | Yes | Yes |

## Requirements

- PHP **8.2** or higher
- Laravel **11.x, 12.x or 13.x**
- A running **Ant Media Server** (Community or Enterprise Edition). See the [Ant Media quick start](https://docs.antmedia.io/quick-start/). Checked against Enterprise 4.0.0-SNAPSHOT build 20261022 (see [docs/compatibility.md](docs/compatibility.md)).

## Installation

```bash
composer require ashrafbendary/laravel-webrtc-ant-media
```

Run the installer (publishes the config file and prints the `.env` keys; the webhook route is registered automatically):

```bash
php artisan webrtc-ant-media:install
```

Or publish the config manually:

```bash
php artisan vendor:publish --tag="webrtc-ant-media-config"
```

## Configuration

Add these to your `.env`:

```dotenv
ANT_MEDIA_ORIGIN_URL=https://origin.example.com:5443
ANT_MEDIA_EDGE_URL=https://edge.example.com:5443
ANT_MEDIA_APP=LiveApp
ANT_MEDIA_TEST_APP=WebRTCAppEE
ANT_MEDIA_USE_TEST_APP=false
ANT_MEDIA_JWT_SECRET=your-jwt-rest-api-filter-secret
ANT_MEDIA_STREAM_JWT_SECRET=your-stream-jwt-secret
ANT_MEDIA_TIMEOUT=15
ANT_MEDIA_WEBHOOK_SECRET=your-webhook-secret
ANT_MEDIA_WEBHOOK_ALLOWED_IPS=10.0.0.5
```

| Key | Description |
|---|---|
| `ANT_MEDIA_ORIGIN_URL` | Origin server URL. All REST calls and WebRTC publishing go here. Use port `5443` for HTTPS, `5080` for HTTP (local only). `ANT_MEDIA_URL` is still accepted as an alias |
| `ANT_MEDIA_EDGE_URL` | Optional edge server or edge load balancer, used for playback URLs. Empty = origin |
| `ANT_MEDIA_APP` | Main application name, for example `LiveApp`, `WebRTCAppEE`, `live` or your custom app built from StreamApp |
| `ANT_MEDIA_TEST_APP` | Optional second application for test streams, used by `AntMedia::test()` |
| `ANT_MEDIA_USE_TEST_APP` | `true` sends every call to the test app (handy in local / staging) |
| `ANT_MEDIA_JWT_SECRET` | Secret from **Application Settings > JWT REST API Filter** (HS256) |
| `ANT_MEDIA_STREAM_JWT_SECRET` | Secret for signing publish / play stream tokens |
| `ANT_MEDIA_TIMEOUT` | HTTP timeout in seconds |
| `ANT_MEDIA_RETRIES` | Retries for failed GET requests (POST / PUT / DELETE are never retried). Default `1` |
| `ANT_MEDIA_WEBHOOK_SECRET` | **Required.** Shared secret in the webhook URL. While it is empty, every webhook is rejected |
| `ANT_MEDIA_WEBHOOK_ALLOWED_IPS` | Optional, recommended. Comma-separated IPs or CIDRs of your Ant Media servers; webhooks from any other IP are rejected. Behind a load balancer, configure Laravel trusted proxies first |

Optional test-app overrides (each falls back to the main value): `ANT_MEDIA_TEST_ORIGIN_URL`, `ANT_MEDIA_TEST_EDGE_URL`, `ANT_MEDIA_TEST_JWT_SECRET`, `ANT_MEDIA_TEST_STREAM_JWT_SECRET`.

**Authentication.** Ant Media application REST endpoints accept only `127.0.0.1` by default (IP filter). For a remote Laravel backend, enable the **JWT REST API Filter** in the Ant Media web panel and set the secret above. The package signs a short-lived HS256 token with an `exp` claim and sends it as `Authorization: Bearer {token}` on every request.

### Origin, edge, main app and test app

```php
use AshrafBendary\WebRtcAntMedia\Facades\AntMedia;

AntMedia::broadcasts()->create(['name' => 'Live']);          // main app (ANT_MEDIA_APP)
AntMedia::test()->broadcasts()->create(['name' => 'Try']);   // test app (ANT_MEDIA_TEST_APP)
AntMedia::main()->broadcasts()->list();                      // main app, even if ANT_MEDIA_USE_TEST_APP=true
AntMedia::app('WebRTCAppEE')->broadcasts()->count();         // any other app on the same servers

AntMedia::appName();   // "LiveApp" (or the test app when ANT_MEDIA_USE_TEST_APP=true)
```

- REST API calls and WebRTC **publishing** always use the **origin** server.
- **Playback** URLs (WebRTC play, HLS, embedded player, recordings) use the **edge** server, or the origin when no edge is set.

### StreamApp and the conference application

The old [conference-call-application](https://github.com/ant-media/conference-call-application) (Circle) repository was archived on Aug 31, 2026. [StreamApp](https://github.com/ant-media/StreamApp) is the current base application of Ant Media Server: the default apps (`LiveApp`, `WebRTCAppEE`, `live`) and custom apps are built from it, and it ships conference samples (`conference.html`, `multitrack-conference.html`).

StreamApp is **not** a feature-for-feature replacement of the Circle UI: its conference page covers join/leave, publish/play, screen share, mute and camera toggles and data channel chat, but it has no ready-made recording button, waiting room, virtual background in the conference page, reactions, participant list, pinning, breakout rooms or webinar/moderation UI. This package does not depend on either UI: it talks to the Ant Media REST API, which is the same for every application, so set `ANT_MEDIA_APP` to your StreamApp-based app and build the meeting UI you need.

## Quick start: create a video meeting room

```php
use AshrafBendary\WebRtcAntMedia\Facades\AntMedia;

// 1. Create a meeting room
$room = AntMedia::rooms()->create(name: 'Weekly Team Meeting');

// 2. Give each participant a secure publish + play token (valid 2 hours)
$token = AntMedia::tokens()->jwt(
    streamId: $room->streamId,
    type: 'publish',
    expiresAt: now()->addHours(2),
    roomId: $room->streamId,
);

// 3. Pass $room->streamId and $token to the Ant Media WebRTC JavaScript SDK in your Blade / Vue / React view
return view('meeting', compact('room', 'token'));
```

Or return everything the frontend needs as JSON (no secrets):

```php
return response()->json(AntMedia::urls()->forClient($room->streamId, $token));
// { streamId, token, app, publishWebSocketUrl, playWebSocketUrl, hlsUrl }
```

That is the full backend for a Zoom-style meeting room. The browser side uses the official [Ant Media WebRTC JavaScript SDK](https://docs.antmedia.io/guides/developer-sdk-and-api/sdk-integration/).

## Usage

### Frontend URLs (WebSocket, HLS, player)

```php
AntMedia::urls()->publishWebSocket();              // wss://origin.example.com:5443/LiveApp/websocket
AntMedia::urls()->playWebSocket();                 // wss://edge.example.com:5443/LiveApp/websocket
AntMedia::urls()->hls($streamId, $token);          // https://edge.../LiveApp/streams/{id}.m3u8?token=...
AntMedia::urls()->player($streamId, $token);       // https://edge.../LiveApp/play.html?id=...&token=...
AntMedia::urls()->recording('stream1.mp4');        // https://edge.../LiveApp/streams/stream1.mp4
AntMedia::urls()->rtmp($streamId);                 // rtmp://origin.example.com/LiveApp/{id} (OBS)
AntMedia::urls()->forClient($streamId, $token);    // array for your JS: streamId, token, WebSocket and HLS URLs
AntMedia::test()->urls()->playWebSocket();         // same helpers for the test app
```

### Live streams (broadcasts)

```php
use AshrafBendary\WebRtcAntMedia\Facades\AntMedia;

$stream = AntMedia::broadcasts()->create([
    'name' => 'Product Launch Live',
    'description' => 'Live product launch event',
]);

$stream->streamId;   // e.g. "stream_8f3a..."
$stream->rtmpURL;    // RTMP ingest URL for OBS

AntMedia::broadcasts()->get($stream->streamId);
AntMedia::broadcasts()->list(offset: 0, size: 50, type: 'liveStream', sortBy: 'date', order: 'desc');
AntMedia::broadcasts()->update($stream->streamId, ['name' => 'New title']);
AntMedia::broadcasts()->stop($stream->streamId);
AntMedia::broadcasts()->delete($stream->streamId);
$stream->isLive();                                  // status === "broadcasting"
$stream->get('hlsViewerCount');                     // any other Ant Media field
AntMedia::broadcasts()->deleteMany(['id1', 'id2']);
AntMedia::broadcasts()->count();
AntMedia::broadcasts()->activeCount();
AntMedia::broadcasts()->info($stream->streamId);   // width, height, bitrate, codec
```

### Video conference rooms (multi-party meetings)

A meeting room is a main track. Each participant publishes a subtrack.

```php
$room = AntMedia::rooms()->create(name: 'Consultation 7f3c2a');
$room = AntMedia::rooms()->create(name: 'Class 7A', streamId: 'class-7a');   // choose your own room id
AntMedia::rooms()->get('class-7a');

AntMedia::rooms()->addParticipant($room->streamId, participantStreamId: 'p_9b41e2');
AntMedia::rooms()->participants($room->streamId, offset: 0, size: 50);
AntMedia::rooms()->activeParticipants($room->streamId);
AntMedia::rooms()->activeParticipantsCount($room->streamId);
AntMedia::rooms()->removeParticipant($room->streamId, participantStreamId: 'p_9b41e2');

// End the meeting for everyone
AntMedia::rooms()->end($room->streamId);   // stops main track and subtracks
AntMedia::rooms()->delete($room->streamId); // deletes the room and its subtracks
```

### Secure access tokens (JWT, one-time token, TOTP)

Protect who can **publish** (camera / mic) and who can **play** (watch).

```php
// JWT token (recommended), signed locally with ANT_MEDIA_STREAM_JWT_SECRET, no server round trip
$jwt = AntMedia::tokens()->jwt($streamId, type: 'play', expiresAt: now()->addHour());

// Let Ant Media sign it instead (also used automatically when ANT_MEDIA_STREAM_JWT_SECRET is empty)
$jwt = AntMedia::tokens()->jwt($streamId, type: 'play', expiresAt: now()->addHour(), fromServer: true);

// One-time token generated by Ant Media Server
$oneTime = AntMedia::tokens()->oneTime($streamId, type: 'publish', expiresAt: now()->addMinutes(30));

// TOTP for a subscriber
$totp = AntMedia::subscribers()->totp($streamId, subscriberId: 'user_42', type: 'publish');

AntMedia::tokens()->validate($token, $streamId, type: 'play');   // bool
AntMedia::tokens()->list($streamId);
AntMedia::tokens()->revokeAll($streamId);
```

### Recording (MP4 / WebM)

```php
AntMedia::recordings()->start($streamId, type: 'mp4', fileName: 'rec_7f3c2a');
AntMedia::recordings()->stop($streamId, type: 'mp4');

// Convert an HLS recording to MP4
AntMedia::recordings()->hlsToMp4('stream_8f3a', deleteHlsFiles: true);
```

### Video on demand (VoD)

```php
AntMedia::vods()->list(offset: 0, size: 50, streamId: $streamId, sortBy: 'date', order: 'desc');
AntMedia::vods()->get($vodId);
AntMedia::vods()->upload(storage_path('app/intro.mp4'), name: 'Course Intro');
AntMedia::vods()->importDirectory('/usr/local/antmedia/webapps/live/streams/archive');
AntMedia::vods()->delete($vodId);
AntMedia::vods()->deleteMany([$vodId1, $vodId2]);
AntMedia::vods()->count();
```

### Restream to YouTube, Facebook, RTMP and SRT

```php
$result = AntMedia::endpoints()->add($streamId, 'rtmp://a.rtmp.youtube.com/live2/YOUR-KEY');
$result->dataId;   // endpoint service id
AntMedia::endpoints()->add($streamId, 'srt://ingest.example.com:9000', resolutionHeight: 720);

// Remove by the URL you added or by the endpoint service id
AntMedia::endpoints()->remove($streamId, 'rtmp://a.rtmp.youtube.com/live2/YOUR-KEY');
```

### Participants and subscribers

```php
AntMedia::subscribers()->add($streamId, [
    'subscriberId' => 'user_42',
    'type' => 'publish',   // publish can also play (needed for conferencing)
]);

AntMedia::subscribers()->list($streamId, offset: 0, size: 50);
AntMedia::subscribers()->block($streamId, 'user_42', seconds: 600, type: 'publish_play');
AntMedia::subscribers()->delete($streamId, 'user_42');
AntMedia::subscribers()->revokeAll($streamId);
AntMedia::subscribers()->connectionEvents($streamId, offset: 0, size: 50);
```

### Data channel messages (in-meeting chat)

```php
AntMedia::broadcasts()->sendMessage($streamId, [
    'type' => 'chat',
    'from' => 'Dr. Ahmed',
    'text' => 'Please turn on your camera.',
]);
```

### Statistics and analytics

```php
AntMedia::stats()->broadcast($streamId);        // WebRTC, HLS and RTMP viewer counts
AntMedia::stats()->total();                     // total viewers across the app
AntMedia::stats()->webrtcClients($streamId);    // audio / video bitrate per client
AntMedia::stats()->lowLevelSend();
AntMedia::stats()->lowLevelReceive();
```

### IP cameras, RTSP and ONVIF

```php
$camera = AntMedia::broadcasts()->create([
    'name' => 'Lobby Camera',
    'type' => 'ipCamera',
    'ipAddr' => '192.168.1.50',
    'username' => 'admin',
    'password' => config('services.lobby_camera.password'),
], autoStart: true);

AntMedia::cameras()->discover();                       // ONVIF discovery
AntMedia::cameras()->profiles($camera->streamId);
AntMedia::cameras()->move($camera->streamId, x: 0.2, y: 0, zoom: 0, movement: 'relative');
AntMedia::cameras()->stopMove($camera->streamId);
AntMedia::broadcasts()->start($camera->streamId);      // start pulling a stream source
```

### Webhooks and Laravel events

Point Ant Media **Application Settings > Webhook URL** to (the route is registered automatically):

```
https://your-app.com/ant-media/webhook?secret=ANT_MEDIA_WEBHOOK_SECRET
```

Requests with a wrong or missing `secret`, or from an IP outside `ANT_MEDIA_WEBHOOK_ALLOWED_IPS` (when set), are rejected with HTTP 403. Ant Media does not sign webhooks, so set both. Ant Media can send the webhook as form data or JSON; both work.

Listen to native Laravel events:

```php
use AshrafBendary\WebRtcAntMedia\Events\LiveStreamStarted;
use AshrafBendary\WebRtcAntMedia\Events\LiveStreamEnded;
use AshrafBendary\WebRtcAntMedia\Events\RecordingReady;

Event::listen(LiveStreamStarted::class, fn ($e) => logger("Meeting started: {$e->streamId}"));
Event::listen(LiveStreamEnded::class,   fn ($e) => logger("Meeting ended: {$e->streamId}"));
Event::listen(RecordingReady::class,    fn ($e) => logger("Recording ready: {$e->vodId}"));

// Every webhook action (playStarted, subtrackAddedInTheMainTrack, endpointFailed, ...)
use AshrafBendary\WebRtcAntMedia\Events\WebhookReceived;

Event::listen(WebhookReceived::class, fn ($e) => logger("{$e->action}: {$e->streamId}"));
```

### Endpoints that are not wrapped

Call any other Ant Media endpoint through the underlying client (auth, base URL and app are handled for you):

```php
AntMedia::client()->get("broadcasts/{$streamId}/ip-camera-error");
AntMedia::client()->get('broadcasts/duration', ['url' => $sourceUrl]);
```

Every failed request (HTTP 4xx / 5xx) throws `AshrafBendary\WebRtcAntMedia\Exceptions\AntMediaException`; a `get()` of a missing stream returns `null`.

## REST API coverage

All calls target `{ANT_MEDIA_ORIGIN_URL}/{ANT_MEDIA_APP}/rest/v2/...` (or the test app). Full schemas: [Ant Media Swagger](https://antmedia.io/rest/).

| Package method | HTTP | Ant Media endpoint |
|---|---|---|
| `broadcasts()->create()` | POST | `/broadcasts/create` |
| `broadcasts()->get()` | GET | `/broadcasts/{id}` |
| `broadcasts()->update()` | PUT | `/broadcasts/{id}` |
| `broadcasts()->delete()` | DELETE | `/broadcasts/{id}` |
| `broadcasts()->deleteMany()` | DELETE | `/broadcasts?ids=` |
| `broadcasts()->list()` | GET | `/broadcasts/list/{offset}/{size}` |
| `broadcasts()->count()` | GET | `/broadcasts/count` |
| `broadcasts()->activeCount()` | GET | `/broadcasts/active-live-stream-count` |
| `broadcasts()->start()` | POST | `/broadcasts/{id}/start` |
| `broadcasts()->stop()` | POST | `/broadcasts/{id}/stop` |
| `broadcasts()->info()` | GET | `/broadcasts/{id}/stream-info` |
| `broadcasts()->sendMessage()` | POST | `/broadcasts/{id}/data` |
| `rooms()->addParticipant()` | POST | `/broadcasts/{id}/subtrack` |
| `rooms()->removeParticipant()` | DELETE | `/broadcasts/{id}/subtrack` |
| `rooms()->participants()` | GET | `/broadcasts/{id}/subtracks/{offset}/{size}` |
| `rooms()->activeParticipants()` | GET | `/broadcasts/{id}/active-subtracks/{offset}/{size}` |
| `rooms()->activeParticipantsCount()` | GET | `/broadcasts/{id}/active-subtracks-count` |
| `rooms()->end()` | POST | `/broadcasts/{id}/stop?stopSubtracks=true` |
| `rooms()->delete()` | DELETE | `/broadcasts/{id}?deleteSubtracks=true` |
| `tokens()->oneTime()` | GET | `/broadcasts/{id}/token` |
| `tokens()->jwt()` (server mode) | GET | `/broadcasts/{id}/jwt-token` |
| `tokens()->list()` | GET | `/broadcasts/{id}/tokens/list/{offset}/{size}` |
| `tokens()->revokeAll()` | DELETE | `/broadcasts/{id}/tokens` |
| `tokens()->validate()` | POST | `/broadcasts/validate-token` |
| `recordings()->start()` / `stop()` | PUT | `/broadcasts/{id}/recording/{true\|false}` |
| `recordings()->hlsToMp4()` | POST | `/broadcasts/{hls_filename}/hls-to-mp4` |
| `endpoints()->add()` | POST | `/broadcasts/{id}/endpoint` |
| `endpoints()->remove()` | DELETE | `/broadcasts/{id}/endpoint` |
| `subscribers()->add()` | POST | `/broadcasts/{id}/subscribers` |
| `subscribers()->list()` | GET | `/broadcasts/{id}/subscribers/list/{offset}/{size}` |
| `subscribers()->delete()` | DELETE | `/broadcasts/{id}/subscribers/{sid}` |
| `subscribers()->revokeAll()` | DELETE | `/broadcasts/{id}/subscribers` |
| `subscribers()->block()` | PUT | `/broadcasts/{id}/subscribers/{sid}/block/{seconds}/{type}` |
| `subscribers()->totp()` | GET | `/broadcasts/{id}/subscribers/{sid}/totp` |
| `subscribers()->connectionEvents()` | GET | `/broadcasts/{id}/connection-events/{offset}/{size}` |
| `stats()->broadcast()` | GET | `/broadcasts/{id}/broadcast-statistics` |
| `stats()->total()` | GET | `/broadcasts/total-broadcast-statistics` |
| `stats()->webrtcClients()` | GET | `/broadcasts/{id}/webrtc-client-stats/{offset}/{size}` |
| `stats()->lowLevelSend()` | GET | `/broadcasts/webrtc-send-low-level-stats` |
| `stats()->lowLevelReceive()` | GET | `/broadcasts/webrtc-receive-low-level-stats` |
| `cameras()->discover()` | GET | `/broadcasts/onvif-devices` |
| `cameras()->profiles()` | GET | `/broadcasts/{id}/ip-camera/device-profiles` |
| `cameras()->move()` | POST | `/broadcasts/{id}/ip-camera/move` |
| `cameras()->stopMove()` | POST | `/broadcasts/{id}/ip-camera/stop-move` |
| `vods()->list()` | GET | `/vods/list/{offset}/{size}` |
| `vods()->get()` | GET | `/vods/{id}` |
| `vods()->upload()` | POST | `/vods/create` |
| `vods()->importDirectory()` | POST | `/vods/directory` |
| `vods()->delete()` | DELETE | `/vods/{id}` |
| `vods()->deleteMany()` | DELETE | `/vods?ids=` |
| `vods()->count()` | GET | `/vods/count` |

## Security, privacy and compliance

Because Ant Media Server is self-hosted, you choose where video and recordings are stored. This makes it easier to meet **data residency** and privacy requirements such as **GDPR**, **HIPAA**, **Saudi PDPL**, UAE and other national data protection laws. Compliance depends on your full deployment, not on this package alone.

Recommended setup:

- Run Ant Media Server in the region your data law requires. For Saudi personal and health data use a KSA region (for example Google Cloud Dammam, Oracle Cloud Jeddah or on-premise; the AWS Saudi Arabia region is planned for December 2026). AWS Bahrain and UAE are outside KSA, so using them is a cross-border transfer under PDPL. For EU data, use EU regions
- Use HTTPS on port `5443` with a valid SSL certificate
- Enable **JWT REST API Filter**; never expose the REST API publicly by IP alone
- Enable stream **publish / play token security** for every meeting
- Give tokens a short `exp`, and revoke tokens and subscribers when a meeting ends
- Store recordings in encrypted storage and log who accessed them
- Record the participant's consent (purpose, version, timestamp) before starting a recording, use random file names, and delete recordings on a retention schedule
- Make listing or downloading recordings a separate, logged permission, and make sure play-token security also covers recording URLs (`/{app}/streams/...`)
- Keep names and IDs of patients or students out of stream names, stream IDs and file names; use random IDs and map them in your own database
- Never pass request input straight into `broadcasts()->create()`, `broadcasts()->update()` or `endpoints()->add()`: stream source and restream URLs can be abused to reach internal servers or copy a meeting out
- Self-host the Ant Media JavaScript SDK and run your own STUN/TURN server in the same region; allow camera, microphone and your Ant Media origin (Permissions-Policy and CSP) only on meeting pages

## Using this package with AI coding assistants

Using Claude, ChatGPT, Cursor, GitHub Copilot or another AI assistant to build your app? Tell it:

> "Use the Laravel package `ashrafbendary/laravel-webrtc-ant-media` to build a self-hosted video meeting app with Ant Media Server. Read its README and llms.txt first."

This repository includes `llms.txt` and `AGENTS.md` with usage rules for AI agents.

## FAQ

**How do I build a Zoom clone in Laravel?**
Install this package, run Ant Media Server, create a room with `AntMedia::rooms()->create()`, issue JWT tokens per participant, and connect the browser with the Ant Media WebRTC JavaScript SDK. See [Quick start](#quick-start-create-a-video-meeting-room).

**Is this a free Zoom alternative?**
The package is free and open source (MIT). Ant Media Server has a free Community Edition and a paid Enterprise Edition. Multi-party conferencing and ultra-low latency WebRTC at scale are Enterprise features, so check Ant Media licensing for your case.

**What is the difference between this and P2P WebRTC packages?**
P2P sends video directly between browsers and works for 2 to 3 people. This package uses a media server (SFU), so it supports large meetings, live streaming to big audiences and server-side recording.

**Can I use it for telemedicine?**
Yes. Common telehealth features (secure rooms, short-lived tokens, recording, self-hosted data) are covered. Your deployment must still meet your local healthcare regulations.

**Does it support live streaming to YouTube or Facebook?**
Yes, use `AntMedia::endpoints()->add()` with the RTMP or SRT ingest URL.

**Which frontends are supported?**
Blade, Livewire, Inertia, Vue, React and plain JavaScript on the web, plus React Native, Flutter, Android and iOS through the official Ant Media SDKs.

**Does it work with Laravel Octane, Horizon and queues?**
Yes. All calls use the Laravel HTTP client and are safe to run in jobs.

**Does it support Ant Media Server cluster mode?**
Yes. Set `ANT_MEDIA_ORIGIN_URL` to your origin (or origin load balancer) and `ANT_MEDIA_EDGE_URL` to your edge load balancer.

**Is StreamApp the replacement of the conference-call-application?**
StreamApp is the current base app and the conference-call-application repository is archived, but StreamApp does not have all of its UI features. See [StreamApp and the conference application](#streamapp-and-the-conference-application).

**How do I test without touching production streams?**
Set `ANT_MEDIA_TEST_APP`, then use `AntMedia::test()`, or set `ANT_MEDIA_USE_TEST_APP=true` in your local / staging `.env`.

## Testing

```bash
composer test
```

The package uses `Http::fake()`, so tests never call a real media server.

## Contributing

Pull requests are welcome. Please open an issue first for major changes and add tests for new endpoints.

## Credits

- [Ashraf Bendary](https://github.com/ashrafbendary)
- Built on the [Ant Media Server REST API](https://antmedia.io/rest/)

## License

The MIT License (MIT). See [LICENSE](LICENSE).

---

**Keywords:** laravel webrtc, laravel video conference, laravel video call, laravel video meeting, laravel zoom clone, zoom alternative, google meet alternative, microsoft teams alternative, self-hosted video conferencing, laravel live streaming, webrtc php, ant media server, ant media laravel, antmedia php sdk, webrtc sfu, low latency streaming, hls, rtmp, srt, video recording, telemedicine laravel, telehealth video, elearning video, virtual classroom, webinar platform, laravel package
