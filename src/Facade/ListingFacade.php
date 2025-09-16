<?php

namespace Exewen\Sellfox\Facade;

use Exewen\Facades\AppFacade;
use Exewen\Facades\Facade;
use Exewen\Http\HttpProvider;
use Exewen\Logger\LoggerProvider;
use Exewen\Sellfox\Contract\ListingInterface;

/**
 * @method static array getListing(array $params, array $header = [])
 */
class ListingFacade extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return ListingInterface::class;
    }
    
    public static function getProviders(): array
    {
        AppFacade::getContainer()->singleton(ListingInterface::class);
        
        return [
            LoggerProvider::class,
            HttpProvider::class,
        ];
    }

}