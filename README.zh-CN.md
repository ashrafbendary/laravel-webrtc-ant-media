# Laravel WebRTC Ant Media

[English](README.md) | [العربية](README.ar.md) | [اردو](README.ur.md) | [हिन्दी](README.hi.md) | [Türkçe](README.tr.md) | [日本語](README.ja.md) | **简体中文**

> 🇨🇳 **国内镜像（访问更快）：** [gitcode.com/ashrafbendary/laravel-webrtc-ant-media](https://gitcode.com/ashrafbendary/laravel-webrtc-ant-media)，与 GitHub 仓库自动同步。

### 用 Laravel 构建类似 Zoom、Google Meet 或 Microsoft Teams 的视频会议应用。基于 Ant Media Server，支持私有化部署（自托管）、可扩展的 WebRTC 视频会议、低延迟直播与会议录制。

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](https://packagist.org/packages/ashrafbendary/laravel-webrtc-ant-media)
[![Total Downloads](https://img.shields.io/packagist/dt/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](https://packagist.org/packages/ashrafbendary/laravel-webrtc-ant-media)
[![PHP Version](https://img.shields.io/packagist/php-v/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](https://packagist.org/packages/ashrafbendary/laravel-webrtc-ant-media)
[![License](https://img.shields.io/packagist/l/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](LICENSE)

**Laravel WebRTC Ant Media** 是一个面向 [Ant Media Server REST API](https://docs.antmedia.io/guides/developer-sdk-and-api/rest-api-guide/) 的 Laravel 扩展包（PHP SDK）。它让任何 Laravel 应用都能通过简洁的 Laravel Facade 实现 **视频会议、视频通话（音视频通话）、网络研讨会、直播、远程医疗问诊和在线教育（网课）**，无需向 Zoom、Twilio、Agora 或 Vonage 按分钟付费。

> 非官方社区扩展包，与 Ant Media Inc. 无任何关联。“Zoom”、“Google Meet” 和 “Microsoft Teams” 是其各自所有者的商标，本文仅出于对比目的提及。

---

## 目录

- [为什么选择这个扩展包](#why-this-package)
- [应用场景](#use-cases)
- [功能特性](#features)
- [方案对比](#how-it-compares)
- [环境要求](#requirements)
- [安装](#installation)
- [配置](#configuration)
- [快速开始：创建视频会议室](#quick-start-create-a-video-meeting-room)
- [使用方法](#usage)
  - [直播（广播流）](#live-streams-broadcasts)
  - [视频会议室（多人会议）](#video-conference-rooms-multi-party-meetings)
  - [安全访问令牌（JWT、一次性令牌、TOTP）](#secure-access-tokens-jwt-one-time-token-totp)
  - [录制（MP4 / WebM）](#recording-mp4--webm)
  - [视频点播（VoD）](#video-on-demand-vod)
  - [转推到 YouTube、Facebook、RTMP 和 SRT](#restream-to-youtube-facebook-rtmp-and-srt)
  - [参会者与订阅者](#participants-and-subscribers)
  - [数据通道消息（会中聊天）](#data-channel-messages-in-meeting-chat)
  - [统计与分析](#statistics-and-analytics)
  - [IP 摄像头、RTSP 和 ONVIF](#ip-cameras-rtsp-and-onvif)
  - [Webhook 与 Laravel 事件](#webhooks-and-laravel-events)
- [REST API 覆盖范围](#rest-api-coverage)
- [安全、隐私与合规](#security-privacy-and-compliance)
- [配合 AI 编程助手使用](#using-this-package-with-ai-coding-assistants)
- [常见问题](#faq)
- [测试](#testing)
- [参与贡献](#contributing)
- [致谢](#credits)
- [许可证](#license)

---

<a id="why-this-package"></a>

## 为什么选择这个扩展包

大多数 Laravel 视频通话扩展包都是 **点对点（P2P）WebRTC**。P2P 在 2 到 3 人时可用，人数再多就会失效：每个参会者都要把视频上传给其他所有参会者。

本扩展包将 **Ant Media Server 作为 WebRTC SFU / 媒体服务器**，因此你可以获得：

- **可扩展的视频会议**，单个房间支持多人参会
- **超低延迟直播**（WebRTC，约 0.5 秒），面向大规模观众
- **服务端录制**，输出 MP4 或 WebM
- **HLS、RTMP、SRT 和 WebRTC** 集于一个平台
- **私有化部署（自托管）**，运行在你自己的服务器或云上（AWS、Google Cloud、Azure、Oracle Cloud、本地机房），视频数据不会离开你的基础设施

<a id="use-cases"></a>

## 应用场景

| 应用场景 | 你可以构建什么 |
|---|---|
| **远程医疗 / 互联网医院** | 医患视频问诊、线上诊室、远程第二诊疗意见 |
| **在线教育 / 网课** | 虚拟教室、直播授课、LMS 视频房间、录播课程 |
| **网络研讨会与线上活动** | 一对多直播，支持主讲人互动 |
| **团队会议** | 为企业打造的自托管 Zoom / Google Meet / Teams / 腾讯会议 替代方案 |
| **客户服务** | 视频客服、视频 KYC、远程查勘 |
| **直播电商** | 带实时聊天的直播带货 |
| **安防监控** | 在 Laravel 中实现 IP 摄像头（RTSP / ONVIF）实时查看与录像 |
| **社交与创作者应用** | 直播、开播功能、转推到 YouTube 和 Facebook |

<a id="features"></a>

## 功能特性

- Laravel Facade、服务容器绑定与自动发现
- 创建、更新、列出、启动、停止和删除 **直播流（广播）**
- 基于 Ant Media 主轨道（main track）与子轨道（subtrack）的 **视频会议室**
- 推流与播放的 **JWT**、**一次性令牌** 和 **TOTP** 流安全机制
- 自动处理 **JWT REST API 认证**（HS256）
- 按流启动和停止 **录制**（MP4 或 WebM），支持将 HLS 转换为 MP4
- **VoD** 管理：上传、导入、列出、删除录像
- **转推 / 多路推流** 到 RTMP 和 SRT 端点（YouTube Live、Facebook Live、Twitch、LinkedIn Live）
- **订阅者管理**：添加、列出、封禁和撤销参会者
- **WebRTC 数据通道** 消息，用于会中聊天、表情互动和信令
- **实时统计**：观众数（WebRTC、HLS、RTMP）、码率、客户端统计、连接事件
- **IP 摄像头** 支持：RTSP 拉流、ONVIF 发现、PTZ 云台控制
- 流源的 **播放列表** 与进度跳转控制
- **Webhook 接收器**，触发原生 Laravel 事件
- 强类型 DTO、Laravel HTTP 客户端、可配置的重试与超时
- 支持 **Laravel 11、12 和 13**，PHP 8.2+
- 可搭配 Ant Media JavaScript、React、React Native、Flutter、Android 和 iOS WebRTC SDK 使用

<a id="how-it-compares"></a>

## 方案对比

| | 本扩展包 | Zoom / Google Meet / Teams | Twilio / Agora / Vonage | P2P Laravel WebRTC 扩展包 |
|---|---|---|---|---|
| 私有化部署 | 是 | 否 | 否 | 是 |
| 数据保留在你自己的服务器 | 是 | 否 | 否 | 是 |
| 按分钟计费 | 否 | 订阅制 | 是 | 否 |
| 大型会议（SFU） | 是 | 是 | 是 | 否（2 至 3 人） |
| 面向数千人直播 | 是 | 有限 | 额外收费 | 否 |
| 服务端录制 | 是 | 是 | 额外收费 | 否 |
| 嵌入你的 Laravel 应用 | 是 | 有限 | 是 | 是 |
| 白标 / 自有品牌 | 是 | 否 | 是 | 是 |

<a id="requirements"></a>

## 环境要求

- PHP **8.2** 或更高版本
- Laravel **11.x、12.x 或 13.x**
- 一个正在运行的 **Ant Media Server**（社区版或企业版）。参见 [Ant Media 快速入门](https://docs.antmedia.io/quick-start/)。

<a id="installation"></a>

## 安装

```bash
composer require ashrafbendary/laravel-webrtc-ant-media
```

运行安装命令（发布配置文件和 Webhook 路由）：

```bash
php artisan webrtc-ant-media:install
```

或手动发布配置文件：

```bash
php artisan vendor:publish --tag="webrtc-ant-media-config"
```

<a id="configuration"></a>

## 配置

将以下内容添加到 `.env`：

```dotenv
ANT_MEDIA_URL=https://media.example.com:5443
ANT_MEDIA_APP=live
ANT_MEDIA_JWT_SECRET=your-jwt-rest-api-filter-secret
ANT_MEDIA_STREAM_JWT_SECRET=your-stream-jwt-secret
ANT_MEDIA_TIMEOUT=15
ANT_MEDIA_WEBHOOK_SECRET=your-webhook-secret
```

| 配置项 | 说明 |
|---|---|
| `ANT_MEDIA_URL` | Ant Media Server 基础 URL。HTTPS 使用端口 `5443`，HTTP 使用 `5080`（仅限本地） |
| `ANT_MEDIA_APP` | 应用名称，例如 `live`、`WebRTCAppEE` 或你的自定义应用 |
| `ANT_MEDIA_JWT_SECRET` | 来自 **Application Settings > JWT REST API Filter** 的密钥（HS256） |
| `ANT_MEDIA_STREAM_JWT_SECRET` | 用于签发推流 / 播放令牌的密钥 |
| `ANT_MEDIA_TIMEOUT` | HTTP 超时时间（秒） |
| `ANT_MEDIA_WEBHOOK_SECRET` | 用于校验传入 Webhook 的共享密钥 |

**认证。** Ant Media 应用的 REST 端点默认只接受来自 `127.0.0.1` 的请求（IP 过滤）。如果 Laravel 后端部署在远程服务器，请在 Ant Media Web 管理面板中启用 **JWT REST API Filter** 并设置上面的密钥。扩展包会签发带有 `exp` 声明的短时效 HS256 令牌，并在每次请求中以 `Authorization: Bearer {token}` 发送。

<a id="quick-start-create-a-video-meeting-room"></a>

## 快速开始：创建视频会议室

```php
use AshrafBendary\WebRtcAntMedia\Facades\AntMedia;

// 1. 创建会议室
$room = AntMedia::rooms()->create(name: 'Weekly Team Meeting');

// 2. 为每位参会者签发安全的推流 + 播放令牌（有效期 2 小时）
$token = AntMedia::tokens()->jwt(
    streamId: $room->streamId,
    type: 'publish',
    expiresAt: now()->addHours(2),
    roomId: $room->streamId,
);

// 3. 在 Blade / Vue / React 视图中将 $room->streamId 和 $token 传给 Ant Media WebRTC JavaScript SDK
return view('meeting', compact('room', 'token'));
```

这就是一个 Zoom 风格在线会议室的完整后端。浏览器端使用官方的 [Ant Media WebRTC JavaScript SDK](https://docs.antmedia.io/guides/developer-sdk-and-api/sdk-integration/)。

<a id="usage"></a>

## 使用方法

<a id="live-streams-broadcasts"></a>

### 直播（广播流）

```php
use AshrafBendary\WebRtcAntMedia\Facades\AntMedia;

$stream = AntMedia::broadcasts()->create([
    'name' => 'Product Launch Live',
    'description' => 'Live product launch event',
]);

$stream->streamId;   // 例如 "stream_8f3a..."
$stream->rtmpURL;    // 供 OBS 使用的 RTMP 推流地址

AntMedia::broadcasts()->get($stream->streamId);
AntMedia::broadcasts()->list(offset: 0, size: 50, type: 'liveStream', sortBy: 'date', order: 'desc');
AntMedia::broadcasts()->update($stream->streamId, ['name' => 'New title']);
AntMedia::broadcasts()->stop($stream->streamId);
AntMedia::broadcasts()->delete($stream->streamId);
AntMedia::broadcasts()->deleteMany(['id1', 'id2']);
AntMedia::broadcasts()->count();
AntMedia::broadcasts()->activeCount();
AntMedia::broadcasts()->info($stream->streamId);   // 宽度、高度、码率、编解码器
```

<a id="video-conference-rooms-multi-party-meetings"></a>

### 视频会议室（多人会议）

一个会议室就是一个主轨道（main track），每位参会者推送一个子轨道（subtrack）。

```php
$room = AntMedia::rooms()->create(name: 'Doctor Consultation #1024');

AntMedia::rooms()->addParticipant($room->streamId, participantStreamId: 'patient_1024');
AntMedia::rooms()->participants($room->streamId, offset: 0, size: 50);
AntMedia::rooms()->activeParticipants($room->streamId);
AntMedia::rooms()->activeParticipantsCount($room->streamId);
AntMedia::rooms()->removeParticipant($room->streamId, participantStreamId: 'patient_1024');

// 为所有人结束会议
AntMedia::rooms()->end($room->streamId);   // 停止主轨道及所有子轨道
```

<a id="secure-access-tokens-jwt-one-time-token-totp"></a>

### 安全访问令牌（JWT、一次性令牌、TOTP）

控制谁可以 **推流**（摄像头 / 麦克风）以及谁可以 **播放**（观看）。

```php
// JWT 令牌（推荐），在本地签发，无需请求服务器
$jwt = AntMedia::tokens()->jwt($streamId, type: 'play', expiresAt: now()->addHour());

// 由 Ant Media Server 生成的一次性令牌
$oneTime = AntMedia::tokens()->oneTime($streamId, type: 'publish', expiresAt: now()->addMinutes(30));

// 为订阅者生成 TOTP
$totp = AntMedia::subscribers()->totp($streamId, subscriberId: 'user_42', type: 'publish');

AntMedia::tokens()->validate($token);
AntMedia::tokens()->list($streamId);
AntMedia::tokens()->revokeAll($streamId);
```

<a id="recording-mp4--webm"></a>

### 录制（MP4 / WebM）

```php
AntMedia::recordings()->start($streamId, type: 'mp4', fileName: 'consultation_1024');
AntMedia::recordings()->stop($streamId, type: 'mp4');

// 将 HLS 录像转换为 MP4
AntMedia::recordings()->hlsToMp4('stream_8f3a', deleteHlsFiles: true);
```

<a id="video-on-demand-vod"></a>

### 视频点播（VoD）

```php
AntMedia::vods()->list(offset: 0, size: 50, streamId: $streamId, sortBy: 'date', order: 'desc');
AntMedia::vods()->get($vodId);
AntMedia::vods()->upload(storage_path('app/intro.mp4'), name: 'Course Intro');
AntMedia::vods()->importDirectory('/usr/local/antmedia/webapps/live/streams/archive');
AntMedia::vods()->delete($vodId);
AntMedia::vods()->deleteMany([$vodId1, $vodId2]);
AntMedia::vods()->count();
```

<a id="restream-to-youtube-facebook-rtmp-and-srt"></a>

### 转推到 YouTube、Facebook、RTMP 和 SRT

```php
AntMedia::endpoints()->add($streamId, 'rtmp://a.rtmp.youtube.com/live2/YOUR-KEY');
AntMedia::endpoints()->add($streamId, 'srt://ingest.example.com:9000', resolutionHeight: 720);
AntMedia::endpoints()->remove($streamId, 'rtmp://a.rtmp.youtube.com/live2/YOUR-KEY');
```

<a id="participants-and-subscribers"></a>

### 参会者与订阅者

```php
AntMedia::subscribers()->add($streamId, [
    'subscriberId' => 'user_42',
    'type' => 'publish',   // publish 同时具备播放权限（视频会议需要）
]);

AntMedia::subscribers()->list($streamId, offset: 0, size: 50);
AntMedia::subscribers()->block($streamId, 'user_42', seconds: 600, type: 'publish_play');
AntMedia::subscribers()->delete($streamId, 'user_42');
AntMedia::subscribers()->revokeAll($streamId);
AntMedia::subscribers()->connectionEvents($streamId, offset: 0, size: 50);
```

<a id="data-channel-messages-in-meeting-chat"></a>

### 数据通道消息（会中聊天）

```php
AntMedia::broadcasts()->sendMessage($streamId, [
    'type' => 'chat',
    'from' => 'Dr. Ahmed',
    'text' => 'Please turn on your camera.',
]);
```

<a id="statistics-and-analytics"></a>

### 统计与分析

```php
AntMedia::stats()->broadcast($streamId);        // WebRTC、HLS 和 RTMP 观众数
AntMedia::stats()->total();                     // 整个应用的观众总数
AntMedia::stats()->webrtcClients($streamId);    // 每个客户端的音频 / 视频码率
AntMedia::stats()->lowLevelSend();
AntMedia::stats()->lowLevelReceive();
```

<a id="ip-cameras-rtsp-and-onvif"></a>

### IP 摄像头、RTSP 和 ONVIF

```php
$camera = AntMedia::broadcasts()->create([
    'name' => 'Lobby Camera',
    'type' => 'ipCamera',
    'ipAddr' => '192.168.1.50',
    'username' => 'admin',
    'password' => 'secret',
], autoStart: true);

AntMedia::cameras()->discover();                       // ONVIF 设备发现
AntMedia::cameras()->profiles($camera->streamId);
AntMedia::cameras()->move($camera->streamId, x: 0.2, y: 0, zoom: 0, movement: 'relative');
AntMedia::cameras()->stopMove($camera->streamId);
AntMedia::broadcasts()->start($camera->streamId);      // 开始拉取流源
```

<a id="webhooks-and-laravel-events"></a>

### Webhook 与 Laravel 事件

将 Ant Media 的 **Application Settings > Webhook URL** 指向：

```
https://your-app.com/ant-media/webhook
```

监听原生 Laravel 事件：

```php
use AshrafBendary\WebRtcAntMedia\Events\LiveStreamStarted;
use AshrafBendary\WebRtcAntMedia\Events\LiveStreamEnded;
use AshrafBendary\WebRtcAntMedia\Events\RecordingReady;

Event::listen(LiveStreamStarted::class, fn ($e) => logger("Meeting started: {$e->streamId}"));
Event::listen(LiveStreamEnded::class,   fn ($e) => logger("Meeting ended: {$e->streamId}"));
Event::listen(RecordingReady::class,    fn ($e) => logger("Recording ready: {$e->vodId}"));
```

<a id="rest-api-coverage"></a>

## REST API 覆盖范围

所有调用均指向 `{ANT_MEDIA_URL}/{ANT_MEDIA_APP}/rest/v2/...`。完整的接口定义参见：[Ant Media Swagger](https://antmedia.io/rest/)。

| 扩展包方法 | HTTP | Ant Media 端点 |
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

<a id="security-privacy-and-compliance"></a>

## 安全、隐私与合规

由于 Ant Media Server 采用私有化部署（自托管），视频和录像存储在哪里由你自己决定。这使你更容易满足 **数据驻留（数据本地化）** 和隐私方面的要求，例如 **GDPR**、**PIPL**（《个人信息保护法》）、**HIPAA**、**沙特 PDPL**、阿联酋以及其他国家的数据保护法律。合规性取决于你的整体部署，而不仅仅取决于本扩展包。

推荐配置：

- 在所需区域运行 Ant Media Server（例如 AWS 中东区域、Google Cloud 达曼、Oracle Cloud 吉达、欧盟区域或本地机房）
- 在端口 `5443` 上使用 HTTPS 并配置有效的 SSL 证书
- 启用 **JWT REST API Filter**；切勿仅凭 IP 限制就将 REST API 公开暴露
- 为每场会议启用流的 **推流 / 播放令牌安全机制**
- 为令牌设置较短的 `exp`，并在会议结束时撤销令牌和订阅者
- 将录像存储在加密存储中，并记录访问者日志

<a id="using-this-package-with-ai-coding-assistants"></a>

## 配合 AI 编程助手使用

正在使用 Claude、ChatGPT、Cursor、GitHub Copilot 或其他 AI 助手构建应用？告诉它：

> “使用 Laravel 扩展包 `ashrafbendary/laravel-webrtc-ant-media`，基于 Ant Media Server 构建一个自托管的视频会议应用。请先阅读它的 README 和 llms.txt。”

本仓库包含 `llms.txt` 和 `AGENTS.md`，其中提供了面向 AI 智能体的使用规则。

<a id="faq"></a>

## 常见问题

**如何用 Laravel 开发一个 Zoom 克隆？**
安装本扩展包，运行 Ant Media Server，使用 `AntMedia::rooms()->create()` 创建房间，为每位参会者签发 JWT 令牌，然后通过 Ant Media WebRTC JavaScript SDK 连接浏览器。参见 [快速开始](#quick-start-create-a-video-meeting-room)。

**这是免费的 Zoom 替代方案吗？**
本扩展包免费且开源（MIT）。Ant Media Server 提供免费的社区版和付费的企业版。多人视频会议和大规模超低延迟 WebRTC 属于企业版功能，请根据你的实际情况查阅 Ant Media 的授权许可。

**它和 P2P WebRTC 扩展包有什么区别？**
P2P 在浏览器之间直接传输视频，适用于 2 到 3 人。本扩展包使用媒体服务器（SFU），因此支持大型会议、面向大规模观众的直播以及服务端录制。

**可以用于远程医疗吗？**
可以。常见的远程医疗功能（安全房间、短时效令牌、录制、自托管数据）均已覆盖。但你的部署仍须符合当地的医疗卫生法规。

**是否支持直播推流到 YouTube 或 Facebook？**
支持，使用 `AntMedia::endpoints()->add()` 并传入 RTMP 或 SRT 推流地址即可。

**支持哪些前端？**
Web 端支持 Blade、Livewire、Inertia、Vue、React 和原生 JavaScript；此外还可通过官方 Ant Media SDK 支持 React Native、Flutter、Android 和 iOS。

**能否与 Laravel Octane、Horizon 和队列配合使用？**
可以。所有调用均使用 Laravel HTTP 客户端，可以安全地在队列任务中运行。

**是否支持 Ant Media Server 集群模式？**
支持。将 `ANT_MEDIA_URL` 指向你的集群负载均衡器或源站即可。

<a id="testing"></a>

## 测试

```bash
composer test
```

本扩展包使用 `Http::fake()`，因此测试永远不会调用真实的媒体服务器。

<a id="contributing"></a>

## 参与贡献

欢迎提交 Pull Request。重大改动请先提交 Issue 讨论，并为新增端点补充测试。

<a id="credits"></a>

## 致谢

- [Ashraf Bendary](https://github.com/ashrafbendary)
- 基于 [Ant Media Server REST API](https://antmedia.io/rest/) 构建

<a id="license"></a>

## 许可证

MIT 许可证（MIT）。参见 [LICENSE](LICENSE)。

---

**关键词：** Laravel WebRTC, Laravel 视频会议, Laravel 视频通话, Laravel 在线会议, Laravel 扩展包, Zoom 替代方案, 腾讯会议 替代, Google Meet 替代, Teams 替代, 视频会议系统, 在线会议, 视频通话, 音视频通话, 直播, 低延迟直播, 会议录制, 私有化部署, 自托管视频会议, 远程医疗, 互联网医院, 在线教育, 网课, 虚拟教室, 网络研讨会, WebRTC SFU, Ant Media Server, PHP WebRTC, laravel webrtc, laravel video conference, laravel video call, laravel video meeting, laravel zoom clone, zoom alternative, google meet alternative, microsoft teams alternative, self-hosted video conferencing, laravel live streaming, webrtc php, ant media server, ant media laravel, antmedia php sdk, webrtc sfu, low latency streaming, hls, rtmp, srt, video recording, telemedicine laravel, telehealth video, elearning video, virtual classroom, webinar platform, laravel package
