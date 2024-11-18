<?php
declare(strict_types=1);

namespace ExewenTest\Sellfox;

use Exewen\Sellfox\Facade\ShopFacade;

class ShopTest extends Base
{

    public function testShop()
    {
        $params   = [
            'pageNo'   => 1,
            'pageSize' => 5,
        ];
        $response = ShopFacade::getShop($params);
        $this->assertNotEmpty($response);
    }


}