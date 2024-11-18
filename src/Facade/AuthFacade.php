<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Facade;

use Exewen\Facades\Facade;
use Exewen\Http\HttpProvider;
use Exewen\Logger\LoggerProvider;
use Exewen\Sellfox\Constants\SellfoxEnum;
use Exewen\Sellfox\Contract\AuthInterface;

/**
 * @method static array getToken(string $clientId, string $clientSecret)
 * @method static array setAuth(string $clientId, string $clientSecret, string $accessToken, string $channel = SellfoxEnum::CHANNEL_API)
 */
class AuthFacade extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return AuthInterface::class;
    }

    public static function getProviders(): array
    {
        self::getContainer()->singleton(AuthInterface::class);

        return [
            LoggerProvider::class,
            HttpProvider::class,
        ];
    }
}