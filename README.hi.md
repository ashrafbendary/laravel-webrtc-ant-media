# Laravel WebRTC Ant Media

[English](README.md) | [العربية](README.ar.md) | [اردو](README.ur.md) | **हिन्दी** | [Türkçe](README.tr.md) | [日本語](README.ja.md) | [简体中文](README.zh-CN.md)

### Laravel में Zoom, Google Meet या Microsoft Teams जैसा वीडियो मीटिंग ऐप बनाइए। Ant Media Server पर आधारित सेल्फ-होस्टेड, scalable WebRTC वीडियो कॉन्फ्रेंसिंग, लाइव स्ट्रीमिंग और मीटिंग रिकॉर्डिंग।

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](https://packagist.org/packages/ashrafbendary/laravel-webrtc-ant-media)
[![Total Downloads](https://img.shields.io/packagist/dt/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](https://packagist.org/packages/ashrafbendary/laravel-webrtc-ant-media)
[![PHP Version](https://img.shields.io/packagist/php-v/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](https://packagist.org/packages/ashrafbendary/laravel-webrtc-ant-media)
[![License](https://img.shields.io/packagist/l/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](LICENSE)

**Laravel WebRTC Ant Media** एक Laravel पैकेज (PHP SDK) है जो [Ant Media Server REST API](https://docs.antmedia.io/guides/developer-sdk-and-api/rest-api-guide/) के लिए बनाया गया है। इसकी मदद से कोई भी Laravel ऐप्लिकेशन एक साफ़-सुथरे Laravel facade के ज़रिए **वीडियो मीटिंग, वीडियो कॉल, वेबिनार, लाइव स्ट्रीम, टेलीमेडिसिन कंसल्टेशन और ऑनलाइन क्लास** बना सकता है, और वह भी Zoom, Twilio, Agora या Vonage को प्रति मिनट फ़ीस दिए बिना।

> यह एक अनौपचारिक (unofficial) कम्युनिटी पैकेज है। इसका Ant Media Inc. से कोई संबंध नहीं है। "Zoom", "Google Meet" और "Microsoft Teams" अपने-अपने मालिकों के ट्रेडमार्क हैं और इनका उल्लेख केवल तुलना के लिए किया गया है।

---

## विषय सूची

- [यह पैकेज क्यों](#why-this-package)
- [उपयोग के मामले (Use cases)](#use-cases)
- [फ़ीचर्स](#features)
- [तुलना](#how-it-compares)
- [आवश्यकताएँ](#requirements)
- [इंस्टॉलेशन](#installation)
- [कॉन्फ़िगरेशन](#configuration)
  - [Origin, edge, मुख्य ऐप और टेस्ट ऐप](#origin-edge-main-app-and-test-app)
  - [StreamApp और कॉन्फ्रेंस ऐप्लिकेशन](#streamapp-and-the-conference-application)
- [क्विक स्टार्ट: वीडियो मीटिंग रूम बनाइए](#quick-start-create-a-video-meeting-room)
- [उपयोग](#usage)
  - [फ़्रंटएंड URLs (WebSocket, HLS, प्लेयर)](#frontend-urls-websocket-hls-player)
  - [लाइव स्ट्रीम (ब्रॉडकास्ट)](#live-streams-broadcasts)
  - [वीडियो कॉन्फ्रेंस रूम (मल्टी-पार्टी मीटिंग)](#video-conference-rooms-multi-party-meetings)
  - [सुरक्षित एक्सेस टोकन (JWT, one-time token, TOTP)](#secure-access-tokens-jwt-one-time-token-totp)
  - [रिकॉर्डिंग (MP4 / WebM)](#recording-mp4--webm)
  - [वीडियो ऑन डिमांड (VoD)](#video-on-demand-vod)
  - [YouTube, Facebook, RTMP और SRT पर रीस्ट्रीम](#restream-to-youtube-facebook-rtmp-and-srt)
  - [प्रतिभागी और सब्सक्राइबर](#participants-and-subscribers)
  - [डेटा चैनल मैसेज (मीटिंग के अंदर चैट)](#data-channel-messages-in-meeting-chat)
  - [आँकड़े और एनालिटिक्स](#statistics-and-analytics)
  - [IP कैमरा, RTSP और ONVIF](#ip-cameras-rtsp-and-onvif)
  - [Webhooks और Laravel events](#webhooks-and-laravel-events)
- [REST API कवरेज](#rest-api-coverage)
- [सुरक्षा, प्राइवेसी और कंप्लायंस](#security-privacy-and-compliance)
- [AI कोडिंग असिस्टेंट के साथ इस पैकेज का उपयोग](#using-this-package-with-ai-coding-assistants)
- [अक्सर पूछे जाने वाले सवाल (FAQ)](#faq)
- [टेस्टिंग](#testing)
- [योगदान](#contributing)
- [श्रेय](#credits)
- [लाइसेंस](#license)

---

<a id="why-this-package"></a>

## यह पैकेज क्यों

ज़्यादातर Laravel वीडियो कॉल पैकेज **peer-to-peer (P2P) WebRTC** पर चलते हैं। P2P 2 या 3 लोगों तक ठीक काम करता है, फिर टूट जाता है: हर प्रतिभागी को हर दूसरे प्रतिभागी को वीडियो अपलोड करना पड़ता है।

यह पैकेज **Ant Media Server को WebRTC SFU / मीडिया सर्वर** के रूप में इस्तेमाल करता है, इसलिए आपको मिलता है:

- **Scalable वीडियो कॉन्फ्रेंसिंग**, एक ही रूम में कई प्रतिभागियों के साथ
- बड़ी ऑडियंस के लिए **अल्ट्रा-लो लेटेंसी लाइव स्ट्रीमिंग** (WebRTC, लगभग 0.5 सेकंड)
- MP4 या WebM में **सर्वर-साइड रिकॉर्डिंग**
- एक ही प्लेटफ़ॉर्म में **HLS, RTMP, SRT और WebRTC**
- अपने सर्वर या क्लाउड (AWS, Google Cloud, Azure, Oracle Cloud, on-premise) पर **सेल्फ-होस्टेड**, ताकि आपका वीडियो डेटा कभी आपके इंफ्रास्ट्रक्चर से बाहर न जाए

<a id="use-cases"></a>

## उपयोग के मामले (Use cases)

| उपयोग का मामला | आप क्या बना सकते हैं |
|---|---|
| **टेलीमेडिसिन / टेलीहेल्थ** | डॉक्टर और मरीज़ के बीच वीडियो कंसल्टेशन, वर्चुअल क्लिनिक, रिमोट सेकंड ओपिनियन |
| **ई-लर्निंग / ऑनलाइन शिक्षा** | वर्चुअल क्लासरूम, लाइव लेक्चर, LMS वीडियो रूम, रिकॉर्डेड कोर्स |
| **वेबिनार और वर्चुअल इवेंट** | इंटरैक्टिव प्रेज़ेंटर्स के साथ one-to-many लाइव ब्रॉडकास्ट |
| **टीम मीटिंग** | आपकी कंपनी के लिए सेल्फ-होस्टेड Zoom का विकल्प, Google Meet का विकल्प और Microsoft Teams का विकल्प |
| **कस्टमर सपोर्ट** | वीडियो कॉल सपोर्ट, वीडियो KYC, रिमोट इंस्पेक्शन |
| **लाइव कॉमर्स** | रियल-टाइम चैट के साथ लाइव शॉपिंग स्ट्रीम |
| **सर्विलांस** | Laravel के अंदर IP कैमरा (RTSP / ONVIF) लाइव व्यू और रिकॉर्डिंग |
| **सोशल और क्रिएटर ऐप्स** | लाइव स्ट्रीमिंग, go-live फ़ीचर्स, YouTube और Facebook पर रीस्ट्रीम |

<a id="features"></a>

## फ़ीचर्स

- Laravel facade, service container binding और auto-discovery
- **Origin और edge सर्वर** के साथ **मुख्य ऐप और टेस्ट ऐप**, सब कुछ `.env` से
- तैयार फ़्रंटएंड URLs (publish/play WebSocket, HLS, एम्बेडेड प्लेयर, RTMP)
- **लाइव स्ट्रीम (ब्रॉडकास्ट)** बनाना, अपडेट करना, लिस्ट करना, शुरू करना, रोकना और डिलीट करना
- Ant Media main track और subtracks पर आधारित **वीडियो कॉन्फ्रेंस रूम**
- publish और play के लिए **JWT**, **one-time token** और **TOTP** स्ट्रीम सिक्योरिटी
- **JWT REST API ऑथेंटिकेशन** (HS256) अपने-आप हैंडल होता है
- हर स्ट्रीम के लिए **रिकॉर्डिंग** शुरू और बंद करना (MP4 या WebM), HLS को MP4 में बदलना
- **VoD** मैनेजमेंट: रिकॉर्डिंग अपलोड, इम्पोर्ट, लिस्ट और डिलीट करना
- RTMP और SRT endpoints पर **रीस्ट्रीम / मल्टीस्ट्रीम** (YouTube Live, Facebook Live, Twitch, LinkedIn Live)
- **सब्सक्राइबर मैनेजमेंट**: प्रतिभागियों को जोड़ना, लिस्ट करना, ब्लॉक करना और एक्सेस रद्द (revoke) करना
- मीटिंग के अंदर चैट, रिएक्शन और सिग्नल के लिए **WebRTC data channel** मैसेज
- **लाइव आँकड़े**: दर्शक (WebRTC, HLS, RTMP), bitrate, क्लाइंट स्टैट्स, कनेक्शन इवेंट
- **IP कैमरा** सपोर्ट: RTSP pull, ONVIF discovery, PTZ move
- स्ट्रीम सोर्स के लिए **प्लेलिस्ट** और seek कंट्रोल
- **Webhook receiver** जो native Laravel events फ़ायर करता है
- Typed DTOs, Laravel HTTP client, retry और timeout कॉन्फ़िगरेशन
- **Laravel 11, 12 और 13**, PHP 8.2+ के साथ काम करता है
- Ant Media के JavaScript, React, React Native, Flutter, Android और iOS WebRTC SDKs के साथ जोड़ा जा सकता है

<a id="how-it-compares"></a>

## तुलना

| | यह पैकेज | Zoom / Google Meet / Teams | Twilio / Agora / Vonage | P2P Laravel WebRTC पैकेज |
|---|---|---|---|---|
| सेल्फ-होस्टेड | हाँ | नहीं | नहीं | हाँ |
| डेटा आपके सर्वर पर रहता है | हाँ | नहीं | नहीं | हाँ |
| प्रति मिनट फ़ीस | नहीं | सब्सक्रिप्शन | हाँ | नहीं |
| बड़ी मीटिंग (SFU) | हाँ | हाँ | हाँ | नहीं (2 से 3 यूज़र) |
| हज़ारों दर्शकों तक लाइव स्ट्रीमिंग | हाँ | सीमित | अतिरिक्त लागत | नहीं |
| सर्वर-साइड रिकॉर्डिंग | हाँ | हाँ | अतिरिक्त लागत | नहीं |
| आपके Laravel ऐप में एम्बेडेड | हाँ | सीमित | हाँ | हाँ |
| White label / आपकी अपनी ब्रांडिंग | हाँ | नहीं | हाँ | हाँ |

<a id="requirements"></a>

## आवश्यकताएँ

- PHP **8.2** या उससे ऊपर
- Laravel **11.x, 12.x या 13.x**
- एक चालू **Ant Media Server** (Community या Enterprise Edition)। देखें [Ant Media quick start](https://docs.antmedia.io/quick-start/)।

<a id="installation"></a>

## इंस्टॉलेशन

```bash
composer require ashrafbendary/laravel-webrtc-ant-media
```

इंस्टॉलर चलाइए (यह config फ़ाइल पब्लिश करता है और `.env` keys प्रिंट करता है; webhook route अपने-आप रजिस्टर हो जाता है):

```bash
php artisan webrtc-ant-media:install
```

या config को मैन्युअली पब्लिश कीजिए:

```bash
php artisan vendor:publish --tag="webrtc-ant-media-config"
```

<a id="configuration"></a>

## कॉन्फ़िगरेशन

इन्हें अपनी `.env` में जोड़िए:

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

| Key | विवरण |
|---|---|
| `ANT_MEDIA_ORIGIN_URL` | Origin सर्वर का URL। सभी REST कॉल और WebRTC publishing यहीं जाती हैं। HTTPS के लिए पोर्ट `5443` और HTTP के लिए `5080` (सिर्फ़ लोकल) इस्तेमाल करें। `ANT_MEDIA_URL` अब भी alias के रूप में स्वीकार किया जाता है |
| `ANT_MEDIA_EDGE_URL` | वैकल्पिक edge सर्वर या edge load balancer, playback URLs के लिए इस्तेमाल होता है। ख़ाली = origin |
| `ANT_MEDIA_APP` | मुख्य ऐप्लिकेशन का नाम, जैसे `LiveApp`, `WebRTCAppEE`, `live` या StreamApp से बना आपका कस्टम ऐप |
| `ANT_MEDIA_TEST_APP` | टेस्ट स्ट्रीम के लिए वैकल्पिक दूसरा ऐप्लिकेशन, जिसे `AntMedia::test()` इस्तेमाल करता है |
| `ANT_MEDIA_USE_TEST_APP` | `true` होने पर हर कॉल टेस्ट ऐप पर जाती है (लोकल / staging में काम का) |
| `ANT_MEDIA_JWT_SECRET` | **Application Settings > JWT REST API Filter** से मिला secret (HS256) |
| `ANT_MEDIA_STREAM_JWT_SECRET` | publish / play स्ट्रीम टोकन साइन करने के लिए secret |
| `ANT_MEDIA_TIMEOUT` | सेकंड में HTTP timeout |
| `ANT_MEDIA_RETRIES` | फ़ेल हुई GET रिक्वेस्ट के लिए retries (POST / PUT / DELETE कभी retry नहीं होतीं)। डिफ़ॉल्ट `1` |
| `ANT_MEDIA_WEBHOOK_SECRET` | **ज़रूरी।** webhook URL में दिया जाने वाला shared secret। जब तक यह ख़ाली है, हर webhook अस्वीकार कर दिया जाता है |
| `ANT_MEDIA_WEBHOOK_ALLOWED_IPS` | वैकल्पिक, सुझाया गया। आपके Ant Media सर्वर्स के IPs या CIDRs, कॉमा से अलग किए हुए; किसी भी दूसरे IP से आने वाले webhooks अस्वीकार कर दिए जाते हैं। load balancer के पीछे होने पर पहले Laravel trusted proxies कॉन्फ़िगर कीजिए |

वैकल्पिक टेस्ट-ऐप overrides (हर एक न होने पर मुख्य वैल्यू इस्तेमाल होती है): `ANT_MEDIA_TEST_ORIGIN_URL`, `ANT_MEDIA_TEST_EDGE_URL`, `ANT_MEDIA_TEST_JWT_SECRET`, `ANT_MEDIA_TEST_STREAM_JWT_SECRET`।

**ऑथेंटिकेशन।** डिफ़ॉल्ट रूप से Ant Media ऐप्लिकेशन के REST endpoints सिर्फ़ `127.0.0.1` से रिक्वेस्ट स्वीकार करते हैं (IP filter)। अगर आपका Laravel बैकएंड रिमोट है, तो Ant Media वेब पैनल में **JWT REST API Filter** चालू कीजिए और ऊपर वाला secret सेट कीजिए। पैकेज `exp` claim के साथ एक कम समय तक वैध HS256 टोकन साइन करता है और उसे हर रिक्वेस्ट में `Authorization: Bearer {token}` के रूप में भेजता है।

<a id="origin-edge-main-app-and-test-app"></a>

### Origin, edge, मुख्य ऐप और टेस्ट ऐप

```php
use AshrafBendary\WebRtcAntMedia\Facades\AntMedia;

AntMedia::broadcasts()->create(['name' => 'Live']);          // मुख्य ऐप (ANT_MEDIA_APP)
AntMedia::test()->broadcasts()->create(['name' => 'Try']);   // टेस्ट ऐप (ANT_MEDIA_TEST_APP)
AntMedia::main()->broadcasts()->list();                      // मुख्य ऐप, भले ही ANT_MEDIA_USE_TEST_APP=true हो
AntMedia::app('WebRTCAppEE')->broadcasts()->count();         // उन्हीं सर्वरों पर कोई भी दूसरा ऐप

AntMedia::appName();   // "LiveApp" (या ANT_MEDIA_USE_TEST_APP=true होने पर टेस्ट ऐप)
```

- REST API कॉल और WebRTC **publishing** हमेशा **origin** सर्वर का इस्तेमाल करती हैं।
- **Playback** URLs (WebRTC play, HLS, एम्बेडेड प्लेयर, रिकॉर्डिंग) **edge** सर्वर का इस्तेमाल करते हैं, या edge सेट न होने पर origin का।

<a id="streamapp-and-the-conference-application"></a>

### StreamApp और कॉन्फ्रेंस ऐप्लिकेशन

पुरानी [conference-call-application](https://github.com/ant-media/conference-call-application) (Circle) रिपॉज़िटरी 31 अगस्त 2026 को archive कर दी गई। [StreamApp](https://github.com/ant-media/StreamApp) अब Ant Media Server का मौजूदा base ऐप्लिकेशन है: डिफ़ॉल्ट ऐप्स (`LiveApp`, `WebRTCAppEE`, `live`) और कस्टम ऐप्स इसी से बनते हैं, और इसके साथ कॉन्फ्रेंस सैंपल (`conference.html`, `multitrack-conference.html`) आते हैं।

StreamApp, Circle UI का फ़ीचर-दर-फ़ीचर विकल्प **नहीं** है: इसका कॉन्फ्रेंस पेज join/leave, publish/play, स्क्रीन शेयर, mute और कैमरा टॉगल तथा data channel चैट कवर करता है, लेकिन इसमें तैयार रिकॉर्डिंग बटन, वेटिंग रूम, कॉन्फ्रेंस पेज में वर्चुअल बैकग्राउंड, रिएक्शन, प्रतिभागियों की सूची, pinning, ब्रेकआउट रूम या वेबिनार/मॉडरेशन UI नहीं है। यह पैकेज इनमें से किसी भी UI पर निर्भर नहीं है: यह Ant Media REST API से बात करता है, जो हर ऐप्लिकेशन के लिए एक जैसी है, इसलिए `ANT_MEDIA_APP` को अपने StreamApp-आधारित ऐप पर सेट कीजिए और अपनी ज़रूरत का मीटिंग UI बनाइए।

<a id="quick-start-create-a-video-meeting-room"></a>

## क्विक स्टार्ट: वीडियो मीटिंग रूम बनाइए

```php
use AshrafBendary\WebRtcAntMedia\Facades\AntMedia;

// 1. मीटिंग रूम बनाइए
$room = AntMedia::rooms()->create(name: 'Weekly Team Meeting');

// 2. हर प्रतिभागी को एक सुरक्षित publish + play टोकन दीजिए (2 घंटे तक वैध)
$token = AntMedia::tokens()->jwt(
    streamId: $room->streamId,
    type: 'publish',
    expiresAt: now()->addHours(2),
    roomId: $room->streamId,
);

// 3. $room->streamId और $token को अपने Blade / Vue / React view में Ant Media WebRTC JavaScript SDK को पास कीजिए
return view('meeting', compact('room', 'token'));
```

या फ़्रंटएंड को जो कुछ चाहिए, वह सब JSON के रूप में लौटाइए (कोई secret नहीं):

```php
return response()->json(AntMedia::urls()->forClient($room->streamId, $token));
// { streamId, token, app, publishWebSocketUrl, playWebSocketUrl, hlsUrl }
```

Zoom जैसे मीटिंग रूम के लिए पूरा बैकएंड बस इतना ही है। ब्राउज़र की तरफ़ आधिकारिक [Ant Media WebRTC JavaScript SDK](https://docs.antmedia.io/guides/developer-sdk-and-api/sdk-integration/) इस्तेमाल होता है।

<a id="usage"></a>

## उपयोग

<a id="frontend-urls-websocket-hls-player"></a>

### फ़्रंटएंड URLs (WebSocket, HLS, प्लेयर)

```php
AntMedia::urls()->publishWebSocket();              // wss://origin.example.com:5443/LiveApp/websocket
AntMedia::urls()->playWebSocket();                 // wss://edge.example.com:5443/LiveApp/websocket
AntMedia::urls()->hls($streamId, $token);          // https://edge.../LiveApp/streams/{id}.m3u8?token=...
AntMedia::urls()->player($streamId, $token);       // https://edge.../LiveApp/play.html?id=...&token=...
AntMedia::urls()->recording('stream1.mp4');        // https://edge.../LiveApp/streams/stream1.mp4
AntMedia::urls()->rtmp($streamId);                 // rtmp://origin.example.com/LiveApp/{id} (OBS)
AntMedia::urls()->forClient($streamId, $token);    // आपके JS के लिए array: streamId, token, WebSocket और HLS URLs
AntMedia::test()->urls()->playWebSocket();         // टेस्ट ऐप के लिए वही helpers
```

<a id="live-streams-broadcasts"></a>

### लाइव स्ट्रीम (ब्रॉडकास्ट)

```php
use AshrafBendary\WebRtcAntMedia\Facades\AntMedia;

$stream = AntMedia::broadcasts()->create([
    'name' => 'Product Launch Live',
    'description' => 'Live product launch event',
]);

$stream->streamId;   // उदाहरण: "stream_8f3a..."
$stream->rtmpURL;    // OBS के लिए RTMP ingest URL

AntMedia::broadcasts()->get($stream->streamId);
AntMedia::broadcasts()->list(offset: 0, size: 50, type: 'liveStream', sortBy: 'date', order: 'desc');
AntMedia::broadcasts()->update($stream->streamId, ['name' => 'New title']);
AntMedia::broadcasts()->stop($stream->streamId);
AntMedia::broadcasts()->delete($stream->streamId);
$stream->isLive();                                  // status === "broadcasting"
$stream->get('hlsViewerCount');                     // Ant Media का कोई भी दूसरा फ़ील्ड
AntMedia::broadcasts()->deleteMany(['id1', 'id2']);
AntMedia::broadcasts()->count();
AntMedia::broadcasts()->activeCount();
AntMedia::broadcasts()->info($stream->streamId);   // width, height, bitrate, codec
```

<a id="video-conference-rooms-multi-party-meetings"></a>

### वीडियो कॉन्फ्रेंस रूम (मल्टी-पार्टी मीटिंग)

एक मीटिंग रूम एक main track होता है। हर प्रतिभागी एक subtrack पब्लिश करता है।

```php
$room = AntMedia::rooms()->create(name: 'Consultation 7f3c2a');
$room = AntMedia::rooms()->create(name: 'Class 7A', streamId: 'class-7a');   // अपनी पसंद का रूम id चुनिए
AntMedia::rooms()->get('class-7a');

AntMedia::rooms()->addParticipant($room->streamId, participantStreamId: 'p_9b41e2');
AntMedia::rooms()->participants($room->streamId, offset: 0, size: 50);
AntMedia::rooms()->activeParticipants($room->streamId);
AntMedia::rooms()->activeParticipantsCount($room->streamId);
AntMedia::rooms()->removeParticipant($room->streamId, participantStreamId: 'p_9b41e2');

// सभी के लिए मीटिंग समाप्त कीजिए
AntMedia::rooms()->end($room->streamId);   // main track और subtracks को रोक देता है
AntMedia::rooms()->delete($room->streamId); // रूम और उसके subtracks को डिलीट कर देता है
```

<a id="secure-access-tokens-jwt-one-time-token-totp"></a>

### सुरक्षित एक्सेस टोकन (JWT, one-time token, TOTP)

तय कीजिए कि कौन **publish** (कैमरा / माइक) कर सकता है और कौन **play** (देख) सकता है।

```php
// JWT टोकन (सुझाया गया), ANT_MEDIA_STREAM_JWT_SECRET से लोकली साइन होता है, सर्वर तक round trip की ज़रूरत नहीं
$jwt = AntMedia::tokens()->jwt($streamId, type: 'play', expiresAt: now()->addHour());

// इसकी जगह Ant Media से साइन करवाइए (ANT_MEDIA_STREAM_JWT_SECRET ख़ाली होने पर यह अपने-आप भी इस्तेमाल होता है)
$jwt = AntMedia::tokens()->jwt($streamId, type: 'play', expiresAt: now()->addHour(), fromServer: true);

// Ant Media Server द्वारा जनरेट किया गया one-time टोकन
$oneTime = AntMedia::tokens()->oneTime($streamId, type: 'publish', expiresAt: now()->addMinutes(30));

// किसी सब्सक्राइबर के लिए TOTP
$totp = AntMedia::subscribers()->totp($streamId, subscriberId: 'user_42', type: 'publish');

AntMedia::tokens()->validate($token, $streamId, type: 'play');   // bool
AntMedia::tokens()->list($streamId);
AntMedia::tokens()->revokeAll($streamId);
```

<a id="recording-mp4--webm"></a>

### रिकॉर्डिंग (MP4 / WebM)

```php
AntMedia::recordings()->start($streamId, type: 'mp4', fileName: 'rec_7f3c2a');
AntMedia::recordings()->stop($streamId, type: 'mp4');

// HLS रिकॉर्डिंग को MP4 में बदलिए
AntMedia::recordings()->hlsToMp4('stream_8f3a', deleteHlsFiles: true);
```

<a id="video-on-demand-vod"></a>

### वीडियो ऑन डिमांड (VoD)

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

### YouTube, Facebook, RTMP और SRT पर रीस्ट्रीम

```php
$result = AntMedia::endpoints()->add($streamId, 'rtmp://a.rtmp.youtube.com/live2/YOUR-KEY');
$result->dataId;   // endpoint service id
AntMedia::endpoints()->add($streamId, 'srt://ingest.example.com:9000', resolutionHeight: 720);

// जोड़े गए URL से या endpoint service id से हटाइए
AntMedia::endpoints()->remove($streamId, 'rtmp://a.rtmp.youtube.com/live2/YOUR-KEY');
```

<a id="participants-and-subscribers"></a>

### प्रतिभागी और सब्सक्राइबर

```php
AntMedia::subscribers()->add($streamId, [
    'subscriberId' => 'user_42',
    'type' => 'publish',   // publish वाला play भी कर सकता है (कॉन्फ्रेंसिंग के लिए ज़रूरी)
]);

AntMedia::subscribers()->list($streamId, offset: 0, size: 50);
AntMedia::subscribers()->block($streamId, 'user_42', seconds: 600, type: 'publish_play');
AntMedia::subscribers()->delete($streamId, 'user_42');
AntMedia::subscribers()->revokeAll($streamId);
AntMedia::subscribers()->connectionEvents($streamId, offset: 0, size: 50);
```

<a id="data-channel-messages-in-meeting-chat"></a>

### डेटा चैनल मैसेज (मीटिंग के अंदर चैट)

```php
AntMedia::broadcasts()->sendMessage($streamId, [
    'type' => 'chat',
    'from' => 'Dr. Ahmed',
    'text' => 'Please turn on your camera.',
]);
```

<a id="statistics-and-analytics"></a>

### आँकड़े और एनालिटिक्स

```php
AntMedia::stats()->broadcast($streamId);        // WebRTC, HLS और RTMP दर्शकों की संख्या
AntMedia::stats()->total();                     // पूरे ऐप में कुल दर्शक
AntMedia::stats()->webrtcClients($streamId);    // हर क्लाइंट का ऑडियो / वीडियो bitrate
AntMedia::stats()->lowLevelSend();
AntMedia::stats()->lowLevelReceive();
```

<a id="ip-cameras-rtsp-and-onvif"></a>

### IP कैमरा, RTSP और ONVIF

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
AntMedia::broadcasts()->start($camera->streamId);      // स्ट्रीम सोर्स से pull करना शुरू करता है
```

<a id="webhooks-and-laravel-events"></a>

### Webhooks और Laravel events

Ant Media में **Application Settings > Webhook URL** को इस पते पर सेट कीजिए (route अपने-आप रजिस्टर हो जाता है):

```
https://your-app.com/ant-media/webhook?secret=ANT_MEDIA_WEBHOOK_SECRET
```

ग़लत या ग़ायब `secret` वाली रिक्वेस्ट, या `ANT_MEDIA_WEBHOOK_ALLOWED_IPS` (अगर सेट हो) से बाहर के IP से आने वाली रिक्वेस्ट, HTTP 403 के साथ अस्वीकार कर दी जाती हैं। Ant Media webhooks को साइन नहीं करता, इसलिए दोनों सेट कीजिए। Ant Media webhook को form data या JSON के रूप में भेज सकता है; दोनों काम करते हैं।

native Laravel events को सुनिए:

```php
use AshrafBendary\WebRtcAntMedia\Events\LiveStreamStarted;
use AshrafBendary\WebRtcAntMedia\Events\LiveStreamEnded;
use AshrafBendary\WebRtcAntMedia\Events\RecordingReady;

Event::listen(LiveStreamStarted::class, fn ($e) => logger("Meeting started: {$e->streamId}"));
Event::listen(LiveStreamEnded::class,   fn ($e) => logger("Meeting ended: {$e->streamId}"));
Event::listen(RecordingReady::class,    fn ($e) => logger("Recording ready: {$e->vodId}"));

// हर webhook action (playStarted, subtrackAddedInTheMainTrack, endpointFailed, ...)
use AshrafBendary\WebRtcAntMedia\Events\WebhookReceived;

Event::listen(WebhookReceived::class, fn ($e) => logger("{$e->action}: {$e->streamId}"));
```

<a id="endpoints-that-are-not-wrapped"></a>

### वे endpoints जो wrap नहीं किए गए हैं

किसी भी दूसरे Ant Media endpoint को underlying client के ज़रिए कॉल कीजिए (auth, base URL और ऐप आपके लिए अपने-आप हैंडल होते हैं):

```php
AntMedia::client()->get("broadcasts/{$streamId}/ip-camera-error");
AntMedia::client()->get('broadcasts/duration', ['url' => $sourceUrl]);
```

हर फ़ेल रिक्वेस्ट (HTTP 4xx / 5xx) `AshrafBendary\WebRtcAntMedia\Exceptions\AntMediaException` थ्रो करती है; किसी ऐसी स्ट्रीम का `get()` जो मौजूद नहीं है, `null` लौटाता है।

<a id="rest-api-coverage"></a>

## REST API कवरेज

सभी कॉल `{ANT_MEDIA_ORIGIN_URL}/{ANT_MEDIA_APP}/rest/v2/...` (या टेस्ट ऐप) पर जाती हैं। पूरे schemas: [Ant Media Swagger](https://antmedia.io/rest/)।

| पैकेज मेथड | HTTP | Ant Media endpoint |
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

## सुरक्षा, प्राइवेसी और कंप्लायंस

चूँकि Ant Media Server सेल्फ-होस्टेड है, इसलिए वीडियो और रिकॉर्डिंग कहाँ स्टोर होंगी, यह आप तय करते हैं। इससे **data residency** और प्राइवेसी की ज़रूरतें पूरी करना आसान हो जाता है, जैसे **GDPR**, **HIPAA**, **Saudi PDPL**, UAE और अन्य देशों के डेटा प्रोटेक्शन क़ानून। कंप्लायंस आपकी पूरी डिप्लॉयमेंट पर निर्भर करता है, सिर्फ़ इस पैकेज पर नहीं।

सुझाया गया सेटअप:

- Ant Media Server को उस रीजन में चलाइए जो आपका डेटा क़ानून माँगता है। सऊदी पर्सनल और हेल्थ डेटा के लिए KSA रीजन इस्तेमाल कीजिए (जैसे Google Cloud Dammam, Oracle Cloud Jeddah या on-premise; AWS Saudi Arabia रीजन दिसंबर 2026 के लिए प्लान किया गया है)। AWS Bahrain और UAE, KSA से बाहर हैं, इसलिए उन्हें इस्तेमाल करना PDPL के तहत cross-border transfer है। EU डेटा के लिए EU रीजन इस्तेमाल कीजिए
- वैध SSL सर्टिफ़िकेट के साथ पोर्ट `5443` पर HTTPS इस्तेमाल कीजिए
- **JWT REST API Filter** चालू कीजिए; REST API को सिर्फ़ IP के भरोसे कभी पब्लिक मत कीजिए
- हर मीटिंग के लिए स्ट्रीम की **publish / play टोकन सिक्योरिटी** चालू कीजिए
- टोकन को छोटा `exp` दीजिए, और मीटिंग ख़त्म होने पर टोकन और सब्सक्राइबर्स को revoke कीजिए
- रिकॉर्डिंग को एन्क्रिप्टेड स्टोरेज में रखिए और लॉग कीजिए कि किसने उन्हें एक्सेस किया
- रिकॉर्डिंग शुरू करने से पहले प्रतिभागी की सहमति (उद्देश्य, वर्ज़न, timestamp) रिकॉर्ड कीजिए, रैंडम फ़ाइल नाम इस्तेमाल कीजिए, और retention शेड्यूल के अनुसार रिकॉर्डिंग डिलीट कीजिए
- रिकॉर्डिंग की लिस्टिंग या डाउनलोड को एक अलग, लॉग की जाने वाली permission बनाइए, और पक्का कीजिए कि play टोकन सिक्योरिटी रिकॉर्डिंग URLs (`/{app}/streams/...`) को भी कवर करती है
- मरीज़ों या छात्रों के नाम और IDs को स्ट्रीम नामों, स्ट्रीम IDs और फ़ाइल नामों से बाहर रखिए; रैंडम IDs इस्तेमाल कीजिए और उन्हें अपने डेटाबेस में मैप कीजिए
- रिक्वेस्ट इनपुट को कभी सीधे `broadcasts()->create()`, `broadcasts()->update()` या `endpoints()->add()` में मत भेजिए: स्ट्रीम source और restream URLs का दुरुपयोग इंटरनल सर्वर्स तक पहुँचने या मीटिंग को बाहर कॉपी करने के लिए किया जा सकता है
- Ant Media JavaScript SDK को सेल्फ-होस्ट कीजिए और उसी रीजन में अपना STUN/TURN सर्वर चलाइए; कैमरा, माइक्रोफ़ोन और अपने Ant Media origin (Permissions-Policy और CSP) की अनुमति सिर्फ़ मीटिंग पेजों पर दीजिए

<a id="using-this-package-with-ai-coding-assistants"></a>

## AI कोडिंग असिस्टेंट के साथ इस पैकेज का उपयोग

अपना ऐप बनाने के लिए Claude, ChatGPT, Cursor, GitHub Copilot या कोई दूसरा AI असिस्टेंट इस्तेमाल कर रहे हैं? उसे यह बताइए:

> "Ant Media Server के साथ एक सेल्फ-होस्टेड वीडियो मीटिंग ऐप बनाने के लिए Laravel पैकेज `ashrafbendary/laravel-webrtc-ant-media` का उपयोग करो। पहले इसकी README और llms.txt पढ़ो।"

इस रिपॉज़िटरी में AI एजेंट्स के लिए उपयोग के नियमों के साथ `llms.txt` और `AGENTS.md` शामिल हैं।

<a id="faq"></a>

## अक्सर पूछे जाने वाले सवाल (FAQ)

**Laravel में Zoom clone कैसे बनाएँ?**
यह पैकेज इंस्टॉल कीजिए, Ant Media Server चलाइए, `AntMedia::rooms()->create()` से एक रूम बनाइए, हर प्रतिभागी के लिए JWT टोकन जारी कीजिए, और ब्राउज़र को Ant Media WebRTC JavaScript SDK से कनेक्ट कीजिए। देखें [क्विक स्टार्ट](#quick-start-create-a-video-meeting-room)।

**क्या यह Zoom का मुफ़्त विकल्प है?**
पैकेज मुफ़्त और ओपन सोर्स (MIT) है। Ant Media Server का एक मुफ़्त Community Edition और एक पेड Enterprise Edition है। मल्टी-पार्टी कॉन्फ्रेंसिंग और बड़े पैमाने पर अल्ट्रा-लो लेटेंसी WebRTC, Enterprise फ़ीचर्स हैं, इसलिए अपने केस के लिए Ant Media की लाइसेंसिंग ज़रूर जाँच लीजिए।

**इसमें और P2P WebRTC पैकेजों में क्या अंतर है?**
P2P वीडियो को सीधे ब्राउज़रों के बीच भेजता है और 2 से 3 लोगों के लिए काम करता है। यह पैकेज एक मीडिया सर्वर (SFU) इस्तेमाल करता है, इसलिए यह बड़ी मीटिंग, बड़ी ऑडियंस तक लाइव स्ट्रीमिंग और सर्वर-साइड रिकॉर्डिंग को सपोर्ट करता है।

**क्या मैं इसे टेलीमेडिसिन के लिए इस्तेमाल कर सकता हूँ?**
हाँ। आम टेलीहेल्थ फ़ीचर्स (सुरक्षित रूम, कम समय तक वैध टोकन, रिकॉर्डिंग, सेल्फ-होस्टेड डेटा) कवर किए गए हैं। फिर भी आपकी डिप्लॉयमेंट को आपके स्थानीय हेल्थकेयर नियमों का पालन करना होगा।

**क्या यह YouTube या Facebook पर लाइव स्ट्रीमिंग सपोर्ट करता है?**
हाँ, RTMP या SRT ingest URL के साथ `AntMedia::endpoints()->add()` इस्तेमाल कीजिए।

**कौन-से फ़्रंटएंड सपोर्टेड हैं?**
वेब पर Blade, Livewire, Inertia, Vue, React और plain JavaScript, साथ ही आधिकारिक Ant Media SDKs के ज़रिए React Native, Flutter, Android और iOS।

**क्या यह Laravel Octane, Horizon और queues के साथ काम करता है?**
हाँ। सभी कॉल Laravel HTTP client का उपयोग करती हैं और jobs में चलाने के लिए सुरक्षित हैं।

**क्या यह Ant Media Server cluster mode को सपोर्ट करता है?**
हाँ। `ANT_MEDIA_ORIGIN_URL` को अपने origin (या origin load balancer) पर और `ANT_MEDIA_EDGE_URL` को अपने edge load balancer पर सेट कीजिए।

**क्या StreamApp, conference-call-application की जगह लेता है?**
StreamApp मौजूदा base ऐप है और conference-call-application रिपॉज़िटरी archive हो चुकी है, लेकिन StreamApp में उसके सभी UI फ़ीचर्स नहीं हैं। देखें [StreamApp और कॉन्फ्रेंस ऐप्लिकेशन](#streamapp-and-the-conference-application)।

**प्रोडक्शन स्ट्रीम को छुए बिना टेस्ट कैसे करें?**
`ANT_MEDIA_TEST_APP` सेट कीजिए, फिर `AntMedia::test()` इस्तेमाल कीजिए, या अपनी लोकल / staging `.env` में `ANT_MEDIA_USE_TEST_APP=true` सेट कीजिए।

<a id="testing"></a>

## टेस्टिंग

```bash
composer test
```

पैकेज `Http::fake()` का उपयोग करता है, इसलिए टेस्ट कभी किसी असली मीडिया सर्वर को कॉल नहीं करते।

<a id="contributing"></a>

## योगदान

Pull requests का स्वागत है। बड़े बदलावों के लिए कृपया पहले एक issue खोलिए और नए endpoints के लिए टेस्ट जोड़िए।

<a id="credits"></a>

## श्रेय

- [Ashraf Bendary](https://github.com/ashrafbendary)
- [Ant Media Server REST API](https://antmedia.io/rest/) पर आधारित

<a id="license"></a>

## लाइसेंस

The MIT License (MIT)। देखें [LICENSE](LICENSE)।

---

**Keywords:** Laravel वीडियो कॉन्फ्रेंसिंग, Laravel वीडियो मीटिंग, Laravel वीडियो कॉल, Zoom का विकल्प, Google Meet का विकल्प, Microsoft Teams का विकल्प, सेल्फ-होस्टेड वीडियो कॉन्फ्रेंसिंग, Laravel लाइव स्ट्रीमिंग, मीटिंग रिकॉर्डिंग, वीडियो रिकॉर्डिंग, टेलीमेडिसिन, टेलीहेल्थ वीडियो, ऑनलाइन शिक्षा, ई-लर्निंग वीडियो, वर्चुअल क्लासरूम, वेबिनार प्लेटफ़ॉर्म, लो लेटेंसी स्ट्रीमिंग, Laravel पैकेज, laravel webrtc, laravel video conference, laravel video call, laravel video meeting, laravel zoom clone, zoom alternative, google meet alternative, microsoft teams alternative, self-hosted video conferencing, laravel live streaming, webrtc php, ant media server, ant media laravel, antmedia php sdk, webrtc sfu, low latency streaming, hls, rtmp, srt, video recording, telemedicine laravel, telehealth video, elearning video, virtual classroom, webinar platform, laravel package
