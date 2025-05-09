<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Facade;

use Exewen\Facades\AppFacade;
use Exewen\Facades\Facade;
use Exewen\Http\HttpProvider;
use Exewen\Logger\LoggerProvider;
use Exewen\Sellfox\Contract\OrderInterface;

/**
 * @method static array getOrder(array $params, array $header = [])
 * @method static array getOrderDetail(string $shopId, string $amazonOrderId, array $header = [])
 * @method static array getFmbOrder(array $params, array $header = [])
 * @method static array getFmbOrderDetail(string $packageSn, array $header = [])
 * @method static array submitToPlatform(array $params, array $header = [])
 * @method static array getFbaReturn(array $params, array $header = [])
 */
class OrderFacade extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return OrderInterface::class;
    }

    public static function getProviders(): array
    {
        AppFacade::getContainer()->singleton(OrderInterface::class);

        return [
            LoggerProvider::class,
            HttpProvider::class,
        ];
    }
}