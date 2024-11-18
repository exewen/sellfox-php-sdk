<?php
declare(strict_types=1);

namespace ExewenTest\Sellfox;

use Exewen\Sellfox\Facade\AuthFacade;

class AuthTest extends Base
{

    public function testToken()
    {
        $clientId     = getenv('SELLFOX_CLIENT_ID');
        $clientSecret = getenv('SELLFOX_CLIENT_SECRET');
        $result       = AuthFacade::getToken($clientId, $clientSecret);
        echo $result['access_token'] . PHP_EOL;
        $this->assertNotEmpty($result);
    }


}