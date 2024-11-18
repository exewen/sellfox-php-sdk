<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Facade;

use Exewen\Facades\Facade;
use Exewen\Http\HttpProvider;
use Exewen\Logger\LoggerProvider;
use Exewen\Sellfox\Contract\ShopInterface;

/**
 * @method static array getShop(array $params)
 */
class ShopFacade extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return ShopInterface::class;
    }

    public static function getProviders(): array
    {
        self::getContainer()->singleton(ShopInterface::class);

        return [
            LoggerProvider::class,
            HttpProvider::class,
        ];
    }
}