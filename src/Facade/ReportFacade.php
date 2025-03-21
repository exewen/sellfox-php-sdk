<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Facade;

use Exewen\Facades\AppFacade;
use Exewen\Facades\Facade;
use Exewen\Http\HttpProvider;
use Exewen\Logger\LoggerProvider;
use Exewen\Sellfox\Contract\ReportInterface;

/**
 * @method static array getFbaReturn(array $params, array $header = [])
 * @method static array getFbaStorageFee(array $params, array $header = [])
 */
class ReportFacade extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return ReportInterface::class;
    }

    public static function getProviders(): array
    {
        AppFacade::getContainer()->singleton(ReportInterface::class);

        return [
            LoggerProvider::class,
            HttpProvider::class,
        ];
    }
}