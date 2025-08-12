<?php
declare(strict_types=1);

namespace ExewenTest\Sellfox;

use Exewen\Sellfox\Facade\AuthFacade;
use Exewen\Sellfox\Facade\InboundFacade;
use PHPUnit\Framework\TestCase;

class Base extends TestCase
{
    public function __construct()
    {
        parent::__construct();
        !defined('BASE_PATH_PKG') && define('BASE_PATH_PKG', dirname(__DIR__, 1));

        $clientId     = getenv('SELLFOX_CLIENT_ID');
        $clientSecret = getenv('SELLFOX_CLIENT_SECRET');
        $accessToken  = getenv('SELLFOX_ACCESS_TOKEN');
        if ($clientId && $clientSecret && $accessToken) {
            AuthFacade::setAuth($clientId, $clientSecret, $accessToken);
        }
    }

    public function getInboundTaskProcess($taskId)
    {
        echo date('Y-m-d H:i:s') . ' 等待获取结果 ' . $taskId . PHP_EOL;

        do {
            sleep(1);
            echo date('Y-m-d H:i:s') . ' 获取结果 ' . $taskId . PHP_EOL;
            $response = InboundFacade::taskProcess($taskId);
            if ($taskStatus = $response['taskStatus']) {
                if ($taskStatus !== 'PROCESS') {
                    return $response;
                }
            }
        } while (true);
    }


}