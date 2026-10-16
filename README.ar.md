# Laravel WebRTC Ant Media

[English](README.md) | **العربية** | [اردو](README.ur.md) | [हिन्दी](README.hi.md) | [Türkçe](README.tr.md) | [日本語](README.ja.md) | [简体中文](README.zh-CN.md)

### أنشئ تطبيق اجتماعات فيديو على غرار Zoom أو Google Meet أو Microsoft Teams باستخدام لارافيل (Laravel). مؤتمرات فيديو WebRTC قابلة للتوسع باستضافة ذاتية، مع البث المباشر وتسجيل الاجتماعات، مدعومة بـ Ant Media Server.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](https://packagist.org/packages/ashrafbendary/laravel-webrtc-ant-media)
[![Total Downloads](https://img.shields.io/packagist/dt/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](https://packagist.org/packages/ashrafbendary/laravel-webrtc-ant-media)
[![PHP Version](https://img.shields.io/packagist/php-v/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](https://packagist.org/packages/ashrafbendary/laravel-webrtc-ant-media)
[![License](https://img.shields.io/packagist/l/ashrafbendary/laravel-webrtc-ant-media.svg?style=flat-square)](LICENSE)

**Laravel WebRTC Ant Media** حزمة لارافيل (PHP SDK) لواجهة [Ant Media Server REST API](https://docs.antmedia.io/guides/developer-sdk-and-api/rest-api-guide/). تُمكّن أي تطبيق Laravel من إنشاء **اجتماعات الفيديو ومكالمات الفيديو والندوات عبر الإنترنت والبث المباشر والاستشارات الطبية عن بعد والفصول الافتراضية** من خلال Laravel facade واضحة، دون دفع رسوم بالدقيقة لـ Zoom أو Twilio أو Agora أو Vonage. إذا كنت تبحث عن بديل زووم أو بديل جوجل ميت أو بديل مايكروسوفت تيمز باستضافة ذاتية داخل تطبيق Laravel، فهذه الحزمة نقطة البداية.

> حزمة مجتمعية غير رسمية، ولا ترتبط بشركة Ant Media Inc. إن "Zoom" و"Google Meet" و"Microsoft Teams" علامات تجارية مملوكة لأصحابها، وتُذكر هنا لأغراض المقارنة فقط.

---

## جدول المحتويات

- [لماذا هذه الحزمة](#why-this-package)
- [حالات الاستخدام](#use-cases)
- [الميزات](#features)
- [المقارنة مع البدائل](#how-it-compares)
- [المتطلبات](#requirements)
- [التثبيت](#installation)
- [الإعدادات](#configuration)
- [البدء السريع: إنشاء غرفة اجتماعات فيديو](#quick-start-create-a-video-meeting-room)
- [الاستخدام](#usage)
  - [البث المباشر (broadcasts)](#live-streams-broadcasts)
  - [غرف مؤتمرات الفيديو (اجتماعات متعددة الأطراف)](#video-conference-rooms-multi-party-meetings)
  - [رموز الوصول الآمنة (JWT، الرمز لمرة واحدة، TOTP)](#secure-access-tokens-jwt-one-time-token-totp)
  - [التسجيل (MP4 / WebM)](#recording-mp4--webm)
  - [الفيديو حسب الطلب (VoD)](#video-on-demand-vod)
  - [إعادة البث إلى YouTube و Facebook و RTMP و SRT](#restream-to-youtube-facebook-rtmp-and-srt)
  - [المشاركون والمشتركون](#participants-and-subscribers)
  - [رسائل قناة البيانات (الدردشة داخل الاجتماع)](#data-channel-messages-in-meeting-chat)
  - [الإحصاءات والتحليلات](#statistics-and-analytics)
  - [كاميرات IP و RTSP و ONVIF](#ip-cameras-rtsp-and-onvif)
  - [الـ Webhooks وأحداث Laravel](#webhooks-and-laravel-events)
- [تغطية REST API](#rest-api-coverage)
- [الأمان والخصوصية والامتثال](#security-privacy-and-compliance)
- [استخدام هذه الحزمة مع مساعدي البرمجة بالذكاء الاصطناعي](#using-this-package-with-ai-coding-assistants)
- [الأسئلة الشائعة](#faq)
- [الاختبارات](#testing)
- [المساهمة](#contributing)
- [شكر وتقدير](#credits)
- [الترخيص](#license)

---

<a id="why-this-package"></a>

## لماذا هذه الحزمة

تعتمد معظم حزم مكالمات الفيديو في Laravel على **WebRTC من نوع نظير إلى نظير (P2P)**. يعمل P2P مع شخصين أو ثلاثة، ثم ينهار الأداء: إذ يرفع كل مشارك الفيديو إلى كل مشارك آخر.

تستخدم هذه الحزمة **Ant Media Server بوصفه خادم وسائط WebRTC من نوع SFU**، فتحصل على:

- **مؤتمرات فيديو قابلة للتوسع** تضم عددًا كبيرًا من المشاركين في غرفة واحدة
- **بث مباشر بزمن تأخير منخفض جدًا** (WebRTC، نحو 0.5 ثانية) لجماهير كبيرة
- **تسجيل من جهة الخادم** بصيغة MP4 أو WebM
- **HLS و RTMP و SRT و WebRTC** في منصة واحدة
- **استضافة ذاتية** على خوادمك أو سحابتك (AWS أو Google Cloud أو Azure أو Oracle Cloud أو خوادم محلية on-premise)، فلا تغادر بيانات الفيديو بنيتك التحتية أبدًا

<a id="use-cases"></a>

## حالات الاستخدام

| حالة الاستخدام | ما يمكنك بناؤه |
|---|---|
| **الطب الاتصالي / الاستشارات الطبية عن بعد (Telemedicine)** | استشارة فيديو بين الطبيب والمريض، عيادة افتراضية، رأي طبي ثانٍ عن بعد |
| **التعليم الإلكتروني / الدروس عبر الإنترنت** | فصول افتراضية، محاضرات مباشرة، غرف فيديو داخل أنظمة إدارة التعلم (LMS)، دورات مسجّلة |
| **الندوات عبر الإنترنت والفعاليات الافتراضية** | بث مباشر من واحد إلى كثيرين مع مقدّمين تفاعليين |
| **اجتماعات الفرق** | بديل لـ Zoom / Google Meet / Teams باستضافة ذاتية لشركتك (بديل زووم، بديل جوجل ميت، بديل مايكروسوفت تيمز) |
| **دعم العملاء** | دعم عبر مكالمات الفيديو، التحقق من الهوية بالفيديو (Video KYC)، المعاينة عن بعد |
| **التجارة المباشرة** | بث مباشر للتسوق مع دردشة فورية |
| **المراقبة** | عرض مباشر وتسجيل لكاميرات IP (RTSP / ONVIF) داخل Laravel |
| **التطبيقات الاجتماعية وتطبيقات صنّاع المحتوى** | البث المباشر، ميزات البث الفوري (Go Live)، إعادة البث إلى YouTube و Facebook |

<a id="features"></a>

## الميزات

- Laravel facade، وربط في حاوية الخدمات (service container)، واكتشاف تلقائي (auto-discovery)
- إنشاء **البث المباشر (broadcasts)** وتحديثه وعرضه وتشغيله وإيقافه وحذفه
- **غرف مؤتمرات الفيديو** باستخدام المسار الرئيسي (main track) والمسارات الفرعية (subtracks) في Ant Media
- حماية البث باستخدام **JWT** و**الرمز لمرة واحدة (one-time token)** و**TOTP** للنشر والتشغيل
- **مصادقة JWT لواجهة REST API** (HS256) تُدار تلقائيًا
- بدء **التسجيل** وإيقافه لكل بث (MP4 أو WebM)، وتحويل HLS إلى MP4
- إدارة **VoD**: رفع التسجيلات واستيرادها وعرضها وحذفها
- **إعادة البث / البث المتعدد (Restream / multistream)** إلى نقاط RTMP و SRT (YouTube Live و Facebook Live و Twitch و LinkedIn Live)
- **إدارة المشتركين**: إضافة المشاركين وعرضهم وحظرهم وإلغاء صلاحياتهم
- رسائل **قناة بيانات WebRTC (data channel)** للدردشة داخل الاجتماع والتفاعلات والإشارات
- **إحصاءات مباشرة**: المشاهدون (WebRTC و HLS و RTMP)، ومعدل البت (bitrate)، وإحصاءات العملاء، وأحداث الاتصال
- دعم **كاميرات IP**: سحب بث RTSP، واكتشاف أجهزة ONVIF، وتحريك PTZ
- **قوائم التشغيل (Playlists)** والتحكم في موضع التشغيل (seek) لمصادر البث
- **مستقبِل Webhook** يُطلق أحداث Laravel الأصلية
- كائنات DTO محددة الأنواع (typed)، وعميل Laravel HTTP، وإعدادات لإعادة المحاولة والمهلة الزمنية
- يعمل مع **Laravel 11 و 12 و 13** و PHP 8.2+
- يتكامل مع حزم WebRTC SDK من Ant Media لـ JavaScript و React و React Native و Flutter و Android و iOS

<a id="how-it-compares"></a>

## المقارنة مع البدائل

| | هذه الحزمة | Zoom / Google Meet / Teams | Twilio / Agora / Vonage | حزم Laravel WebRTC من نوع P2P |
|---|---|---|---|---|
| استضافة ذاتية | نعم | لا | لا | نعم |
| البيانات تبقى على خوادمك | نعم | لا | لا | نعم |
| رسوم بالدقيقة | لا | اشتراك | نعم | لا |
| اجتماعات كبيرة (SFU) | نعم | نعم | نعم | لا (2 إلى 3 مستخدمين) |
| بث مباشر لآلاف المشاهدين | نعم | محدود | تكلفة إضافية | لا |
| تسجيل من جهة الخادم | نعم | نعم | تكلفة إضافية | لا |
| مدمج في تطبيق Laravel الخاص بك | نعم | محدود | نعم | نعم |
| علامة بيضاء (White label) / علامتك التجارية | نعم | لا | نعم | نعم |

<a id="requirements"></a>

## المتطلبات

- PHP **8.2** أو أحدث
- Laravel **11.x أو 12.x أو 13.x**
- خادم **Ant Media Server** قيد التشغيل (الإصدار المجتمعي Community Edition أو إصدار المؤسسات Enterprise Edition). راجع [دليل البدء السريع من Ant Media](https://docs.antmedia.io/quick-start/).

<a id="installation"></a>

## التثبيت

```bash
composer require ashrafbendary/laravel-webrtc-ant-media
```

شغّل أداة التثبيت (تنشر ملف الإعدادات ومسار الـ webhook):

```bash
php artisan webrtc-ant-media:install
```

أو انشر ملف الإعدادات يدويًا:

```bash
php artisan vendor:publish --tag="webrtc-ant-media-config"
```

<a id="configuration"></a>

## الإعدادات

أضف ما يلي إلى ملف `.env`:

```dotenv
ANT_MEDIA_URL=https://media.example.com:5443
ANT_MEDIA_APP=live
ANT_MEDIA_JWT_SECRET=your-jwt-rest-api-filter-secret
ANT_MEDIA_STREAM_JWT_SECRET=your-stream-jwt-secret
ANT_MEDIA_TIMEOUT=15
ANT_MEDIA_WEBHOOK_SECRET=your-webhook-secret
```

| المفتاح | الوصف |
|---|---|
| `ANT_MEDIA_URL` | عنوان URL الأساسي لخادم Ant Media Server. استخدم المنفذ `5443` لـ HTTPS، والمنفذ `5080` لـ HTTP (للبيئة المحلية فقط) |
| `ANT_MEDIA_APP` | اسم التطبيق، مثل `live` أو `WebRTCAppEE` أو تطبيقك المخصص |
| `ANT_MEDIA_JWT_SECRET` | المفتاح السري من **Application Settings > JWT REST API Filter** (HS256) |
| `ANT_MEDIA_STREAM_JWT_SECRET` | المفتاح السري لتوقيع رموز النشر / التشغيل الخاصة بالبث |
| `ANT_MEDIA_TIMEOUT` | مهلة HTTP بالثواني |
| `ANT_MEDIA_WEBHOOK_SECRET` | مفتاح سري مشترك للتحقق من طلبات الـ webhook الواردة |

**المصادقة.** لا تقبل نقاط REST الخاصة بتطبيقات Ant Media افتراضيًا إلا الطلبات القادمة من `127.0.0.1` (فلتر IP). إذا كانت الواجهة الخلفية لتطبيق Laravel تعمل على خادم بعيد، ففعّل **JWT REST API Filter** من لوحة تحكم Ant Media واضبط المفتاح السري أعلاه. توقّع الحزمة رمز HS256 قصير الصلاحية يتضمن مطالبة `exp`، وترسله في الترويسة `Authorization: Bearer {token}` مع كل طلب.

<a id="quick-start-create-a-video-meeting-room"></a>

## البدء السريع: إنشاء غرفة اجتماعات فيديو

```php
use AshrafBendary\WebRtcAntMedia\Facades\AntMedia;

// 1. إنشاء غرفة اجتماع
$room = AntMedia::rooms()->create(name: 'Weekly Team Meeting');

// 2. منح كل مشارك رمزًا آمنًا للنشر + التشغيل (صالحًا لمدة ساعتين)
$token = AntMedia::tokens()->jwt(
    streamId: $room->streamId,
    type: 'publish',
    expiresAt: now()->addHours(2),
    roomId: $room->streamId,
);

// 3. مرّر $room->streamId و $token إلى Ant Media WebRTC JavaScript SDK في واجهة Blade / Vue / React
return view('meeting', compact('room', 'token'));
```

هذه هي الواجهة الخلفية الكاملة لغرفة اجتماعات على غرار Zoom. أما جهة المتصفح فتستخدم [Ant Media WebRTC JavaScript SDK](https://docs.antmedia.io/guides/developer-sdk-and-api/sdk-integration/) الرسمية.

<a id="usage"></a>

## الاستخدام

<a id="live-streams-broadcasts"></a>

### البث المباشر (broadcasts)

```php
use AshrafBendary\WebRtcAntMedia\Facades\AntMedia;

$stream = AntMedia::broadcasts()->create([
    'name' => 'Product Launch Live',
    'description' => 'Live product launch event',
]);

$stream->streamId;   // مثال: "stream_8f3a..."
$stream->rtmpURL;    // رابط استقبال RTMP لبرنامج OBS

AntMedia::broadcasts()->get($stream->streamId);
AntMedia::broadcasts()->list(offset: 0, size: 50, type: 'liveStream', sortBy: 'date', order: 'desc');
AntMedia::broadcasts()->update($stream->streamId, ['name' => 'New title']);
AntMedia::broadcasts()->stop($stream->streamId);
AntMedia::broadcasts()->delete($stream->streamId);
AntMedia::broadcasts()->deleteMany(['id1', 'id2']);
AntMedia::broadcasts()->count();
AntMedia::broadcasts()->activeCount();
AntMedia::broadcasts()->info($stream->streamId);   // العرض والارتفاع ومعدل البت والترميز (codec)
```

<a id="video-conference-rooms-multi-party-meetings"></a>

### غرف مؤتمرات الفيديو (اجتماعات متعددة الأطراف)

غرفة الاجتماع هي مسار رئيسي (main track)، وكل مشارك ينشر مسارًا فرعيًا (subtrack).

```php
$room = AntMedia::rooms()->create(name: 'Doctor Consultation #1024');

AntMedia::rooms()->addParticipant($room->streamId, participantStreamId: 'patient_1024');
AntMedia::rooms()->participants($room->streamId, offset: 0, size: 50);
AntMedia::rooms()->activeParticipants($room->streamId);
AntMedia::rooms()->activeParticipantsCount($room->streamId);
AntMedia::rooms()->removeParticipant($room->streamId, participantStreamId: 'patient_1024');

// إنهاء الاجتماع للجميع
AntMedia::rooms()->end($room->streamId);   // يوقف المسار الرئيسي والمسارات الفرعية
```

<a id="secure-access-tokens-jwt-one-time-token-totp"></a>

### رموز الوصول الآمنة (JWT، الرمز لمرة واحدة، TOTP)

تحكّم في من يمكنه **النشر** (الكاميرا / الميكروفون) ومن يمكنه **التشغيل** (المشاهدة).

```php
// رمز JWT (موصى به)، يُوقَّع محليًا دون الرجوع إلى الخادم
$jwt = AntMedia::tokens()->jwt($streamId, type: 'play', expiresAt: now()->addHour());

// رمز لمرة واحدة يُنشئه Ant Media Server
$oneTime = AntMedia::tokens()->oneTime($streamId, type: 'publish', expiresAt: now()->addMinutes(30));

// رمز TOTP لمشترك
$totp = AntMedia::subscribers()->totp($streamId, subscriberId: 'user_42', type: 'publish');

AntMedia::tokens()->validate($token);
AntMedia::tokens()->list($streamId);
AntMedia::tokens()->revokeAll($streamId);
```

<a id="recording-mp4--webm"></a>

### التسجيل (MP4 / WebM)

```php
AntMedia::recordings()->start($streamId, type: 'mp4', fileName: 'consultation_1024');
AntMedia::recordings()->stop($streamId, type: 'mp4');

// تحويل تسجيل HLS إلى MP4
AntMedia::recordings()->hlsToMp4('stream_8f3a', deleteHlsFiles: true);
```

<a id="video-on-demand-vod"></a>

### الفيديو حسب الطلب (VoD)

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

### إعادة البث إلى YouTube و Facebook و RTMP و SRT

```php
AntMedia::endpoints()->add($streamId, 'rtmp://a.rtmp.youtube.com/live2/YOUR-KEY');
AntMedia::endpoints()->add($streamId, 'srt://ingest.example.com:9000', resolutionHeight: 720);
AntMedia::endpoints()->remove($streamId, 'rtmp://a.rtmp.youtube.com/live2/YOUR-KEY');
```

<a id="participants-and-subscribers"></a>

### المشاركون والمشتركون

```php
AntMedia::subscribers()->add($streamId, [
    'subscriberId' => 'user_42',
    'type' => 'publish',   // صلاحية النشر تتيح التشغيل أيضًا (مطلوبة لمؤتمرات الفيديو)
]);

AntMedia::subscribers()->list($streamId, offset: 0, size: 50);
AntMedia::subscribers()->block($streamId, 'user_42', seconds: 600, type: 'publish_play');
AntMedia::subscribers()->delete($streamId, 'user_42');
AntMedia::subscribers()->revokeAll($streamId);
AntMedia::subscribers()->connectionEvents($streamId, offset: 0, size: 50);
```

<a id="data-channel-messages-in-meeting-chat"></a>

### رسائل قناة البيانات (الدردشة داخل الاجتماع)

```php
AntMedia::broadcasts()->sendMessage($streamId, [
    'type' => 'chat',
    'from' => 'Dr. Ahmed',
    'text' => 'Please turn on your camera.',
]);
```

<a id="statistics-and-analytics"></a>

### الإحصاءات والتحليلات

```php
AntMedia::stats()->broadcast($streamId);        // أعداد المشاهدين عبر WebRTC و HLS و RTMP
AntMedia::stats()->total();                     // إجمالي المشاهدين على مستوى التطبيق
AntMedia::stats()->webrtcClients($streamId);    // معدل بت الصوت / الفيديو لكل عميل
AntMedia::stats()->lowLevelSend();
AntMedia::stats()->lowLevelReceive();
```

<a id="ip-cameras-rtsp-and-onvif"></a>

### كاميرات IP و RTSP و ONVIF

```php
$camera = AntMedia::broadcasts()->create([
    'name' => 'Lobby Camera',
    'type' => 'ipCamera',
    'ipAddr' => '192.168.1.50',
    'username' => 'admin',
    'password' => 'secret',
], autoStart: true);

AntMedia::cameras()->discover();                       // اكتشاف أجهزة ONVIF
AntMedia::cameras()->profiles($camera->streamId);
AntMedia::cameras()->move($camera->streamId, x: 0.2, y: 0, zoom: 0, movement: 'relative');
AntMedia::cameras()->stopMove($camera->streamId);
AntMedia::broadcasts()->start($camera->streamId);      // بدء سحب مصدر البث
```

<a id="webhooks-and-laravel-events"></a>

### الـ Webhooks وأحداث Laravel

وجّه الإعداد **Application Settings > Webhook URL** في Ant Media إلى:

```
https://your-app.com/ant-media/webhook
```

استمع إلى أحداث Laravel الأصلية:

```php
use AshrafBendary\WebRtcAntMedia\Events\LiveStreamStarted;
use AshrafBendary\WebRtcAntMedia\Events\LiveStreamEnded;
use AshrafBendary\WebRtcAntMedia\Events\RecordingReady;

Event::listen(LiveStreamStarted::class, fn ($e) => logger("Meeting started: {$e->streamId}"));
Event::listen(LiveStreamEnded::class,   fn ($e) => logger("Meeting ended: {$e->streamId}"));
Event::listen(RecordingReady::class,    fn ($e) => logger("Recording ready: {$e->vodId}"));
```

<a id="rest-api-coverage"></a>

## تغطية REST API

تستهدف جميع الاستدعاءات المسار `{ANT_MEDIA_URL}/{ANT_MEDIA_APP}/rest/v2/...`. المخططات الكاملة متاحة في [Ant Media Swagger](https://antmedia.io/rest/).

| دالة الحزمة | HTTP | نقطة النهاية في Ant Media |
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

## الأمان والخصوصية والامتثال

نظرًا لأن Ant Media Server يعمل باستضافة ذاتية، فأنت من يختار مكان تخزين الفيديو والتسجيلات. وهذا يُسهّل تلبية متطلبات **توطين البيانات (data residency)** والخصوصية، مثل **GDPR** و**HIPAA** و**نظام حماية البيانات الشخصية السعودي (PDPL)** وقوانين حماية البيانات في الإمارات وغيرها من القوانين الوطنية. يعتمد الامتثال على بيئة النشر الكاملة لديك، وليس على هذه الحزمة وحدها.

الإعداد الموصى به:

- شغّل Ant Media Server في المنطقة المطلوبة (مثل AWS Middle East أو Google Cloud Dammam أو Oracle Cloud Jeddah أو مناطق الاتحاد الأوروبي أو خوادم محلية on-premise)
- استخدم HTTPS على المنفذ `5443` مع شهادة SSL صالحة
- فعّل **JWT REST API Filter**؛ ولا تكشف واجهة REST API للعامة معتمدًا على فلترة عنوان IP وحدها
- فعّل **حماية رموز النشر / التشغيل** للبث في كل اجتماع
- اجعل صلاحية الرموز قصيرة عبر `exp`، وألغِ الرموز والمشتركين عند انتهاء الاجتماع
- خزّن التسجيلات في مساحة تخزين مشفّرة، وسجّل من اطّلع عليها

<a id="using-this-package-with-ai-coding-assistants"></a>

## استخدام هذه الحزمة مع مساعدي البرمجة بالذكاء الاصطناعي

هل تستخدم Claude أو ChatGPT أو Cursor أو GitHub Copilot أو مساعد ذكاء اصطناعي آخر لبناء تطبيقك؟ اكتب له:

> "استخدم حزمة Laravel `ashrafbendary/laravel-webrtc-ant-media` لبناء تطبيق اجتماعات فيديو باستضافة ذاتية مع Ant Media Server. اقرأ ملف README وملف llms.txt أولًا."

يتضمن هذا المستودع الملفين `llms.txt` و `AGENTS.md` مع قواعد الاستخدام لوكلاء الذكاء الاصطناعي.

<a id="faq"></a>

## الأسئلة الشائعة

**كيف أبني تطبيقًا مشابهًا لـ Zoom (Zoom clone) باستخدام Laravel؟**
ثبّت هذه الحزمة، وشغّل Ant Media Server، وأنشئ غرفة باستخدام `AntMedia::rooms()->create()`، وأصدر رموز JWT لكل مشارك، ثم اربط المتصفح عبر Ant Media WebRTC JavaScript SDK. راجع [البدء السريع](#quick-start-create-a-video-meeting-room).

**هل هذا بديل زووم مجاني؟**
الحزمة مجانية ومفتوحة المصدر (MIT). يوفّر Ant Media Server إصدارًا مجتمعيًا مجانيًا (Community Edition) وإصدارًا مدفوعًا للمؤسسات (Enterprise Edition). تُعدّ مؤتمرات الفيديو متعددة الأطراف و WebRTC بزمن تأخير منخفض جدًا على نطاق واسع من ميزات إصدار Enterprise، لذا راجع شروط ترخيص Ant Media بما يناسب حالتك.

**ما الفرق بين هذه الحزمة وحزم WebRTC من نوع P2P؟**
يرسل P2P الفيديو مباشرة بين المتصفحات ويعمل مع 2 إلى 3 أشخاص. أما هذه الحزمة فتستخدم خادم وسائط (SFU)، لذا تدعم الاجتماعات الكبيرة والبث المباشر لجماهير واسعة والتسجيل من جهة الخادم.

**هل يمكنني استخدامها في الطب الاتصالي والاستشارات الطبية عن بعد؟**
نعم. الميزات الشائعة في الرعاية الصحية عن بعد (غرف آمنة، رموز قصيرة الصلاحية، تسجيل، بيانات مستضافة ذاتيًا) مغطاة. ومع ذلك، يجب أن تستوفي بيئة النشر لديك اللوائح الصحية المحلية.

**هل تدعم البث المباشر إلى YouTube أو Facebook؟**
نعم، استخدم `AntMedia::endpoints()->add()` مع رابط الاستقبال (ingest URL) الخاص بـ RTMP أو SRT.

**ما الواجهات الأمامية المدعومة؟**
Blade و Livewire و Inertia و Vue و React و JavaScript العادي على الويب، إضافة إلى React Native و Flutter و Android و iOS عبر حزم SDK الرسمية من Ant Media.

**هل تعمل مع Laravel Octane و Horizon وطوابير المهام (queues)؟**
نعم. تستخدم جميع الاستدعاءات عميل Laravel HTTP، ويمكن تشغيلها بأمان داخل المهام (jobs).

**هل تدعم وضع العنقود (cluster mode) في Ant Media Server؟**
نعم. وجّه `ANT_MEDIA_URL` إلى موازن الأحمال (load balancer) أو خادم المصدر (origin) في العنقود.

<a id="testing"></a>

## الاختبارات

```bash
composer test
```

تستخدم الحزمة `Http::fake()`، لذا لا تستدعي الاختبارات أي خادم وسائط حقيقي أبدًا.

<a id="contributing"></a>

## المساهمة

طلبات السحب (Pull requests) مرحّب بها. يُرجى فتح issue أولًا قبل التغييرات الكبيرة، وإضافة اختبارات لأي نقاط نهاية جديدة.

<a id="credits"></a>

## شكر وتقدير

- [Ashraf Bendary](https://github.com/ashrafbendary)
- مبنية على [Ant Media Server REST API](https://antmedia.io/rest/)

<a id="license"></a>

## الترخيص

رخصة MIT (The MIT License). راجع [LICENSE](LICENSE).

---

**الكلمات المفتاحية:** حزمة لارافيل، لارافيل (Laravel)، لارافيل WebRTC، مؤتمرات الفيديو، اجتماعات الفيديو، مكالمات الفيديو، بديل زووم، بديل جوجل ميت، بديل مايكروسوفت تيمز، مؤتمرات فيديو باستضافة ذاتية، استضافة ذاتية، البث المباشر، بث مباشر بزمن تأخير منخفض، تسجيل الاجتماعات، تسجيل الفيديو، الطب الاتصالي، الاستشارات الطبية عن بعد، التعليم الإلكتروني، الفصول الافتراضية، ندوات عبر الإنترنت، منصة ندوات، خادم Ant Media، laravel webrtc, laravel video conference, laravel video call, laravel video meeting, laravel zoom clone, zoom alternative, google meet alternative, microsoft teams alternative, self-hosted video conferencing, laravel live streaming, webrtc php, ant media server, ant media laravel, antmedia php sdk, webrtc sfu, low latency streaming, hls, rtmp, srt, video recording, telemedicine laravel, telehealth video, elearning video, virtual classroom, webinar platform, laravel package
