<?php
declare(strict_types=1);

namespace ExewenTest\Sellfox;

use Exewen\Sellfox\Facade\AuthFacade;

class SellfoxTest extends Base
{

    /**
     * 测试订单信息
     * @return void
     */
    public function testToken()
    {
        $clientId     = getenv('SELLFOX_CLIENT_ID');
        $clientSecret = getenv('SELLFOX_CLIENT_SECRET');
        $response     = AuthFacade::getToken($clientId, $clientSecret);
        var_dump($response);
        $this->assertNotEmpty($response);
    }


}