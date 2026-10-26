# Laravel WebRTC Ant Media

[English](README.md) | [العربية](README.ar.md) | [اردو](README.ur.md) | [हिन्दी](README.hi.md) | [Türkçe](README.tr.md) | **日本語** | [简体中文](README.zh-CN.md)

### Laravel で Zoom、Google Meet、Microsoft Teams のようなビデオ会議（Web会議）アプリを構築できます。Ant Media Server を基盤とした、セルフホスト型でスケーラブルな WebRTC ビデオ会議、ライブ配信、会議録画を実現します。

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](https://packagist.org/packages/ashrafbendary/laravel-webrtc-ant-media)
[![Total Downloads](https://img.shields.io/packagist/dt/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](https://packagist.org/packages/ashrafbendary/laravel-webrtc-ant-media)
[![PHP Version](https://img.shields.io/packagist/php-v/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](https://packagist.org/packages/ashrafbendary/laravel-webrtc-ant-media)
[![License](https://img.shields.io/packagist/l/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](LICENSE)

**Laravel WebRTC Ant Media** は、[Ant Media Server REST API](https://docs.antmedia.io/guides/developer-sdk-and-api/rest-api-guide/) 向けの Laravel パッケージ（PHP SDK）です。Zoom、Twilio、Agora、Vonage に分単位の料金を支払うことなく、シンプルな Laravel facade を通じて、あらゆる Laravel アプリケーションで **ビデオ会議、ビデオ通話、ウェビナー、ライブ配信、オンライン診療（遠隔医療）、オンライン授業** を作成できます。

> 非公式のコミュニティパッケージです。Ant Media Inc. とは提携関係にありません。「Zoom」「Google Meet」「Microsoft Teams」は各所有者の商標であり、比較のためにのみ言及しています。

---

## 目次

- [このパッケージを選ぶ理由](#why-this-package)
- [ユースケース](#use-cases)
- [機能](#features)
- [他の選択肢との比較](#how-it-compares)
- [動作要件](#requirements)
- [インストール](#installation)
- [設定](#configuration)
  - [オリジン、エッジ、メインアプリ、テストアプリ](#origin-edge-main-app-and-test-app)
  - [StreamApp と会議アプリケーション](#streamapp-and-the-conference-application)
- [クイックスタート：ビデオ会議ルームを作成する](#quick-start-create-a-video-meeting-room)
- [使い方](#usage)
  - [フロントエンド URL（WebSocket、HLS、プレーヤー）](#frontend-urls-websocket-hls-player)
  - [ライブ配信（ブロードキャスト）](#live-streams-broadcasts)
  - [ビデオ会議ルーム（多人数オンライン会議）](#video-conference-rooms-multi-party-meetings)
  - [セキュアなアクセストークン（JWT、ワンタイムトークン、TOTP）](#secure-access-tokens-jwt-one-time-token-totp)
  - [録画（MP4 / WebM）](#recording-mp4--webm)
  - [ビデオオンデマンド（VoD）](#video-on-demand-vod)
  - [YouTube、Facebook、RTMP、SRT への同時配信（リストリーム）](#restream-to-youtube-facebook-rtmp-and-srt)
  - [参加者とサブスクライバー](#participants-and-subscribers)
  - [データチャネルメッセージ（会議内チャット）](#data-channel-messages-in-meeting-chat)
  - [統計と分析](#statistics-and-analytics)
  - [IP カメラ、RTSP、ONVIF](#ip-cameras-rtsp-and-onvif)
  - [Webhook と Laravel イベント](#webhooks-and-laravel-events)
- [REST API 対応状況](#rest-api-coverage)
- [セキュリティ、プライバシー、コンプライアンス](#security-privacy-and-compliance)
- [AI コーディングアシスタントでこのパッケージを使う](#using-this-package-with-ai-coding-assistants)
- [よくある質問（FAQ）](#faq)
- [テスト](#testing)
- [コントリビュート](#contributing)
- [クレジット](#credits)
- [ライセンス](#license)

---

<a id="why-this-package"></a>

## このパッケージを選ぶ理由

Laravel 向けのビデオ通話パッケージの多くは **ピアツーピア（P2P）WebRTC** です。P2P は 2人から3人までなら動作しますが、それを超えると破綻します。参加者全員が、他のすべての参加者に向けて映像をアップロードする必要があるためです。

このパッケージは **Ant Media Server を WebRTC SFU / メディアサーバー** として使用するため、次のことが可能になります。

- 1つのルームに多数の参加者が入れる **スケーラブルなビデオ会議**
- 大規模な視聴者に向けた **超低遅延のライブ配信**（WebRTC で約 0.5 秒）
- MP4 または WebM への **サーバーサイド録画**
- **HLS、RTMP、SRT、WebRTC** を1つのプラットフォームで
- 自社サーバーやクラウド（AWS、Google Cloud、Azure、Oracle Cloud、オンプレミス）での **セルフホスト** により、映像データが自社インフラの外に出ることはありません

<a id="use-cases"></a>

## ユースケース

| ユースケース | 構築できるもの |
|---|---|
| **オンライン診療 / 遠隔医療** | 医師と患者のビデオ診察、バーチャルクリニック、リモートでのセカンドオピニオン |
| **eラーニング / オンライン授業** | バーチャル教室、ライブ講義、LMS のビデオルーム、録画講座 |
| **ウェビナーとバーチャルイベント** | 双方向の登壇者を交えた 1対多のライブ配信 |
| **チームミーティング** | 自社向けのセルフホスト型 Zoom 代替 / Google Meet 代替 / Teams 代替 |
| **カスタマーサポート** | ビデオ通話によるサポート、ビデオ KYC、リモート検査 |
| **ライブコマース** | リアルタイムチャット付きのライブショッピング配信 |
| **監視** | Laravel 内での IP カメラ（RTSP / ONVIF）のライブ表示と録画 |
| **ソーシャル / クリエイター向けアプリ** | ライブ配信、配信開始機能、YouTube や Facebook への同時配信 |

<a id="features"></a>

## 機能

- Laravel facade、サービスコンテナへのバインディング、自動検出（auto-discovery）
- **オリジンサーバーとエッジサーバー**、さらに **メインアプリとテストアプリ** を、すべて `.env` から設定可能
- すぐに使えるフロントエンド URL（配信 / 再生用 WebSocket、HLS、埋め込みプレーヤー、RTMP）
- **ライブ配信（ブロードキャスト）** の作成、更新、一覧取得、開始、停止、削除
- Ant Media のメイントラックとサブトラックを使った **ビデオ会議ルーム**
- 配信（publish）と再生（play）のための **JWT**、**ワンタイムトークン**、**TOTP** によるストリームセキュリティ
- **JWT による REST API 認証**（HS256）を自動で処理
- ストリームごとの **録画** の開始と停止（MP4 または WebM）、HLS から MP4 への変換
- **VoD** 管理：録画のアップロード、インポート、一覧取得、削除
- RTMP および SRT エンドポイント（YouTube Live、Facebook Live、Twitch、LinkedIn Live）への **リストリーム / マルチストリーム**
- **サブスクライバー管理**：参加者の追加、一覧取得、ブロック、権限の取り消し
- 会議内チャット、リアクション、シグナル用の **WebRTC データチャネル** メッセージ
- **ライブ統計**：視聴者数（WebRTC、HLS、RTMP）、ビットレート、クライアント統計、接続イベント
- **IP カメラ** 対応：RTSP プル、ONVIF ディスカバリー、PTZ 操作
- ストリームソース向けの **プレイリスト** とシーク制御
- ネイティブの Laravel イベントを発火する **Webhook レシーバー**
- 型付き DTO、Laravel HTTP クライアント、リトライとタイムアウトの設定
- **Laravel 11、12、13**、PHP 8.2 以上に対応
- Ant Media の JavaScript、React、React Native、Flutter、Android、iOS 向け WebRTC SDK と組み合わせて利用可能

<a id="how-it-compares"></a>

## 他の選択肢との比較

| | このパッケージ | Zoom / Google Meet / Teams | Twilio / Agora / Vonage | P2P 型の Laravel WebRTC パッケージ |
|---|---|---|---|---|
| セルフホスト | はい | いいえ | いいえ | はい |
| データが自社サーバー内に留まる | はい | いいえ | いいえ | はい |
| 分単位の料金 | なし | サブスクリプション | あり | なし |
| 大規模な会議（SFU） | はい | はい | はい | いいえ（2人から3人） |
| 数千人規模へのライブ配信 | はい | 制限あり | 追加費用 | いいえ |
| サーバーサイド録画 | はい | はい | 追加費用 | いいえ |
| 自社の Laravel アプリへの組み込み | はい | 制限あり | はい | はい |
| ホワイトラベル / 独自ブランディング | はい | いいえ | はい | はい |

<a id="requirements"></a>

## 動作要件

- PHP **8.2** 以上
- Laravel **11.x、12.x、または 13.x**
- 稼働中の **Ant Media Server**（Community Edition または Enterprise Edition）。[Ant Media クイックスタート](https://docs.antmedia.io/quick-start/) を参照してください。

<a id="installation"></a>

## インストール

```bash
composer require ashrafbendary/laravel-webrtc-ant-media
```

インストーラーを実行します（設定ファイルを公開し、`.env` のキーを表示します。Webhook ルートは自動で登録されます）。

```bash
php artisan webrtc-ant-media:install
```

または、設定ファイルを手動で公開します。

```bash
php artisan vendor:publish --tag="webrtc-ant-media-config"
```

<a id="configuration"></a>

## 設定

`.env` に以下を追加します。

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

| キー | 説明 |
|---|---|
| `ANT_MEDIA_ORIGIN_URL` | オリジンサーバーの URL。すべての REST 呼び出しと WebRTC の配信（publish）はここに送られます。HTTPS にはポート `5443`、HTTP（ローカル環境のみ）には `5080` を使用します。`ANT_MEDIA_URL` もエイリアスとして引き続き使用できます |
| `ANT_MEDIA_EDGE_URL` | 任意。エッジサーバーまたはエッジのロードバランサー。再生用 URL に使われます。空の場合はオリジンを使用します |
| `ANT_MEDIA_APP` | メインのアプリケーション名。例：`LiveApp`、`WebRTCAppEE`、`live`、または StreamApp をベースに構築した独自のアプリ |
| `ANT_MEDIA_TEST_APP` | 任意。テスト用ストリームのための 2 つ目のアプリケーション。`AntMedia::test()` で使用します |
| `ANT_MEDIA_USE_TEST_APP` | `true` にすると、すべての呼び出しがテストアプリに送られます（ローカル / ステージング環境で便利です） |
| `ANT_MEDIA_JWT_SECRET` | **Application Settings > JWT REST API Filter**（HS256）で設定したシークレット |
| `ANT_MEDIA_STREAM_JWT_SECRET` | 配信（publish）/ 再生（play）用ストリームトークンの署名に使うシークレット |
| `ANT_MEDIA_TIMEOUT` | HTTP タイムアウト（秒） |
| `ANT_MEDIA_RETRIES` | 失敗した GET リクエストのリトライ回数（POST / PUT / DELETE はリトライされません）。デフォルトは `1` |
| `ANT_MEDIA_WEBHOOK_SECRET` | **必須。** Webhook URL に含める共有シークレット。空の間は、すべての Webhook が拒否されます |
| `ANT_MEDIA_WEBHOOK_ALLOWED_IPS` | 任意（推奨）。Ant Media サーバーの IP または CIDR をカンマ区切りで指定します。それ以外の IP からの Webhook は拒否されます。ロードバランサーの背後で運用する場合は、先に Laravel の trusted proxies を設定してください |

テストアプリ用の任意の上書き設定（未設定の場合はそれぞれメインの値が使われます）：`ANT_MEDIA_TEST_ORIGIN_URL`、`ANT_MEDIA_TEST_EDGE_URL`、`ANT_MEDIA_TEST_JWT_SECRET`、`ANT_MEDIA_TEST_STREAM_JWT_SECRET`。

**認証について。** Ant Media のアプリケーション REST エンドポイントは、デフォルトでは `127.0.0.1` からのリクエストのみを受け付けます（IP フィルター）。リモートの Laravel バックエンドから利用する場合は、Ant Media の Web パネルで **JWT REST API Filter** を有効にし、上記のシークレットを設定してください。パッケージは `exp` クレームを含む有効期限の短い HS256 トークンに署名し、すべてのリクエストで `Authorization: Bearer {token}` として送信します。

<a id="origin-edge-main-app-and-test-app"></a>

### オリジン、エッジ、メインアプリ、テストアプリ

```php
use AshrafBendary\WebRtcAntMedia\Facades\AntMedia;

AntMedia::broadcasts()->create(['name' => 'Live']);          // メインアプリ（ANT_MEDIA_APP）
AntMedia::test()->broadcasts()->create(['name' => 'Try']);   // テストアプリ（ANT_MEDIA_TEST_APP）
AntMedia::main()->broadcasts()->list();                      // ANT_MEDIA_USE_TEST_APP=true の場合でもメインアプリ
AntMedia::app('WebRTCAppEE')->broadcasts()->count();         // 同じサーバー上のその他の任意のアプリ

AntMedia::appName();   // "LiveApp"（ANT_MEDIA_USE_TEST_APP=true の場合はテストアプリ）
```

- REST API の呼び出しと WebRTC の **配信（publish）** には、常に **オリジン** サーバーが使われます。
- **再生** 用の URL（WebRTC 再生、HLS、埋め込みプレーヤー、録画）には **エッジ** サーバーが使われます。エッジが設定されていない場合はオリジンが使われます。

<a id="streamapp-and-the-conference-application"></a>

### StreamApp と会議アプリケーション

以前の [conference-call-application](https://github.com/ant-media/conference-call-application)（Circle）リポジトリは、2026年8月31日にアーカイブされました。[StreamApp](https://github.com/ant-media/StreamApp) は現在の Ant Media Server のベースアプリケーションです。デフォルトのアプリ（`LiveApp`、`WebRTCAppEE`、`live`）や独自のアプリはこれをベースに構築されており、会議のサンプル（`conference.html`、`multitrack-conference.html`）も同梱されています。

StreamApp は Circle UI の機能をすべて置き換えるものでは **ありません**。会議ページでは参加 / 退出、配信 / 再生、画面共有、ミュートとカメラの切り替え、データチャネルによるチャットに対応していますが、録画ボタン、待機室、会議ページでのバーチャル背景、リアクション、参加者一覧、ピン留め、ブレイクアウトルーム、ウェビナー / モデレーション UI は用意されていません。このパッケージはどちらの UI にも依存しません。すべてのアプリケーションで共通の Ant Media REST API と通信するため、`ANT_MEDIA_APP` に StreamApp ベースのアプリを設定し、必要な会議 UI を構築してください。

<a id="quick-start-create-a-video-meeting-room"></a>

## クイックスタート：ビデオ会議ルームを作成する

```php
use AshrafBendary\WebRtcAntMedia\Facades\AntMedia;

// 1. 会議ルームを作成する
$room = AntMedia::rooms()->create(name: 'Weekly Team Meeting');

// 2. 各参加者にセキュアな配信 + 再生トークンを発行する（有効期限 2 時間）
$token = AntMedia::tokens()->jwt(
    streamId: $room->streamId,
    type: 'publish',
    expiresAt: now()->addHours(2),
    roomId: $room->streamId,
);

// 3. Blade / Vue / React のビューで、$room->streamId と $token を Ant Media WebRTC JavaScript SDK に渡す
return view('meeting', compact('room', 'token'));
```

または、フロントエンドに必要なものをすべて JSON で返します（シークレットは含まれません）。

```php
return response()->json(AntMedia::urls()->forClient($room->streamId, $token));
// { streamId, token, app, publishWebSocketUrl, playWebSocketUrl, hlsUrl }
```

Zoom のような会議ルームのバックエンドは、これだけで完成です。ブラウザ側では公式の [Ant Media WebRTC JavaScript SDK](https://docs.antmedia.io/guides/developer-sdk-and-api/sdk-integration/) を使用します。

<a id="usage"></a>

## 使い方

<a id="frontend-urls-websocket-hls-player"></a>

### フロントエンド URL（WebSocket、HLS、プレーヤー）

```php
AntMedia::urls()->publishWebSocket();              // wss://origin.example.com:5443/LiveApp/websocket
AntMedia::urls()->playWebSocket();                 // wss://edge.example.com:5443/LiveApp/websocket
AntMedia::urls()->hls($streamId, $token);          // https://edge.../LiveApp/streams/{id}.m3u8?token=...
AntMedia::urls()->player($streamId, $token);       // https://edge.../LiveApp/play.html?id=...&token=...
AntMedia::urls()->recording('stream1.mp4');        // https://edge.../LiveApp/streams/stream1.mp4
AntMedia::urls()->rtmp($streamId);                 // rtmp://origin.example.com/LiveApp/{id}（OBS 用）
AntMedia::urls()->forClient($streamId, $token);    // JS 向けの配列：streamId、token、WebSocket と HLS の URL
AntMedia::test()->urls()->playWebSocket();         // テストアプリ向けの同じヘルパー
```

<a id="live-streams-broadcasts"></a>

### ライブ配信（ブロードキャスト）

```php
use AshrafBendary\WebRtcAntMedia\Facades\AntMedia;

$stream = AntMedia::broadcasts()->create([
    'name' => 'Product Launch Live',
    'description' => 'Live product launch event',
]);

$stream->streamId;   // 例："stream_8f3a..."
$stream->rtmpURL;    // OBS 用の RTMP インジェスト URL

AntMedia::broadcasts()->get($stream->streamId);
AntMedia::broadcasts()->list(offset: 0, size: 50, type: 'liveStream', sortBy: 'date', order: 'desc');
AntMedia::broadcasts()->update($stream->streamId, ['name' => 'New title']);
AntMedia::broadcasts()->stop($stream->streamId);
AntMedia::broadcasts()->delete($stream->streamId);
$stream->isLive();                                  // status === "broadcasting"
$stream->get('hlsViewerCount');                     // その他の任意の Ant Media フィールド
AntMedia::broadcasts()->deleteMany(['id1', 'id2']);
AntMedia::broadcasts()->count();
AntMedia::broadcasts()->activeCount();
AntMedia::broadcasts()->info($stream->streamId);   // 幅、高さ、ビットレート、コーデック
```

<a id="video-conference-rooms-multi-party-meetings"></a>

### ビデオ会議ルーム（多人数オンライン会議）

会議ルームはメイントラックです。各参加者はサブトラックを配信します。

```php
$room = AntMedia::rooms()->create(name: 'Consultation 7f3c2a');
$room = AntMedia::rooms()->create(name: 'Class 7A', streamId: 'class-7a');   // ルーム ID を自分で指定する
AntMedia::rooms()->get('class-7a');

AntMedia::rooms()->addParticipant($room->streamId, participantStreamId: 'p_9b41e2');
AntMedia::rooms()->participants($room->streamId, offset: 0, size: 50);
AntMedia::rooms()->activeParticipants($room->streamId);
AntMedia::rooms()->activeParticipantsCount($room->streamId);
AntMedia::rooms()->removeParticipant($room->streamId, participantStreamId: 'p_9b41e2');

// 全員の会議を終了する
AntMedia::rooms()->end($room->streamId);   // メイントラックとサブトラックを停止する
AntMedia::rooms()->delete($room->streamId); // ルームとそのサブトラックを削除する
```

<a id="secure-access-tokens-jwt-one-time-token-totp"></a>

### セキュアなアクセストークン（JWT、ワンタイムトークン、TOTP）

誰が **配信**（カメラ / マイク）でき、誰が **再生**（視聴）できるかを制御します。

```php
// JWT トークン（推奨）。ANT_MEDIA_STREAM_JWT_SECRET を使ってローカルで署名するため、サーバーとの往復通信は不要
$jwt = AntMedia::tokens()->jwt($streamId, type: 'play', expiresAt: now()->addHour());

// 代わりに Ant Media に署名させる（ANT_MEDIA_STREAM_JWT_SECRET が空の場合も自動でこの方式になる）
$jwt = AntMedia::tokens()->jwt($streamId, type: 'play', expiresAt: now()->addHour(), fromServer: true);

// Ant Media Server が生成するワンタイムトークン
$oneTime = AntMedia::tokens()->oneTime($streamId, type: 'publish', expiresAt: now()->addMinutes(30));

// サブスクライバー用の TOTP
$totp = AntMedia::subscribers()->totp($streamId, subscriberId: 'user_42', type: 'publish');

AntMedia::tokens()->validate($token, $streamId, type: 'play');   // bool
AntMedia::tokens()->list($streamId);
AntMedia::tokens()->revokeAll($streamId);
```

<a id="recording-mp4--webm"></a>

### 録画（MP4 / WebM）

```php
AntMedia::recordings()->start($streamId, type: 'mp4', fileName: 'rec_7f3c2a');
AntMedia::recordings()->stop($streamId, type: 'mp4');

// HLS の録画を MP4 に変換する
AntMedia::recordings()->hlsToMp4('stream_8f3a', deleteHlsFiles: true);
```

<a id="video-on-demand-vod"></a>

### ビデオオンデマンド（VoD）

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

### YouTube、Facebook、RTMP、SRT への同時配信（リストリーム）

```php
$result = AntMedia::endpoints()->add($streamId, 'rtmp://a.rtmp.youtube.com/live2/YOUR-KEY');
$result->dataId;   // エンドポイントサービス ID
AntMedia::endpoints()->add($streamId, 'srt://ingest.example.com:9000', resolutionHeight: 720);

// 追加した URL またはエンドポイントサービス ID で削除する
AntMedia::endpoints()->remove($streamId, 'rtmp://a.rtmp.youtube.com/live2/YOUR-KEY');
```

<a id="participants-and-subscribers"></a>

### 参加者とサブスクライバー

```php
AntMedia::subscribers()->add($streamId, [
    'subscriberId' => 'user_42',
    'type' => 'publish',   // publish は再生も可能（ビデオ会議に必要）
]);

AntMedia::subscribers()->list($streamId, offset: 0, size: 50);
AntMedia::subscribers()->block($streamId, 'user_42', seconds: 600, type: 'publish_play');
AntMedia::subscribers()->delete($streamId, 'user_42');
AntMedia::subscribers()->revokeAll($streamId);
AntMedia::subscribers()->connectionEvents($streamId, offset: 0, size: 50);
```

<a id="data-channel-messages-in-meeting-chat"></a>

### データチャネルメッセージ（会議内チャット）

```php
AntMedia::broadcasts()->sendMessage($streamId, [
    'type' => 'chat',
    'from' => 'Dr. Ahmed',
    'text' => 'Please turn on your camera.',
]);
```

<a id="statistics-and-analytics"></a>

### 統計と分析

```php
AntMedia::stats()->broadcast($streamId);        // WebRTC、HLS、RTMP の視聴者数
AntMedia::stats()->total();                     // アプリ全体の総視聴者数
AntMedia::stats()->webrtcClients($streamId);    // クライアントごとの音声 / 映像ビットレート
AntMedia::stats()->lowLevelSend();
AntMedia::stats()->lowLevelReceive();
```

<a id="ip-cameras-rtsp-and-onvif"></a>

### IP カメラ、RTSP、ONVIF

```php
$camera = AntMedia::broadcasts()->create([
    'name' => 'Lobby Camera',
    'type' => 'ipCamera',
    'ipAddr' => '192.168.1.50',
    'username' => 'admin',
    'password' => config('services.lobby_camera.password'),
], autoStart: true);

AntMedia::cameras()->discover();                       // ONVIF ディスカバリー
AntMedia::cameras()->profiles($camera->streamId);
AntMedia::cameras()->move($camera->streamId, x: 0.2, y: 0, zoom: 0, movement: 'relative');
AntMedia::cameras()->stopMove($camera->streamId);
AntMedia::broadcasts()->start($camera->streamId);      // ストリームソースのプルを開始する
```

<a id="webhooks-and-laravel-events"></a>

### Webhook と Laravel イベント

Ant Media の **Application Settings > Webhook URL** に、次の URL を設定します（ルートは自動で登録されます）。

```
https://your-app.com/ant-media/webhook?secret=ANT_MEDIA_WEBHOOK_SECRET
```

`secret` が誤っている、または指定されていないリクエストや、`ANT_MEDIA_WEBHOOK_ALLOWED_IPS`（設定されている場合）に含まれない IP からのリクエストは、HTTP 403 で拒否されます。Ant Media は Webhook に署名しないため、両方を設定してください。Ant Media は Webhook をフォームデータまたは JSON で送信できますが、どちらにも対応しています。

ネイティブの Laravel イベントをリッスンします。

```php
use AshrafBendary\WebRtcAntMedia\Events\LiveStreamStarted;
use AshrafBendary\WebRtcAntMedia\Events\LiveStreamEnded;
use AshrafBendary\WebRtcAntMedia\Events\RecordingReady;

Event::listen(LiveStreamStarted::class, fn ($e) => logger("Meeting started: {$e->streamId}"));
Event::listen(LiveStreamEnded::class,   fn ($e) => logger("Meeting ended: {$e->streamId}"));
Event::listen(RecordingReady::class,    fn ($e) => logger("Recording ready: {$e->vodId}"));

// すべての Webhook アクション（playStarted、subtrackAddedInTheMainTrack、endpointFailed など）
use AshrafBendary\WebRtcAntMedia\Events\WebhookReceived;

Event::listen(WebhookReceived::class, fn ($e) => logger("{$e->action}: {$e->streamId}"));
```

<a id="endpoints-that-are-not-wrapped"></a>

### ラップされていないエンドポイント

その他の Ant Media エンドポイントは、内部のクライアントを通じて呼び出せます（認証、ベース URL、アプリは自動で処理されます）。

```php
AntMedia::client()->get("broadcasts/{$streamId}/ip-camera-error");
AntMedia::client()->get('broadcasts/duration', ['url' => $sourceUrl]);
```

失敗したリクエスト（HTTP 4xx / 5xx）はすべて `AshrafBendary\WebRtcAntMedia\Exceptions\AntMediaException` をスローします。存在しないストリームに対する `get()` は `null` を返します。

<a id="rest-api-coverage"></a>

## REST API 対応状況

すべての呼び出しは `{ANT_MEDIA_ORIGIN_URL}/{ANT_MEDIA_APP}/rest/v2/...`（またはテストアプリ）に対して行われます。完全なスキーマは [Ant Media Swagger](https://antmedia.io/rest/) を参照してください。

| パッケージのメソッド | HTTP | Ant Media エンドポイント |
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

<a id="security-privacy-and-compliance"></a>

## セキュリティ、プライバシー、コンプライアンス

Ant Media Server はセルフホスト型のため、映像や録画データの保存場所を自分で選べます。これにより、**GDPR**、日本の **APPI（個人情報保護法）**、**HIPAA**、**サウジアラビアの PDPL**、UAE やその他の国のデータ保護法といった、**データレジデンシー** やプライバシーに関する要件を満たしやすくなります。コンプライアンスはデプロイ全体の構成に依存するものであり、このパッケージ単体で決まるものではありません。

推奨構成：

- データ保護法で求められるリージョンで Ant Media Server を運用する。サウジアラビアの個人データおよび医療データには KSA リージョンを使用する（例：Google Cloud ダンマーム、Oracle Cloud ジッダ、またはオンプレミス。AWS のサウジアラビアリージョンは 2026 年 12 月に開設予定）。AWS のバーレーンおよび UAE リージョンは KSA 外にあるため、これらを使用すると PDPL 上の越境移転にあたる。EU のデータには EU リージョンを使用する
- 有効な SSL 証明書を用いて、ポート `5443` で HTTPS を使用する
- **JWT REST API Filter** を有効にする。IP 制限だけで REST API を公開しないこと
- すべての会議でストリームの **配信 / 再生トークンセキュリティ** を有効にする
- トークンの `exp` は短く設定し、会議終了時にはトークンとサブスクライバーを失効させる
- 録画は暗号化されたストレージに保存し、誰がアクセスしたかをログに記録する
- 録画を開始する前に参加者の同意（目的、バージョン、タイムスタンプ）を記録し、ファイル名にはランダムな名前を使い、保存期間のスケジュールに従って録画を削除する
- 録画の一覧表示やダウンロードは、ログを記録する個別の権限とし、再生トークンセキュリティが録画の URL（`/{app}/streams/...`）にも適用されるようにする
- 患者や学生の氏名や ID をストリーム名、ストリーム ID、ファイル名に含めない。ランダムな ID を使い、自分のデータベースで対応付ける
- リクエストの入力を `broadcasts()->create()`、`broadcasts()->update()`、`endpoints()->add()` に直接渡さないこと。ストリームのソース URL や再配信（restream）URL は、内部サーバーへのアクセスや会議の外部への複製に悪用される恐れがある
- Ant Media JavaScript SDK はセルフホストし、同じリージョンで独自の STUN/TURN サーバーを運用する。カメラ、マイク、Ant Media のオリジンの許可（Permissions-Policy と CSP）は会議ページでのみ行う

<a id="using-this-package-with-ai-coding-assistants"></a>

## AI コーディングアシスタントでこのパッケージを使う

Claude、ChatGPT、Cursor、GitHub Copilot などの AI アシスタントを使ってアプリを開発していますか？ 次のように指示してください。

> 「Laravel パッケージ `ashrafbendary/laravel-webrtc-ant-media` を使って、Ant Media Server によるセルフホスト型のビデオ会議アプリを構築してください。まず README と llms.txt を読んでください。」

このリポジトリには、AI エージェント向けの利用ルールを記載した `llms.txt` と `AGENTS.md` が含まれています。

<a id="faq"></a>

## よくある質問（FAQ）

**Laravel で Zoom クローンを作るにはどうすればよいですか？**
このパッケージをインストールし、Ant Media Server を起動して、`AntMedia::rooms()->create()` でルームを作成します。参加者ごとに JWT トークンを発行し、Ant Media WebRTC JavaScript SDK でブラウザを接続してください。[クイックスタート](#quick-start-create-a-video-meeting-room) を参照してください。

**無料の Zoom 代替になりますか？**
このパッケージは無料のオープンソース（MIT）です。Ant Media Server には無料の Community Edition と有料の Enterprise Edition があります。多人数のビデオ会議や大規模な超低遅延 WebRTC は Enterprise の機能であるため、ご自身のケースについては Ant Media のライセンスを確認してください。

**P2P WebRTC パッケージとの違いは何ですか？**
P2P はブラウザ間で直接映像を送信するため、2人から3人までの利用に向いています。このパッケージはメディアサーバー（SFU）を使用するため、大規模な会議、大人数へのライブ配信、サーバーサイド録画に対応しています。

**オンライン診療（遠隔医療）に使えますか？**
はい。遠隔医療で一般的に求められる機能（セキュアなルーム、有効期限の短いトークン、録画、セルフホストによるデータ管理）はカバーしています。ただし、デプロイ環境は引き続き、各地域の医療関連規制を満たす必要があります。

**YouTube や Facebook へのライブ配信に対応していますか？**
はい。RTMP または SRT のインジェスト URL を指定して `AntMedia::endpoints()->add()` を使用してください。

**どのフロントエンドに対応していますか？**
Web では Blade、Livewire、Inertia、Vue、React、素の JavaScript に対応しています。さらに、公式の Ant Media SDK を通じて React Native、Flutter、Android、iOS にも対応しています。

**Laravel Octane、Horizon、キューで動作しますか？**
はい。すべての呼び出しは Laravel HTTP クライアントを使用しており、ジョブ内で安全に実行できます。

**Ant Media Server のクラスターモードに対応していますか？**
はい。`ANT_MEDIA_ORIGIN_URL` にオリジン（またはオリジンのロードバランサー）を、`ANT_MEDIA_EDGE_URL` にエッジのロードバランサーを設定してください。

**StreamApp は conference-call-application の後継ですか？**
StreamApp は現在のベースアプリであり、conference-call-application リポジトリはアーカイブされています。ただし、StreamApp にはその UI 機能がすべて備わっているわけではありません。[StreamApp と会議アプリケーション](#streamapp-and-the-conference-application) を参照してください。

**本番のストリームに影響を与えずにテストするにはどうすればよいですか？**
`ANT_MEDIA_TEST_APP` を設定して `AntMedia::test()` を使用するか、ローカル / ステージング環境の `.env` で `ANT_MEDIA_USE_TEST_APP=true` を設定してください。

<a id="testing"></a>

## テスト

```bash
composer test
```

このパッケージは `Http::fake()` を使用しているため、テストで実際のメディアサーバーを呼び出すことはありません。

<a id="contributing"></a>

## コントリビュート

プルリクエストを歓迎します。大きな変更を行う場合は、まず Issue を作成してください。また、新しいエンドポイントにはテストを追加してください。

<a id="credits"></a>

## クレジット

- [Ashraf Bendary](https://github.com/ashrafbendary)
- [Ant Media Server REST API](https://antmedia.io/rest/) をベースに構築

<a id="license"></a>

## ライセンス

The MIT License (MIT)。詳細は [LICENSE](LICENSE) を参照してください。

---

**キーワード / Keywords:** Laravel WebRTC, Laravel ビデオ会議, Laravel ビデオ通話, Laravel Web会議, Laravel パッケージ, Zoom 代替, Zoom クローン, Google Meet 代替, Teams 代替, Microsoft Teams 代替, ビデオ会議, Web会議, オンライン会議, ビデオ通話, セルフホスト ビデオ会議, オンプレミス ビデオ会議, ライブ配信, 低遅延配信, 会議録画, オンライン診療, 遠隔医療, オンライン授業, eラーニング, バーチャル教室, ウェビナー, WebRTC PHP, Ant Media Server, WebRTC SFU, HLS, RTMP, SRT, laravel webrtc, laravel video conference, laravel video call, laravel video meeting, laravel zoom clone, zoom alternative, google meet alternative, microsoft teams alternative, self-hosted video conferencing, laravel live streaming, webrtc php, ant media server, ant media laravel, antmedia php sdk, webrtc sfu, low latency streaming, hls, rtmp, srt, video recording, telemedicine laravel, telehealth video, elearning video, virtual classroom, webinar platform, laravel package
