<?php

use AshrafBendary\WebRtcAntMedia\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::post(config('webrtc-ant-media.webhook.path', 'ant-media/webhook'), WebhookController::class)
    ->middleware(config('webrtc-ant-media.webhook.middleware', ['api']))
    ->name('webrtc-ant-media.webhook');
