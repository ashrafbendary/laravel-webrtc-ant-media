# Laravel WebRTC Ant Media

[English](README.md) | [العربية](README.ar.md) | **اردو** | [हिन्दी](README.hi.md) | [Türkçe](README.tr.md) | [日本語](README.ja.md) | [简体中文](README.zh-CN.md)

### Laravel میں Zoom، Google Meet یا Microsoft Teams جیسی ویڈیو میٹنگ ایپ بنائیں۔ Ant Media Server پر مبنی سیلف ہوسٹڈ اور قابلِ توسیع (scalable) WebRTC ویڈیو کانفرنسنگ، لائیو اسٹریمنگ اور میٹنگ ریکارڈنگ۔

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](https://packagist.org/packages/ashrafbendary/laravel-webrtc-ant-media)
[![Total Downloads](https://img.shields.io/packagist/dt/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](https://packagist.org/packages/ashrafbendary/laravel-webrtc-ant-media)
[![PHP Version](https://img.shields.io/packagist/php-v/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](https://packagist.org/packages/ashrafbendary/laravel-webrtc-ant-media)
[![License](https://img.shields.io/packagist/l/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](LICENSE)

**Laravel WebRTC Ant Media** ایک لاراویل پیکج (PHP SDK) ہے جو [Ant Media Server REST API](https://docs.antmedia.io/guides/developer-sdk-and-api/rest-api-guide/) کے لیے بنایا گیا ہے۔ اس کی مدد سے کوئی بھی Laravel ایپلیکیشن ایک صاف ستھرے Laravel facade کے ذریعے **ویڈیو میٹنگز، ویڈیو کالز، ویبینارز، لائیو اسٹریمز، ٹیلی میڈیسن مشاورت اور آن لائن کلاسز** بنا سکتی ہے، اور اس کے لیے Zoom، Twilio، Agora یا Vonage کو فی منٹ فیس ادا نہیں کرنی پڑتی۔

> یہ ایک غیر سرکاری کمیونٹی پیکج ہے۔ اس کا Ant Media Inc. سے کوئی الحاق نہیں۔ "Zoom"، "Google Meet" اور "Microsoft Teams" اپنے اپنے مالکان کے ٹریڈ مارکس ہیں اور یہاں صرف موازنے کے لیے ذکر کیے گئے ہیں۔

---

## فہرستِ مضامین

- [یہ پیکج کیوں](#why-this-package)
- [استعمال کے شعبے](#use-cases)
- [خصوصیات](#features)
- [دوسرے حل سے موازنہ](#how-it-compares)
- [ضروریات](#requirements)
- [انسٹالیشن](#installation)
- [کنفیگریشن](#configuration)
- [فوری آغاز: ویڈیو میٹنگ روم بنائیں](#quick-start-create-a-video-meeting-room)
- [استعمال](#usage)
  - [لائیو اسٹریمز (براڈکاسٹس)](#live-streams-broadcasts)
  - [ویڈیو کانفرنس رومز (کثیر شرکاء والی میٹنگز)](#video-conference-rooms-multi-party-meetings)
  - [محفوظ رسائی ٹوکنز (JWT، ایک بار استعمال ہونے والا ٹوکن، TOTP)](#secure-access-tokens-jwt-one-time-token-totp)
  - [ریکارڈنگ (MP4 / WebM)](#recording-mp4--webm)
  - [ویڈیو آن ڈیمانڈ (VoD)](#video-on-demand-vod)
  - [YouTube، Facebook، RTMP اور SRT پر ری اسٹریم](#restream-to-youtube-facebook-rtmp-and-srt)
  - [شرکاء اور سبسکرائبرز](#participants-and-subscribers)
  - [ڈیٹا چینل پیغامات (میٹنگ کے اندر چیٹ)](#data-channel-messages-in-meeting-chat)
  - [اعداد و شمار اور تجزیات](#statistics-and-analytics)
  - [IP کیمرے، RTSP اور ONVIF](#ip-cameras-rtsp-and-onvif)
  - [Webhooks اور Laravel ایونٹس](#webhooks-and-laravel-events)
- [REST API کوریج](#rest-api-coverage)
- [سیکیورٹی، پرائیویسی اور تعمیل (کمپلائنس)](#security-privacy-and-compliance)
- [AI کوڈنگ اسسٹنٹس کے ساتھ اس پیکج کا استعمال](#using-this-package-with-ai-coding-assistants)
- [عمومی سوالات (FAQ)](#faq)
- [ٹیسٹنگ](#testing)
- [تعاون (Contributing)](#contributing)
- [اعترافات (Credits)](#credits)
- [لائسنس](#license)

---

<a id="why-this-package"></a>

## یہ پیکج کیوں

Laravel کے زیادہ تر ویڈیو کال پیکجز **پیئر ٹو پیئر (P2P) WebRTC** پر مبنی ہوتے ہیں۔ P2P دو یا تین افراد کے لیے تو کام کرتا ہے، اس کے بعد جواب دے جاتا ہے: کیونکہ ہر شریک کو اپنی ویڈیو باقی ہر شریک کو الگ الگ اپ لوڈ کرنی پڑتی ہے۔

یہ پیکج **Ant Media Server کو بطور WebRTC SFU / میڈیا سرور** استعمال کرتا ہے، اس لیے آپ کو یہ سب ملتا ہے:

- **قابلِ توسیع ویڈیو کانفرنسنگ**، ایک ہی روم میں بہت سے شرکاء کے ساتھ
- بڑے ناظرین تک **انتہائی کم تاخیر (ultra-low latency) والی لائیو اسٹریمنگ** (WebRTC، تقریباً 0.5 سیکنڈ)
- MP4 یا WebM میں **سرور سائیڈ ریکارڈنگ**
- ایک ہی پلیٹ فارم میں **HLS، RTMP، SRT اور WebRTC**
- اپنے سرورز یا کلاؤڈ (AWS، Google Cloud، Azure، Oracle Cloud، آن پریمس) پر **سیلف ہوسٹڈ**، تاکہ آپ کا ویڈیو ڈیٹا کبھی آپ کے انفراسٹرکچر سے باہر نہ جائے

<a id="use-cases"></a>

## استعمال کے شعبے

| استعمال کا شعبہ | آپ کیا بنا سکتے ہیں |
|---|---|
| **ٹیلی میڈیسن / ٹیلی ہیلتھ** | ڈاکٹر اور مریض کی ویڈیو مشاورت، ورچوئل کلینک، دور سے سیکنڈ اوپینین |
| **ای لرننگ / آن لائن تعلیم اور کلاسز** | ورچوئل کلاس روم، لائیو لیکچرز، LMS ویڈیو رومز، ریکارڈ شدہ کورسز |
| **ویبینارز اور ورچوئل ایونٹس** | انٹرایکٹو پریزنٹرز کے ساتھ ایک سے بہت سوں تک لائیو براڈکاسٹ |
| **ٹیم میٹنگز** | آپ کی کمپنی کے لیے سیلف ہوسٹڈ زوم کا متبادل، گوگل میٹ کا متبادل یا مائیکروسافٹ ٹیمز کا متبادل (Zoom / Google Meet / Teams) |
| **کسٹمر سپورٹ** | ویڈیو کال کے ذریعے سپورٹ، ویڈیو KYC، دور سے معائنہ |
| **لائیو کامرس** | ریئل ٹائم چیٹ کے ساتھ لائیو شاپنگ اسٹریمز |
| **نگرانی (Surveillance)** | Laravel کے اندر IP کیمرہ (RTSP / ONVIF) کا لائیو منظر اور ریکارڈنگ |
| **سوشل اور کریئیٹر ایپس** | لائیو اسٹریمنگ، "گو لائیو" فیچرز، YouTube اور Facebook پر ری اسٹریم |

<a id="features"></a>

## خصوصیات

- Laravel facade، سروس کنٹینر بائنڈنگ اور آٹو ڈسکوری
- **لائیو اسٹریمز (براڈکاسٹس)** بنائیں، اپ ڈیٹ کریں، فہرست دیکھیں، شروع کریں، روکیں اور حذف کریں
- Ant Media کے main track اور subtracks کے ذریعے **ویڈیو کانفرنس رومز**
- پبلش اور پلے کے لیے **JWT**، **ایک بار استعمال ہونے والا ٹوکن** اور **TOTP** اسٹریم سیکیورٹی
- **JWT REST API تصدیق** (HS256) خودکار طور پر ہینڈل ہوتی ہے
- ہر اسٹریم کے لیے **ریکارڈنگ** شروع اور بند کریں (MP4 یا WebM)، HLS کو MP4 میں تبدیل کریں
- **VoD** مینجمنٹ: ریکارڈنگز اپ لوڈ، امپورٹ، فہرست اور حذف کریں
- RTMP اور SRT اینڈ پوائنٹس پر **ری اسٹریم / ملٹی اسٹریم** (YouTube Live، Facebook Live، Twitch، LinkedIn Live)
- **سبسکرائبر مینجمنٹ**: شرکاء کو شامل کریں، فہرست دیکھیں، بلاک کریں اور ان کی رسائی منسوخ کریں
- میٹنگ کے اندر چیٹ، ری ایکشنز اور سگنلز کے لیے **WebRTC ڈیٹا چینل** پیغامات
- **لائیو اعداد و شمار**: ناظرین (WebRTC، HLS، RTMP)، بٹ ریٹ، کلائنٹ اسٹیٹس، کنکشن ایونٹس
- **IP کیمرہ** سپورٹ: RTSP pull، ONVIF ڈسکوری، PTZ حرکت
- اسٹریم سورسز کے لیے **پلے لسٹس** اور seek کنٹرول
- **Webhook ریسیور** جو Laravel کے اپنے (native) ایونٹس فائر کرتا ہے
- Typed DTOs، Laravel HTTP کلائنٹ، retry اور timeout کنفیگریشن
- **Laravel 11، 12 اور 13** اور PHP 8.2+ کے ساتھ کام کرتا ہے
- Ant Media کے JavaScript، React، React Native، Flutter، Android اور iOS WebRTC SDKs کے ساتھ جوڑا جا سکتا ہے

<a id="how-it-compares"></a>

## دوسرے حل سے موازنہ

| | یہ پیکج | Zoom / Google Meet / Teams | Twilio / Agora / Vonage | P2P Laravel WebRTC پیکجز |
|---|---|---|---|---|
| سیلف ہوسٹڈ | ہاں | نہیں | نہیں | ہاں |
| ڈیٹا آپ کے سرورز پر رہتا ہے | ہاں | نہیں | نہیں | ہاں |
| فی منٹ فیس | نہیں | سبسکرپشن | ہاں | نہیں |
| بڑی میٹنگز (SFU) | ہاں | ہاں | ہاں | نہیں (2 سے 3 صارفین) |
| ہزاروں ناظرین تک لائیو اسٹریمنگ | ہاں | محدود | اضافی لاگت | نہیں |
| سرور سائیڈ ریکارڈنگ | ہاں | ہاں | اضافی لاگت | نہیں |
| آپ کی Laravel ایپ میں ضم (embedded) | ہاں | محدود | ہاں | ہاں |
| وائٹ لیبل / آپ کی اپنی برانڈنگ | ہاں | نہیں | ہاں | ہاں |

<a id="requirements"></a>

## ضروریات

- PHP **8.2** یا اس سے نیا ورژن
- Laravel **11.x، 12.x یا 13.x**
- ایک چلتا ہوا **Ant Media Server** (Community یا Enterprise Edition)۔ دیکھیں [Ant Media quick start](https://docs.antmedia.io/quick-start/)۔

<a id="installation"></a>

## انسٹالیشن

```bash
composer require ashrafbendary/laravel-webrtc-ant-media
```

انسٹالر چلائیں (یہ کنفیگ فائل اور webhook روٹ پبلش کرتا ہے):

```bash
php artisan webrtc-ant-media:install
```

یا کنفیگ دستی طور پر پبلش کریں:

```bash
php artisan vendor:publish --tag="webrtc-ant-media-config"
```

<a id="configuration"></a>

## کنفیگریشن

یہ ویلیوز اپنی `.env` فائل میں شامل کریں:

```dotenv
ANT_MEDIA_URL=https://media.example.com:5443
ANT_MEDIA_APP=live
ANT_MEDIA_JWT_SECRET=your-jwt-rest-api-filter-secret
ANT_MEDIA_STREAM_JWT_SECRET=your-stream-jwt-secret
ANT_MEDIA_TIMEOUT=15
ANT_MEDIA_WEBHOOK_SECRET=your-webhook-secret
```

| کلید (Key) | وضاحت |
|---|---|
| `ANT_MEDIA_URL` | Ant Media Server کا بنیادی URL۔ HTTPS کے لیے پورٹ `5443` اور HTTP کے لیے `5080` استعمال کریں (صرف لوکل) |
| `ANT_MEDIA_APP` | ایپلیکیشن کا نام، مثلاً `live`، `WebRTCAppEE` یا آپ کی اپنی کسٹم ایپ |
| `ANT_MEDIA_JWT_SECRET` | **Application Settings > JWT REST API Filter** سے حاصل کردہ سیکرٹ (HS256) |
| `ANT_MEDIA_STREAM_JWT_SECRET` | پبلش / پلے اسٹریم ٹوکنز پر دستخط کرنے کا سیکرٹ |
| `ANT_MEDIA_TIMEOUT` | سیکنڈز میں HTTP ٹائم آؤٹ |
| `ANT_MEDIA_WEBHOOK_SECRET` | آنے والے webhooks کی تصدیق کے لیے مشترکہ سیکرٹ |

**تصدیق (Authentication)۔** Ant Media کے ایپلیکیشن REST اینڈ پوائنٹس بطور ڈیفالٹ صرف `127.0.0.1` سے درخواستیں قبول کرتے ہیں (IP فلٹر)۔ اگر آپ کا Laravel بیک اینڈ کسی دوسرے سرور پر ہے تو Ant Media ویب پینل میں **JWT REST API Filter** فعال کریں اور اوپر والا سیکرٹ سیٹ کریں۔ پیکج `exp` claim کے ساتھ ایک مختصر مدت کا HS256 ٹوکن سائن کرتا ہے اور اسے ہر درخواست میں `Authorization: Bearer {token}` کے طور پر بھیجتا ہے۔

<a id="quick-start-create-a-video-meeting-room"></a>

## فوری آغاز: ویڈیو میٹنگ روم بنائیں

```php
use AshrafBendary\WebRtcAntMedia\Facades\AntMedia;

// 1. میٹنگ روم بنائیں
$room = AntMedia::rooms()->create(name: 'Weekly Team Meeting');

// 2. ہر شریک کو ایک محفوظ پبلش + پلے ٹوکن دیں (2 گھنٹے کے لیے کارآمد)
$token = AntMedia::tokens()->jwt(
    streamId: $room->streamId,
    type: 'publish',
    expiresAt: now()->addHours(2),
    roomId: $room->streamId,
);

// 3. اپنے Blade / Vue / React ویو میں $room->streamId اور $token کو Ant Media WebRTC JavaScript SDK کے حوالے کریں
return view('meeting', compact('room', 'token'));
```

Zoom طرز کے میٹنگ روم کے لیے بس اتنا ہی بیک اینڈ درکار ہے۔ براؤزر کی طرف آفیشل [Ant Media WebRTC JavaScript SDK](https://docs.antmedia.io/guides/developer-sdk-and-api/sdk-integration/) استعمال ہوتا ہے۔

<a id="usage"></a>

## استعمال

<a id="live-streams-broadcasts"></a>

### لائیو اسٹریمز (براڈکاسٹس)

```php
use AshrafBendary\WebRtcAntMedia\Facades\AntMedia;

$stream = AntMedia::broadcasts()->create([
    'name' => 'Product Launch Live',
    'description' => 'Live product launch event',
]);

$stream->streamId;   // مثلاً "stream_8f3a..."
$stream->rtmpURL;    // OBS کے لیے RTMP ingest URL

AntMedia::broadcasts()->get($stream->streamId);
AntMedia::broadcasts()->list(offset: 0, size: 50, type: 'liveStream', sortBy: 'date', order: 'desc');
AntMedia::broadcasts()->update($stream->streamId, ['name' => 'New title']);
AntMedia::broadcasts()->stop($stream->streamId);
AntMedia::broadcasts()->delete($stream->streamId);
AntMedia::broadcasts()->deleteMany(['id1', 'id2']);
AntMedia::broadcasts()->count();
AntMedia::broadcasts()->activeCount();
AntMedia::broadcasts()->info($stream->streamId);   // چوڑائی، اونچائی، بٹ ریٹ، کوڈیک
```

<a id="video-conference-rooms-multi-party-meetings"></a>

### ویڈیو کانفرنس رومز (کثیر شرکاء والی میٹنگز)

میٹنگ روم ایک main track ہوتا ہے۔ ہر شریک ایک subtrack پبلش کرتا ہے۔

```php
$room = AntMedia::rooms()->create(name: 'Doctor Consultation #1024');

AntMedia::rooms()->addParticipant($room->streamId, participantStreamId: 'patient_1024');
AntMedia::rooms()->participants($room->streamId, offset: 0, size: 50);
AntMedia::rooms()->activeParticipants($room->streamId);
AntMedia::rooms()->activeParticipantsCount($room->streamId);
AntMedia::rooms()->removeParticipant($room->streamId, participantStreamId: 'patient_1024');

// سب کے لیے میٹنگ ختم کریں
AntMedia::rooms()->end($room->streamId);   // main track اور subtracks کو روک دیتا ہے
```

<a id="secure-access-tokens-jwt-one-time-token-totp"></a>

### محفوظ رسائی ٹوکنز (JWT، ایک بار استعمال ہونے والا ٹوکن، TOTP)

کنٹرول کریں کہ کون **پبلش** کر سکتا ہے (کیمرہ / مائیک) اور کون **پلے** کر سکتا ہے (دیکھ سکتا ہے)۔

```php
// JWT ٹوکن (تجویز کردہ)، لوکل طور پر سائن ہوتا ہے، سرور سے رابطے کی ضرورت نہیں
$jwt = AntMedia::tokens()->jwt($streamId, type: 'play', expiresAt: now()->addHour());

// Ant Media Server کا بنایا ہوا ایک بار استعمال ہونے والا ٹوکن
$oneTime = AntMedia::tokens()->oneTime($streamId, type: 'publish', expiresAt: now()->addMinutes(30));

// کسی سبسکرائبر کے لیے TOTP
$totp = AntMedia::subscribers()->totp($streamId, subscriberId: 'user_42', type: 'publish');

AntMedia::tokens()->validate($token);
AntMedia::tokens()->list($streamId);
AntMedia::tokens()->revokeAll($streamId);
```

<a id="recording-mp4--webm"></a>

### ریکارڈنگ (MP4 / WebM)

```php
AntMedia::recordings()->start($streamId, type: 'mp4', fileName: 'consultation_1024');
AntMedia::recordings()->stop($streamId, type: 'mp4');

// HLS ریکارڈنگ کو MP4 میں تبدیل کریں
AntMedia::recordings()->hlsToMp4('stream_8f3a', deleteHlsFiles: true);
```

<a id="video-on-demand-vod"></a>

### ویڈیو آن ڈیمانڈ (VoD)

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

### YouTube، Facebook، RTMP اور SRT پر ری اسٹریم

```php
AntMedia::endpoints()->add($streamId, 'rtmp://a.rtmp.youtube.com/live2/YOUR-KEY');
AntMedia::endpoints()->add($streamId, 'srt://ingest.example.com:9000', resolutionHeight: 720);
AntMedia::endpoints()->remove($streamId, 'rtmp://a.rtmp.youtube.com/live2/YOUR-KEY');
```

<a id="participants-and-subscribers"></a>

### شرکاء اور سبسکرائبرز

```php
AntMedia::subscribers()->add($streamId, [
    'subscriberId' => 'user_42',
    'type' => 'publish',   // publish والا پلے بھی کر سکتا ہے (کانفرنسنگ کے لیے ضروری)
]);

AntMedia::subscribers()->list($streamId, offset: 0, size: 50);
AntMedia::subscribers()->block($streamId, 'user_42', seconds: 600, type: 'publish_play');
AntMedia::subscribers()->delete($streamId, 'user_42');
AntMedia::subscribers()->revokeAll($streamId);
AntMedia::subscribers()->connectionEvents($streamId, offset: 0, size: 50);
```

<a id="data-channel-messages-in-meeting-chat"></a>

### ڈیٹا چینل پیغامات (میٹنگ کے اندر چیٹ)

```php
AntMedia::broadcasts()->sendMessage($streamId, [
    'type' => 'chat',
    'from' => 'Dr. Ahmed',
    'text' => 'Please turn on your camera.',
]);
```

<a id="statistics-and-analytics"></a>

### اعداد و شمار اور تجزیات

```php
AntMedia::stats()->broadcast($streamId);        // WebRTC، HLS اور RTMP ناظرین کی تعداد
AntMedia::stats()->total();                     // پوری ایپ میں ناظرین کی کل تعداد
AntMedia::stats()->webrtcClients($streamId);    // ہر کلائنٹ کا آڈیو / ویڈیو بٹ ریٹ
AntMedia::stats()->lowLevelSend();
AntMedia::stats()->lowLevelReceive();
```

<a id="ip-cameras-rtsp-and-onvif"></a>

### IP کیمرے، RTSP اور ONVIF

```php
$camera = AntMedia::broadcasts()->create([
    'name' => 'Lobby Camera',
    'type' => 'ipCamera',
    'ipAddr' => '192.168.1.50',
    'username' => 'admin',
    'password' => 'secret',
], autoStart: true);

AntMedia::cameras()->discover();                       // ONVIF ڈسکوری
AntMedia::cameras()->profiles($camera->streamId);
AntMedia::cameras()->move($camera->streamId, x: 0.2, y: 0, zoom: 0, movement: 'relative');
AntMedia::cameras()->stopMove($camera->streamId);
AntMedia::broadcasts()->start($camera->streamId);      // اسٹریم سورس سے pull شروع کریں
```

<a id="webhooks-and-laravel-events"></a>

### Webhooks اور Laravel ایونٹس

Ant Media میں **Application Settings > Webhook URL** کو اس پتے پر سیٹ کریں:

```
https://your-app.com/ant-media/webhook
```

Laravel کے اپنے (native) ایونٹس کو سنیں:

```php
use AshrafBendary\WebRtcAntMedia\Events\LiveStreamStarted;
use AshrafBendary\WebRtcAntMedia\Events\LiveStreamEnded;
use AshrafBendary\WebRtcAntMedia\Events\RecordingReady;

Event::listen(LiveStreamStarted::class, fn ($e) => logger("Meeting started: {$e->streamId}"));
Event::listen(LiveStreamEnded::class,   fn ($e) => logger("Meeting ended: {$e->streamId}"));
Event::listen(RecordingReady::class,    fn ($e) => logger("Recording ready: {$e->vodId}"));
```

<a id="rest-api-coverage"></a>

## REST API کوریج

تمام کالز `{ANT_MEDIA_URL}/{ANT_MEDIA_APP}/rest/v2/...` کو بھیجی جاتی ہیں۔ مکمل اسکیماز کے لیے دیکھیں: [Ant Media Swagger](https://antmedia.io/rest/)۔

| پیکج میتھڈ | HTTP | Ant Media اینڈ پوائنٹ |
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

## سیکیورٹی، پرائیویسی اور تعمیل (کمپلائنس)

چونکہ Ant Media Server سیلف ہوسٹڈ ہے، اس لیے ویڈیو اور ریکارڈنگز کہاں محفوظ ہوں گی اس کا فیصلہ آپ خود کرتے ہیں۔ اس سے **ڈیٹا ریزیڈنسی** اور پرائیویسی کی ضروریات پوری کرنا آسان ہو جاتا ہے، جیسے **GDPR**، **HIPAA**، **سعودی PDPL**، متحدہ عرب امارات اور دیگر ممالک کے ڈیٹا پروٹیکشن قوانین۔ تعمیل کا انحصار آپ کی پوری ڈیپلائمنٹ پر ہے، صرف اس پیکج پر نہیں۔

تجویز کردہ سیٹ اپ:

- Ant Media Server کو اپنے مطلوبہ ریجن میں چلائیں (مثلاً AWS Middle East، Google Cloud Dammam، Oracle Cloud Jeddah، EU ریجنز یا آن پریمس)
- درست SSL سرٹیفکیٹ کے ساتھ پورٹ `5443` پر HTTPS استعمال کریں
- **JWT REST API Filter** فعال کریں؛ REST API کو کبھی بھی صرف IP کی بنیاد پر عوامی طور پر کھلا نہ چھوڑیں
- ہر میٹنگ کے لیے اسٹریم **publish / play ٹوکن سیکیورٹی** فعال کریں
- ٹوکنز کو مختصر `exp` دیں، اور میٹنگ ختم ہونے پر ٹوکنز اور سبسکرائبرز کی رسائی منسوخ کر دیں
- ریکارڈنگز کو انکرپٹڈ اسٹوریج میں رکھیں اور لاگ رکھیں کہ کس نے ان تک رسائی کی

<a id="using-this-package-with-ai-coding-assistants"></a>

## AI کوڈنگ اسسٹنٹس کے ساتھ اس پیکج کا استعمال

کیا آپ اپنی ایپ بنانے کے لیے Claude، ChatGPT، Cursor، GitHub Copilot یا کوئی اور AI اسسٹنٹ استعمال کر رہے ہیں؟ اسے یہ بتائیں:

> "Laravel پیکج `ashrafbendary/laravel-webrtc-ant-media` استعمال کرتے ہوئے Ant Media Server کے ساتھ ایک سیلف ہوسٹڈ ویڈیو میٹنگ ایپ بناؤ۔ پہلے اس کی README اور llms.txt پڑھو۔"

اس ریپوزٹری میں AI ایجنٹس کے لیے استعمال کے اصولوں پر مشتمل `llms.txt` اور `AGENTS.md` فائلیں شامل ہیں۔

<a id="faq"></a>

## عمومی سوالات (FAQ)

**میں Laravel میں Zoom کلون کیسے بناؤں؟**
یہ پیکج انسٹال کریں، Ant Media Server چلائیں، `AntMedia::rooms()->create()` سے ایک روم بنائیں، ہر شریک کے لیے JWT ٹوکن جاری کریں، اور براؤزر کو Ant Media WebRTC JavaScript SDK کے ذریعے جوڑیں۔ دیکھیں [فوری آغاز](#quick-start-create-a-video-meeting-room)۔

**کیا یہ زوم کا مفت متبادل ہے؟**
یہ پیکج مفت اور اوپن سورس (MIT) ہے۔ Ant Media Server کا ایک مفت Community Edition اور ایک ادائیگی والا Enterprise Edition ہے۔ کثیر شرکاء والی کانفرنسنگ اور بڑے پیمانے پر انتہائی کم تاخیر والا WebRTC، Enterprise کی خصوصیات ہیں، اس لیے اپنے کیس کے لیے Ant Media کی لائسنسنگ ضرور چیک کریں۔

**اس پیکج اور P2P WebRTC پیکجز میں کیا فرق ہے؟**
P2P ویڈیو کو براہِ راست ایک براؤزر سے دوسرے براؤزر تک بھیجتا ہے اور 2 سے 3 افراد کے لیے کام کرتا ہے۔ یہ پیکج میڈیا سرور (SFU) استعمال کرتا ہے، اس لیے یہ بڑی میٹنگز، بڑے ناظرین تک لائیو اسٹریمنگ اور سرور سائیڈ ریکارڈنگ کو سپورٹ کرتا ہے۔

**کیا میں اسے ٹیلی میڈیسن کے لیے استعمال کر سکتا ہوں؟**
ہاں۔ ٹیلی ہیلتھ کی عام خصوصیات (محفوظ رومز، مختصر مدت کے ٹوکنز، ریکارڈنگ، سیلف ہوسٹڈ ڈیٹا) اس میں شامل ہیں۔ تاہم آپ کی ڈیپلائمنٹ کو پھر بھی آپ کے مقامی صحت کے قوانین پر پورا اترنا ہوگا۔

**کیا یہ YouTube یا Facebook پر لائیو اسٹریمنگ کو سپورٹ کرتا ہے؟**
ہاں، RTMP یا SRT ingest URL کے ساتھ `AntMedia::endpoints()->add()` استعمال کریں۔

**کون سے فرنٹ اینڈز سپورٹ ہوتے ہیں؟**
ویب پر Blade، Livewire، Inertia، Vue، React اور سادہ JavaScript، اور آفیشل Ant Media SDKs کے ذریعے React Native، Flutter، Android اور iOS۔

**کیا یہ Laravel Octane، Horizon اور queues کے ساتھ کام کرتا ہے؟**
ہاں۔ تمام کالز Laravel HTTP کلائنٹ استعمال کرتی ہیں اور jobs میں چلانا محفوظ ہے۔

**کیا یہ Ant Media Server کے کلسٹر موڈ کو سپورٹ کرتا ہے؟**
ہاں۔ `ANT_MEDIA_URL` کو اپنے کلسٹر کے لوڈ بیلنسر یا origin کی طرف پوائنٹ کریں۔

<a id="testing"></a>

## ٹیسٹنگ

```bash
composer test
```

یہ پیکج `Http::fake()` استعمال کرتا ہے، اس لیے ٹیسٹس کبھی کسی حقیقی میڈیا سرور کو کال نہیں کرتے۔

<a id="contributing"></a>

## تعاون (Contributing)

Pull requests کا خیر مقدم ہے۔ بڑی تبدیلیوں کے لیے براہِ کرم پہلے ایک issue کھولیں، اور نئے اینڈ پوائنٹس کے لیے ٹیسٹس شامل کریں۔

<a id="credits"></a>

## اعترافات (Credits)

- [Ashraf Bendary](https://github.com/ashrafbendary)
- [Ant Media Server REST API](https://antmedia.io/rest/) پر تعمیر کیا گیا

<a id="license"></a>

## لائسنس

The MIT License (MIT)۔ دیکھیں [LICENSE](LICENSE)۔

---

**کلیدی الفاظ (Keywords):** لاراویل پیکج, لاراویل WebRTC, ویڈیو کانفرنسنگ, ویڈیو میٹنگ, ویڈیو کال, زوم کا متبادل, گوگل میٹ کا متبادل, مائیکروسافٹ ٹیمز کا متبادل, سیلف ہوسٹڈ ویڈیو کانفرنسنگ, لائیو اسٹریمنگ, میٹنگ ریکارڈنگ, ٹیلی میڈیسن, آن لائن تعلیم, ای لرننگ, ورچوئل کلاس روم, ویبینار, laravel webrtc, laravel video conference, laravel video call, laravel video meeting, laravel zoom clone, zoom alternative, google meet alternative, microsoft teams alternative, self-hosted video conferencing, laravel live streaming, webrtc php, ant media server, ant media laravel, antmedia php sdk, webrtc sfu, low latency streaming, hls, rtmp, srt, video recording, telemedicine laravel, telehealth video, elearning video, virtual classroom, webinar platform, laravel package
