<?php

namespace AshrafBendary\WebRtcAntMedia\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'webrtc-ant-media:install';

    protected $description = 'Publish the Ant Media config and show the .env keys to add';

    public function handle(): int
    {
        $this->call('vendor:publish', ['--tag' => 'webrtc-ant-media-config']);

        $this->newLine();
        $this->info('Add these keys to your .env file:');
        $this->line(<<<'ENV'
ANT_MEDIA_ORIGIN_URL=https://origin.example.com:5443
ANT_MEDIA_EDGE_URL=https://edge.example.com:5443
ANT_MEDIA_APP=LiveApp
ANT_MEDIA_TEST_APP=WebRTCAppEE
ANT_MEDIA_USE_TEST_APP=false
ANT_MEDIA_JWT_SECRET=
ANT_MEDIA_STREAM_JWT_SECRET=
ANT_MEDIA_WEBHOOK_SECRET=
ENV);
        $this->newLine();
        $this->info('Webhook URL for Ant Media: '.url(config('webrtc-ant-media.webhook.path', 'ant-media/webhook')).'?secret=ANT_MEDIA_WEBHOOK_SECRET');

        return self::SUCCESS;
    }
}
