<?php

namespace AshrafBendary\WebRtcAntMedia\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \AshrafBendary\WebRtcAntMedia\AntMedia test()
 * @method static \AshrafBendary\WebRtcAntMedia\AntMedia main()
 * @method static \AshrafBendary\WebRtcAntMedia\AntMedia app(string $name)
 * @method static bool isTest()
 * @method static string appName()
 * @method static \AshrafBendary\WebRtcAntMedia\Client client()
 * @method static \AshrafBendary\WebRtcAntMedia\Resources\Broadcasts broadcasts()
 * @method static \AshrafBendary\WebRtcAntMedia\Resources\Rooms rooms()
 * @method static \AshrafBendary\WebRtcAntMedia\Resources\Tokens tokens()
 * @method static \AshrafBendary\WebRtcAntMedia\Resources\Recordings recordings()
 * @method static \AshrafBendary\WebRtcAntMedia\Resources\Vods vods()
 * @method static \AshrafBendary\WebRtcAntMedia\Resources\Endpoints endpoints()
 * @method static \AshrafBendary\WebRtcAntMedia\Resources\Subscribers subscribers()
 * @method static \AshrafBendary\WebRtcAntMedia\Resources\Stats stats()
 * @method static \AshrafBendary\WebRtcAntMedia\Resources\Cameras cameras()
 * @method static \AshrafBendary\WebRtcAntMedia\Urls urls()
 *
 * @see \AshrafBendary\WebRtcAntMedia\AntMedia
 */
class AntMedia extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \AshrafBendary\WebRtcAntMedia\AntMedia::class;
    }
}
