<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Facade;

use Exewen\Facades\AppFacade;
use Exewen\Facades\Facade;
use Exewen\Http\HttpProvider;
use Exewen\Logger\LoggerProvider;
use Exewen\Sellfox\Contract\FinancialInterface;

/**
 * @method static array getSettlementDetail(array $params, array $header = [])
 * @method static array getShippingSettlement(array $params, array $header = [])
 */
class FinancialFacade extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return FinancialInterface::class;
    }

    public static function getProviders(): array
    {
        AppFacade::getContainer()->singleton(FinancialInterface::class);

        return [
            LoggerProvider::class,
            HttpProvider::class,
        ];
    }
}