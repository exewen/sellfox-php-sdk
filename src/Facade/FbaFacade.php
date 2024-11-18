<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Facade;

use Exewen\Facades\Facade;
use Exewen\Http\HttpProvider;
use Exewen\Logger\LoggerProvider;
use Exewen\Sellfox\Contract\AuthInterface;

/**
 * @method static array deliveryPlanCreate(array $params, array $header = [])
 * @method static array createShipment(array $params, array $header = [])
 */
class FbaFacade extends Facade
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