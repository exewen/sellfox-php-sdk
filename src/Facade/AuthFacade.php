<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Facade;

use Exewen\Facades\Facade;
use Exewen\Http\HttpProvider;
use Exewen\Logger\LoggerProvider;
use Exewen\Sellfox\Contract\FbaInterface;

/**
 * @method static array getToken(string $clientId, string $clientSecret)
 */
class AuthFacade extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return FbaInterface::class;
    }

    public static function getProviders(): array
    {
        self::getContainer()->singleton(FbaInterface::class);

        return [
            LoggerProvider::class,
            HttpProvider::class,
        ];
    }
}