# Laravel WebRTC Ant Media

[English](README.md) | [العربية](README.ar.md) | [اردو](README.ur.md) | [हिन्दी](README.hi.md) | **Türkçe** | [日本語](README.ja.md) | [简体中文](README.zh-CN.md)

### Laravel ile Zoom, Google Meet veya Microsoft Teams tarzı bir görüntülü toplantı uygulaması geliştirin. Ant Media Server altyapısıyla kendi sunucunuzda barındırılan (self-hosted), ölçeklenebilir WebRTC video konferans, canlı yayın ve toplantı kaydı.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](https://packagist.org/packages/ashrafbendary/laravel-webrtc-ant-media)
[![Total Downloads](https://img.shields.io/packagist/dt/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](https://packagist.org/packages/ashrafbendary/laravel-webrtc-ant-media)
[![PHP Version](https://img.shields.io/packagist/php-v/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](https://packagist.org/packages/ashrafbendary/laravel-webrtc-ant-media)
[![License](https://img.shields.io/packagist/l/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](LICENSE)

**Laravel WebRTC Ant Media**, [Ant Media Server REST API](https://docs.antmedia.io/guides/developer-sdk-and-api/rest-api-guide/) için geliştirilmiş bir Laravel paketidir (PHP SDK). Herhangi bir Laravel uygulamasının, sade bir Laravel facade'ı ile **görüntülü toplantılar, görüntülü aramalar, webinarlar, canlı yayınlar, tele tıp (uzaktan sağlık) görüşmeleri ve çevrim içi dersler** oluşturmasını sağlar; üstelik Zoom, Twilio, Agora veya Vonage'a dakika başı ücret ödemeden.

> Resmi olmayan bir topluluk paketidir. Ant Media Inc. ile herhangi bir bağlantısı yoktur. "Zoom", "Google Meet" ve "Microsoft Teams" ilgili sahiplerinin ticari markalarıdır ve yalnızca karşılaştırma amacıyla anılmaktadır.

---

## İçindekiler

- [Neden bu paket](#why-this-package)
- [Kullanım senaryoları](#use-cases)
- [Özellikler](#features)
- [Karşılaştırma](#how-it-compares)
- [Gereksinimler](#requirements)
- [Kurulum](#installation)
- [Yapılandırma](#configuration)
  - [Origin, edge, ana uygulama ve test uygulaması](#origin-edge-main-app-and-test-app)
  - [StreamApp ve konferans uygulaması](#streamapp-and-the-conference-application)
- [Hızlı başlangıç: görüntülü toplantı odası oluşturma](#quick-start-create-a-video-meeting-room)
- [Kullanım](#usage)
  - [Frontend URL'leri (WebSocket, HLS, oynatıcı)](#frontend-urls-websocket-hls-player)
  - [Canlı yayınlar (broadcast)](#live-streams-broadcasts)
  - [Video konferans odaları (çok katılımcılı toplantılar)](#video-conference-rooms-multi-party-meetings)
  - [Güvenli erişim token'ları (JWT, tek kullanımlık token, TOTP)](#secure-access-tokens-jwt-one-time-token-totp)
  - [Toplantı kaydı (MP4 / WebM)](#recording-mp4--webm)
  - [İsteğe bağlı video (VoD)](#video-on-demand-vod)
  - [YouTube, Facebook, RTMP ve SRT'ye yeniden yayın](#restream-to-youtube-facebook-rtmp-and-srt)
  - [Katılımcılar ve aboneler](#participants-and-subscribers)
  - [Data channel mesajları (toplantı içi sohbet)](#data-channel-messages-in-meeting-chat)
  - [İstatistikler ve analitik](#statistics-and-analytics)
  - [IP kameralar, RTSP ve ONVIF](#ip-cameras-rtsp-and-onvif)
  - [Webhook'lar ve Laravel event'leri](#webhooks-and-laravel-events)
- [REST API kapsamı](#rest-api-coverage)
- [Güvenlik, gizlilik ve mevzuat uyumu](#security-privacy-and-compliance)
- [Bu paketi yapay zekâ kodlama asistanlarıyla kullanma](#using-this-package-with-ai-coding-assistants)
- [SSS](#faq)
- [Test](#testing)
- [Katkıda bulunma](#contributing)
- [Emeği geçenler](#credits)
- [Lisans](#license)

---

<a id="why-this-package"></a>

## Neden bu paket

Laravel için geliştirilmiş görüntülü arama paketlerinin çoğu **eşler arası (P2P) WebRTC** kullanır. P2P, 2 veya 3 kişiye kadar çalışır, sonrasında çöker: her katılımcı kendi videosunu diğer tüm katılımcılara ayrı ayrı yükler.

Bu paket **Ant Media Server'ı bir WebRTC SFU / medya sunucusu olarak** kullanır; böylece şunları elde edersiniz:

- Tek bir odada çok sayıda katılımcıyla **ölçeklenebilir video konferans**
- Geniş kitlelere **ultra düşük gecikmeli canlı yayın** (WebRTC, yaklaşık 0,5 saniye)
- MP4 veya WebM formatında **sunucu tarafı kayıt**
- Tek platformda **HLS, RTMP, SRT ve WebRTC**
- Kendi sunucularınızda veya bulutunuzda (AWS, Google Cloud, Azure, Oracle Cloud, şirket içi/on-premise) **kendi sunucunda barındırma (self-hosted)**; böylece video verileriniz altyapınızın dışına hiç çıkmaz

<a id="use-cases"></a>

## Kullanım senaryoları

| Kullanım senaryosu | Neler geliştirebilirsiniz |
|---|---|
| **Tele tıp / uzaktan sağlık** | Doktor ve hasta arasında görüntülü muayene, sanal klinik, uzaktan ikinci görüş |
| **Uzaktan eğitim / e-öğrenme** | Sanal sınıf, canlı dersler, LMS video odaları, kayıtlı kurslar |
| **Webinarlar ve sanal etkinlikler** | Etkileşimli sunucularla bire çok canlı yayın |
| **Ekip toplantıları** | Şirketiniz için kendi sunucunuzda barındırılan Zoom / Google Meet / Teams alternatifi |
| **Müşteri desteği** | Görüntülü arama ile destek, görüntülü KYC, uzaktan denetim |
| **Canlı ticaret** | Gerçek zamanlı sohbetli canlı alışveriş yayınları |
| **Güvenlik kamerası izleme** | Laravel içinde IP kamera (RTSP / ONVIF) canlı izleme ve kayıt |
| **Sosyal ve içerik üreticisi uygulamaları** | Canlı yayın, "canlıya geç" özellikleri, YouTube ve Facebook'a yeniden yayın |

<a id="features"></a>

## Özellikler

- Laravel facade, service container binding ve auto-discovery
- **Origin ve edge sunucuları** ile **ana uygulama ve test uygulaması**, hepsi `.env` üzerinden
- Hazır frontend URL'leri (publish/play WebSocket, HLS, gömülü oynatıcı, RTMP)
- **Canlı yayınları (broadcast)** oluşturma, güncelleme, listeleme, başlatma, durdurma ve silme
- Ant Media ana track ve alt track'lerini (subtrack) kullanan **video konferans odaları**
- Yayın (publish) ve izleme (play) için **JWT**, **tek kullanımlık token** ve **TOTP** yayın güvenliği
- Otomatik olarak yönetilen **JWT REST API kimlik doğrulaması** (HS256)
- Yayın bazında **kaydı** başlatma ve durdurma (MP4 veya WebM), HLS'yi MP4'e dönüştürme
- **VoD** yönetimi: kayıtları yükleme, içe aktarma, listeleme, silme
- RTMP ve SRT uç noktalarına **yeniden yayın / çoklu yayın (restream / multistream)** (YouTube Live, Facebook Live, Twitch, LinkedIn Live)
- **Abone yönetimi**: katılımcı ekleme, listeleme, engelleme ve yetkisini iptal etme
- Toplantı içi sohbet, tepkiler ve sinyaller için **WebRTC data channel** mesajları
- **Canlı istatistikler**: izleyiciler (WebRTC, HLS, RTMP), bitrate, istemci istatistikleri, bağlantı olayları
- **IP kamera** desteği: RTSP pull, ONVIF keşfi, PTZ hareketi
- Yayın kaynakları için **oynatma listeleri (playlist)** ve konum atlama (seek) kontrolü
- Yerel (native) Laravel event'lerini tetikleyen **webhook alıcısı**
- Tipli DTO'lar, Laravel HTTP client, yeniden deneme (retry) ve zaman aşımı (timeout) yapılandırması
- **Laravel 11, 12 ve 13**, PHP 8.2+ ile çalışır
- Ant Media JavaScript, React, React Native, Flutter, Android ve iOS WebRTC SDK'larıyla birlikte kullanılabilir

<a id="how-it-compares"></a>

## Karşılaştırma

| | Bu paket | Zoom / Google Meet / Teams | Twilio / Agora / Vonage | P2P Laravel WebRTC paketleri |
|---|---|---|---|---|
| Kendi sunucunda barındırma | Evet | Hayır | Hayır | Evet |
| Veriler kendi sunucularınızda kalır | Evet | Hayır | Hayır | Evet |
| Dakika başı ücret | Hayır | Abonelik | Evet | Hayır |
| Büyük toplantılar (SFU) | Evet | Evet | Evet | Hayır (2 ila 3 kullanıcı) |
| Binlerce kişiye canlı yayın | Evet | Sınırlı | Ek maliyet | Hayır |
| Sunucu tarafı kayıt | Evet | Evet | Ek maliyet | Hayır |
| Laravel uygulamanıza gömülü | Evet | Sınırlı | Evet | Evet |
| White label / kendi markanız | Evet | Hayır | Evet | Evet |

<a id="requirements"></a>

## Gereksinimler

- PHP **8.2** veya üzeri
- Laravel **11.x, 12.x veya 13.x**
- Çalışır durumda bir **Ant Media Server** (Community veya Enterprise Edition). Bkz. [Ant Media hızlı başlangıç](https://docs.antmedia.io/quick-start/).

<a id="installation"></a>

## Kurulum

```bash
composer require ashrafbendary/laravel-webrtc-ant-media
```

Kurulum aracını çalıştırın (yapılandırma dosyasını yayımlar ve `.env` anahtarlarını yazdırır; webhook route'u otomatik olarak kaydedilir):

```bash
php artisan webrtc-ant-media:install
```

Ya da yapılandırma dosyasını elle yayımlayın:

```bash
php artisan vendor:publish --tag="webrtc-ant-media-config"
```

<a id="configuration"></a>

## Yapılandırma

`.env` dosyanıza şunları ekleyin:

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
```

| Anahtar | Açıklama |
|---|---|
| `ANT_MEDIA_ORIGIN_URL` | Origin sunucusunun URL'si. Tüm REST çağrıları ve WebRTC yayınları (publishing) buraya gider. HTTPS için `5443`, HTTP için `5080` portunu kullanın (yalnızca yerel ortamda). `ANT_MEDIA_URL` hâlâ takma ad (alias) olarak kabul edilir |
| `ANT_MEDIA_EDGE_URL` | İsteğe bağlı edge sunucusu veya edge load balancer'ı; oynatma (playback) URL'leri için kullanılır. Boş = origin |
| `ANT_MEDIA_APP` | Ana uygulama adı, örneğin `LiveApp`, `WebRTCAppEE`, `live` veya StreamApp'ten oluşturulmuş kendi özel uygulamanız |
| `ANT_MEDIA_TEST_APP` | Test yayınları için isteğe bağlı ikinci uygulama; `AntMedia::test()` tarafından kullanılır |
| `ANT_MEDIA_USE_TEST_APP` | `true` olduğunda tüm çağrılar test uygulamasına gider (yerel / staging ortamında kullanışlıdır) |
| `ANT_MEDIA_JWT_SECRET` | **Application Settings > JWT REST API Filter** bölümündeki secret (HS256) |
| `ANT_MEDIA_STREAM_JWT_SECRET` | Publish / play yayın token'larını imzalamak için kullanılan secret |
| `ANT_MEDIA_TIMEOUT` | Saniye cinsinden HTTP zaman aşımı |
| `ANT_MEDIA_RETRIES` | Başarısız GET istekleri için yeniden deneme sayısı (POST / PUT / DELETE asla yeniden denenmez). Varsayılan `1` |
| `ANT_MEDIA_WEBHOOK_SECRET` | Gelen webhook'ları doğrulamak için kullanılan paylaşımlı secret |

İsteğe bağlı test uygulaması geçersiz kılmaları (her biri ayarlanmazsa ana değer kullanılır): `ANT_MEDIA_TEST_ORIGIN_URL`, `ANT_MEDIA_TEST_EDGE_URL`, `ANT_MEDIA_TEST_JWT_SECRET`, `ANT_MEDIA_TEST_STREAM_JWT_SECRET`.

**Kimlik doğrulama.** Ant Media uygulama REST uç noktaları varsayılan olarak yalnızca `127.0.0.1` adresinden gelen istekleri kabul eder (IP filtresi). Uzak bir Laravel backend'i için Ant Media web panelinde **JWT REST API Filter** seçeneğini etkinleştirin ve yukarıdaki secret'ı ayarlayın. Paket, `exp` claim'i içeren kısa ömürlü bir HS256 token'ı imzalar ve her istekte `Authorization: Bearer {token}` başlığı olarak gönderir.

<a id="origin-edge-main-app-and-test-app"></a>

### Origin, edge, ana uygulama ve test uygulaması

```php
use AshrafBendary\WebRtcAntMedia\Facades\AntMedia;

AntMedia::broadcasts()->create(['name' => 'Live']);          // ana uygulama (ANT_MEDIA_APP)
AntMedia::test()->broadcasts()->create(['name' => 'Try']);   // test uygulaması (ANT_MEDIA_TEST_APP)
AntMedia::main()->broadcasts()->list();                      // ANT_MEDIA_USE_TEST_APP=true olsa bile ana uygulama
AntMedia::app('WebRTCAppEE')->broadcasts()->count();         // aynı sunuculardaki başka herhangi bir uygulama

AntMedia::appName();   // "LiveApp" (veya ANT_MEDIA_USE_TEST_APP=true ise test uygulaması)
```

- REST API çağrıları ve WebRTC **yayını (publishing)** her zaman **origin** sunucusunu kullanır.
- **Oynatma (playback)** URL'leri (WebRTC play, HLS, gömülü oynatıcı, kayıtlar) **edge** sunucusunu, edge ayarlanmamışsa origin'i kullanır.

<a id="streamapp-and-the-conference-application"></a>

### StreamApp ve konferans uygulaması

Eski [conference-call-application](https://github.com/ant-media/conference-call-application) (Circle) deposu 31 Ağustos 2026'da arşivlendi. [StreamApp](https://github.com/ant-media/StreamApp), Ant Media Server'ın güncel temel uygulamasıdır: varsayılan uygulamalar (`LiveApp`, `WebRTCAppEE`, `live`) ve özel uygulamalar bundan oluşturulur; ayrıca konferans örnekleriyle (`conference.html`, `multitrack-conference.html`) birlikte gelir.

StreamApp, Circle arayüzünün özellik özellik birebir karşılığı **değildir**: konferans sayfası katılma/ayrılma, publish/play, ekran paylaşımı, mikrofon ve kamera açma/kapatma ile data channel sohbetini kapsar; ancak hazır bir kayıt düğmesi, bekleme odası, konferans sayfasında sanal arka plan, tepkiler, katılımcı listesi, sabitleme (pinning), ara odalar (breakout rooms) veya webinar/moderasyon arayüzü sunmaz. Bu paket bu arayüzlerin hiçbirine bağlı değildir: her uygulama için aynı olan Ant Media REST API ile konuşur; bu yüzden `ANT_MEDIA_APP` değerini StreamApp tabanlı uygulamanıza ayarlayın ve ihtiyacınız olan toplantı arayüzünü kendiniz oluşturun.

<a id="quick-start-create-a-video-meeting-room"></a>

## Hızlı başlangıç: görüntülü toplantı odası oluşturma

```php
use AshrafBendary\WebRtcAntMedia\Facades\AntMedia;

// 1. Bir toplantı odası oluşturun
$room = AntMedia::rooms()->create(name: 'Weekly Team Meeting');

// 2. Her katılımcıya güvenli bir publish + play token'ı verin (2 saat geçerli)
$token = AntMedia::tokens()->jwt(
    streamId: $room->streamId,
    type: 'publish',
    expiresAt: now()->addHours(2),
    roomId: $room->streamId,
);

// 3. $room->streamId ve $token değerlerini Blade / Vue / React görünümünüzdeki Ant Media WebRTC JavaScript SDK'sına aktarın
return view('meeting', compact('room', 'token'));
```

Ya da frontend'in ihtiyaç duyduğu her şeyi JSON olarak döndürün (secret içermez):

```php
return response()->json(AntMedia::urls()->forClient($room->streamId, $token));
// { streamId, token, app, publishWebSocketUrl, playWebSocketUrl, hlsUrl }
```

Zoom tarzı bir toplantı odası için gereken backend'in tamamı bu kadar. Tarayıcı tarafında resmi [Ant Media WebRTC JavaScript SDK](https://docs.antmedia.io/guides/developer-sdk-and-api/sdk-integration/) kullanılır.

<a id="usage"></a>

## Kullanım

<a id="frontend-urls-websocket-hls-player"></a>

### Frontend URL'leri (WebSocket, HLS, oynatıcı)

```php
AntMedia::urls()->publishWebSocket();              // wss://origin.example.com:5443/LiveApp/websocket
AntMedia::urls()->playWebSocket();                 // wss://edge.example.com:5443/LiveApp/websocket
AntMedia::urls()->hls($streamId, $token);          // https://edge.../LiveApp/streams/{id}.m3u8?token=...
AntMedia::urls()->player($streamId, $token);       // https://edge.../LiveApp/play.html?id=...&token=...
AntMedia::urls()->recording('stream1.mp4');        // https://edge.../LiveApp/streams/stream1.mp4
AntMedia::urls()->rtmp($streamId);                 // rtmp://origin.example.com/LiveApp/{id} (OBS)
AntMedia::urls()->forClient($streamId, $token);    // JS kodunuz için dizi: streamId, token, WebSocket ve HLS URL'leri
AntMedia::test()->urls()->playWebSocket();         // test uygulaması için aynı yardımcılar
```

<a id="live-streams-broadcasts"></a>

### Canlı yayınlar (broadcast)

```php
use AshrafBendary\WebRtcAntMedia\Facades\AntMedia;

$stream = AntMedia::broadcasts()->create([
    'name' => 'Product Launch Live',
    'description' => 'Live product launch event',
]);

$stream->streamId;   // örn. "stream_8f3a..."
$stream->rtmpURL;    // OBS için RTMP ingest URL'si

AntMedia::broadcasts()->get($stream->streamId);
AntMedia::broadcasts()->list(offset: 0, size: 50, type: 'liveStream', sortBy: 'date', order: 'desc');
AntMedia::broadcasts()->update($stream->streamId, ['name' => 'New title']);
AntMedia::broadcasts()->stop($stream->streamId);
AntMedia::broadcasts()->delete($stream->streamId);
$stream->isLive();                                  // status === "broadcasting"
$stream->get('hlsViewerCount');                     // Ant Media'nın diğer herhangi bir alanı
AntMedia::broadcasts()->deleteMany(['id1', 'id2']);
AntMedia::broadcasts()->count();
AntMedia::broadcasts()->activeCount();
AntMedia::broadcasts()->info($stream->streamId);   // genişlik, yükseklik, bitrate, codec
```

<a id="video-conference-rooms-multi-party-meetings"></a>

### Video konferans odaları (çok katılımcılı toplantılar)

Bir toplantı odası, bir ana track'tir (main track). Her katılımcı bir alt track (subtrack) yayınlar.

```php
$room = AntMedia::rooms()->create(name: 'Doctor Consultation #1024');
$room = AntMedia::rooms()->create(name: 'Class 7A', streamId: 'class-7a');   // kendi oda id'nizi seçin
AntMedia::rooms()->get('class-7a');

AntMedia::rooms()->addParticipant($room->streamId, participantStreamId: 'patient_1024');
AntMedia::rooms()->participants($room->streamId, offset: 0, size: 50);
AntMedia::rooms()->activeParticipants($room->streamId);
AntMedia::rooms()->activeParticipantsCount($room->streamId);
AntMedia::rooms()->removeParticipant($room->streamId, participantStreamId: 'patient_1024');

// Toplantıyı herkes için sonlandırın
AntMedia::rooms()->end($room->streamId);   // ana track'i ve alt track'leri durdurur
AntMedia::rooms()->delete($room->streamId); // odayı ve alt track'lerini siler
```

<a id="secure-access-tokens-jwt-one-time-token-totp"></a>

### Güvenli erişim token'ları (JWT, tek kullanımlık token, TOTP)

Kimin **yayın yapabileceğini** (publish: kamera / mikrofon) ve kimin **izleyebileceğini** (play) güvence altına alın.

```php
// JWT token (önerilen), ANT_MEDIA_STREAM_JWT_SECRET ile yerel olarak imzalanır, sunucuya ek istek gerekmez
$jwt = AntMedia::tokens()->jwt($streamId, type: 'play', expiresAt: now()->addHour());

// Bunun yerine Ant Media'ya imzalatın (ANT_MEDIA_STREAM_JWT_SECRET boşsa otomatik olarak da bu yol kullanılır)
$jwt = AntMedia::tokens()->jwt($streamId, type: 'play', expiresAt: now()->addHour(), fromServer: true);

// Ant Media Server tarafından üretilen tek kullanımlık token
$oneTime = AntMedia::tokens()->oneTime($streamId, type: 'publish', expiresAt: now()->addMinutes(30));

// Bir abone için TOTP
$totp = AntMedia::subscribers()->totp($streamId, subscriberId: 'user_42', type: 'publish');

AntMedia::tokens()->validate($token, $streamId, type: 'play');   // bool
AntMedia::tokens()->list($streamId);
AntMedia::tokens()->revokeAll($streamId);
```

<a id="recording-mp4--webm"></a>

### Toplantı kaydı (MP4 / WebM)

```php
AntMedia::recordings()->start($streamId, type: 'mp4', fileName: 'consultation_1024');
AntMedia::recordings()->stop($streamId, type: 'mp4');

// Bir HLS kaydını MP4'e dönüştürün
AntMedia::recordings()->hlsToMp4('stream_8f3a', deleteHlsFiles: true);
```

<a id="video-on-demand-vod"></a>

### İsteğe bağlı video (VoD)

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

### YouTube, Facebook, RTMP ve SRT'ye yeniden yayın

```php
$result = AntMedia::endpoints()->add($streamId, 'rtmp://a.rtmp.youtube.com/live2/YOUR-KEY');
$result->dataId;   // endpoint servis id'si
AntMedia::endpoints()->add($streamId, 'srt://ingest.example.com:9000', resolutionHeight: 720);

// Eklediğiniz URL ile veya endpoint servis id'si ile kaldırın
AntMedia::endpoints()->remove($streamId, 'rtmp://a.rtmp.youtube.com/live2/YOUR-KEY');
```

<a id="participants-and-subscribers"></a>

### Katılımcılar ve aboneler

```php
AntMedia::subscribers()->add($streamId, [
    'subscriberId' => 'user_42',
    'type' => 'publish',   // publish yetkisi play'i de kapsar (konferans için gereklidir)
]);

AntMedia::subscribers()->list($streamId, offset: 0, size: 50);
AntMedia::subscribers()->block($streamId, 'user_42', seconds: 600, type: 'publish_play');
AntMedia::subscribers()->delete($streamId, 'user_42');
AntMedia::subscribers()->revokeAll($streamId);
AntMedia::subscribers()->connectionEvents($streamId, offset: 0, size: 50);
```

<a id="data-channel-messages-in-meeting-chat"></a>

### Data channel mesajları (toplantı içi sohbet)

```php
AntMedia::broadcasts()->sendMessage($streamId, [
    'type' => 'chat',
    'from' => 'Dr. Ahmed',
    'text' => 'Please turn on your camera.',
]);
```

<a id="statistics-and-analytics"></a>

### İstatistikler ve analitik

```php
AntMedia::stats()->broadcast($streamId);        // WebRTC, HLS ve RTMP izleyici sayıları
AntMedia::stats()->total();                     // uygulama genelindeki toplam izleyici
AntMedia::stats()->webrtcClients($streamId);    // istemci başına ses / video bitrate'i
AntMedia::stats()->lowLevelSend();
AntMedia::stats()->lowLevelReceive();
```

<a id="ip-cameras-rtsp-and-onvif"></a>

### IP kameralar, RTSP ve ONVIF

```php
$camera = AntMedia::broadcasts()->create([
    'name' => 'Lobby Camera',
    'type' => 'ipCamera',
    'ipAddr' => '192.168.1.50',
    'username' => 'admin',
    'password' => 'secret',
], autoStart: true);

AntMedia::cameras()->discover();                       // ONVIF keşfi
AntMedia::cameras()->profiles($camera->streamId);
AntMedia::cameras()->move($camera->streamId, x: 0.2, y: 0, zoom: 0, movement: 'relative');
AntMedia::cameras()->stopMove($camera->streamId);
AntMedia::broadcasts()->start($camera->streamId);      // bir yayın kaynağını çekmeye (pull) başlayın
```

<a id="webhooks-and-laravel-events"></a>

### Webhook'lar ve Laravel event'leri

Ant Media'da **Application Settings > Webhook URL** ayarını şu adrese yönlendirin (route otomatik olarak kaydedilir):

```
https://your-app.com/ant-media/webhook?secret=ANT_MEDIA_WEBHOOK_SECRET
```

Yanlış `secret` içeren istekler HTTP 403 ile reddedilir. Ant Media webhook'u form verisi veya JSON olarak gönderebilir; ikisi de çalışır.

Yerel (native) Laravel event'lerini dinleyin:

```php
use AshrafBendary\WebRtcAntMedia\Events\LiveStreamStarted;
use AshrafBendary\WebRtcAntMedia\Events\LiveStreamEnded;
use AshrafBendary\WebRtcAntMedia\Events\RecordingReady;

Event::listen(LiveStreamStarted::class, fn ($e) => logger("Meeting started: {$e->streamId}"));
Event::listen(LiveStreamEnded::class,   fn ($e) => logger("Meeting ended: {$e->streamId}"));
Event::listen(RecordingReady::class,    fn ($e) => logger("Recording ready: {$e->vodId}"));

// Tüm webhook action'ları (playStarted, subtrackAddedInTheMainTrack, endpointFailed, ...)
use AshrafBendary\WebRtcAntMedia\Events\WebhookReceived;

Event::listen(WebhookReceived::class, fn ($e) => logger("{$e->action}: {$e->streamId}", $e->payload));
```

<a id="endpoints-that-are-not-wrapped"></a>

### Paketin sarmalamadığı uç noktalar

Diğer herhangi bir Ant Media uç noktasını alttaki client üzerinden çağırın (kimlik doğrulama, temel URL ve uygulama sizin için yönetilir):

```php
AntMedia::client()->get("broadcasts/{$streamId}/ip-camera-error");
AntMedia::client()->get('broadcasts/duration', ['url' => $sourceUrl]);
```

Başarısız her istek (HTTP 4xx / 5xx) `AshrafBendary\WebRtcAntMedia\Exceptions\AntMediaException` fırlatır; var olmayan bir yayın için `get()` çağrısı `null` döndürür.

<a id="rest-api-coverage"></a>

## REST API kapsamı

Tüm çağrılar `{ANT_MEDIA_ORIGIN_URL}/{ANT_MEDIA_APP}/rest/v2/...` adresini (veya test uygulamasını) hedefler. Şemaların tamamı: [Ant Media Swagger](https://antmedia.io/rest/).

| Paket metodu | HTTP | Ant Media uç noktası |
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

## Güvenlik, gizlilik ve mevzuat uyumu

Ant Media Server kendi sunucunuzda barındırıldığı için videoların ve kayıtların nerede saklanacağına siz karar verirsiniz. Bu durum, **veri yerelleştirme (data residency)** ve **GDPR**, Türkiye'deki **KVKK** (6698 sayılı Kişisel Verilerin Korunması Kanunu), **HIPAA**, **Suudi Arabistan PDPL**, BAE ve diğer ulusal veri koruma mevzuatları gibi gizlilik gerekliliklerini karşılamayı kolaylaştırır. Mevzuata uyum, yalnızca bu pakete değil, kurulumunuzun bütününe bağlıdır.

Önerilen kurulum:

- Ant Media Server'ı ihtiyaç duyduğunuz bölgede çalıştırın (örneğin AWS Middle East, Google Cloud Dammam, Oracle Cloud Jeddah, AB bölgeleri veya şirket içi/on-premise)
- Geçerli bir SSL sertifikasıyla `5443` portunda HTTPS kullanın
- **JWT REST API Filter** seçeneğini etkinleştirin; REST API'yi asla yalnızca IP kısıtlamasına güvenerek herkese açık hale getirmeyin
- Her toplantı için **publish / play token güvenliğini** etkinleştirin
- Token'lara kısa bir `exp` süresi verin ve toplantı bittiğinde token'ları ve aboneleri iptal edin
- Kayıtları şifrelenmiş depolama alanında saklayın ve bunlara kimin eriştiğini loglayın

<a id="using-this-package-with-ai-coding-assistants"></a>

## Bu paketi yapay zekâ kodlama asistanlarıyla kullanma

Uygulamanızı Claude, ChatGPT, Cursor, GitHub Copilot veya başka bir yapay zekâ asistanıyla mı geliştiriyorsunuz? Ona şunu söyleyin:

> "Ant Media Server ile kendi sunucumda barındırılan bir görüntülü toplantı uygulaması geliştirmek için `ashrafbendary/laravel-webrtc-ant-media` Laravel paketini kullan. Önce README ve llms.txt dosyalarını oku."

Bu depo, yapay zekâ ajanları için kullanım kurallarını içeren `llms.txt` ve `AGENTS.md` dosyalarını barındırır.

<a id="faq"></a>

## SSS

**Laravel ile Zoom klonu nasıl geliştirilir?**
Bu paketi kurun, Ant Media Server'ı çalıştırın, `AntMedia::rooms()->create()` ile bir oda oluşturun, her katılımcı için JWT token'ları üretin ve tarayıcıyı Ant Media WebRTC JavaScript SDK'sı ile bağlayın. Bkz. [Hızlı başlangıç](#quick-start-create-a-video-meeting-room).

**Bu ücretsiz bir Zoom alternatifi mi?**
Paket ücretsiz ve açık kaynaktır (MIT). Ant Media Server'ın ücretsiz bir Community Edition'ı ve ücretli bir Enterprise Edition'ı vardır. Çok katılımcılı video konferans ve büyük ölçekte ultra düşük gecikmeli WebRTC, Enterprise özellikleridir; bu nedenle kendi senaryonuz için Ant Media lisanslama koşullarını kontrol edin.

**Bu paketin P2P WebRTC paketlerinden farkı nedir?**
P2P, videoyu doğrudan tarayıcılar arasında gönderir ve 2 ila 3 kişi için çalışır. Bu paket bir medya sunucusu (SFU) kullanır; bu sayede büyük toplantıları, geniş kitlelere canlı yayını ve sunucu tarafı kaydı destekler.

**Tele tıp için kullanabilir miyim?**
Evet. Yaygın uzaktan sağlık özellikleri (güvenli odalar, kısa ömürlü token'lar, kayıt, kendi sunucunuzda tutulan veriler) karşılanmaktadır. Yine de kurulumunuzun bulunduğunuz yerdeki sağlık mevzuatına uygun olması gerekir.

**YouTube veya Facebook'a canlı yayını destekliyor mu?**
Evet, RTMP veya SRT ingest URL'si ile `AntMedia::endpoints()->add()` metodunu kullanın.

**Hangi frontend'ler destekleniyor?**
Web'de Blade, Livewire, Inertia, Vue, React ve saf JavaScript; ayrıca resmi Ant Media SDK'ları aracılığıyla React Native, Flutter, Android ve iOS.

**Laravel Octane, Horizon ve kuyruklarla (queue) çalışır mı?**
Evet. Tüm çağrılar Laravel HTTP client'ını kullanır ve job'lar içinde güvenle çalıştırılabilir.

**Ant Media Server küme (cluster) modunu destekliyor mu?**
Evet. `ANT_MEDIA_ORIGIN_URL` değerini origin sunucunuza (veya origin load balancer'ınıza), `ANT_MEDIA_EDGE_URL` değerini de edge load balancer'ınıza ayarlayın.

**StreamApp, conference-call-application'ın yerini mi alıyor?**
StreamApp güncel temel uygulamadır ve conference-call-application deposu arşivlenmiştir; ancak StreamApp onun tüm arayüz özelliklerine sahip değildir. Bkz. [StreamApp ve konferans uygulaması](#streamapp-and-the-conference-application).

**Canlı ortamdaki (production) yayınlara dokunmadan nasıl test ederim?**
`ANT_MEDIA_TEST_APP` değerini ayarlayın, ardından `AntMedia::test()` kullanın ya da yerel / staging `.env` dosyanızda `ANT_MEDIA_USE_TEST_APP=true` ayarlayın.

<a id="testing"></a>

## Test

```bash
composer test
```

Paket `Http::fake()` kullanır; bu nedenle testler hiçbir zaman gerçek bir medya sunucusuna istek göndermez.

<a id="contributing"></a>

## Katkıda bulunma

Pull request'ler memnuniyetle karşılanır. Büyük değişiklikler için lütfen önce bir issue açın ve yeni uç noktalar için test ekleyin.

<a id="credits"></a>

## Emeği geçenler

- [Ashraf Bendary](https://github.com/ashrafbendary)
- [Ant Media Server REST API](https://antmedia.io/rest/) üzerine inşa edilmiştir

<a id="license"></a>

## Lisans

MIT Lisansı (MIT). Bkz. [LICENSE](LICENSE).

---

**Anahtar kelimeler:** Laravel WebRTC, Laravel video konferans, Laravel görüntülü arama, Laravel görüntülü toplantı, Laravel Zoom klonu, Zoom alternatifi, Google Meet alternatifi, Microsoft Teams alternatifi, görüntülü konferans, video konferans, görüntülü toplantı, görüntülü arama, kendi sunucunda barındırma, self-hosted video konferans, Laravel canlı yayın, canlı yayın, toplantı kaydı, video kaydı, WebRTC PHP, Ant Media Server Laravel, WebRTC SFU, düşük gecikmeli yayın, tele tıp, uzaktan sağlık, tele tıp Laravel, uzaktan eğitim, e-öğrenme, sanal sınıf, webinar platformu, Laravel paketi, laravel webrtc, laravel video conference, laravel video call, laravel video meeting, laravel zoom clone, zoom alternative, google meet alternative, microsoft teams alternative, self-hosted video conferencing, laravel live streaming, webrtc php, ant media server, ant media laravel, antmedia php sdk, webrtc sfu, low latency streaming, hls, rtmp, srt, video recording, telemedicine laravel, telehealth video, elearning video, virtual classroom, webinar platform, laravel package
