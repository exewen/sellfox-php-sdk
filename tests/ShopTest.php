<?php
declare(strict_types=1);

namespace ExewenTest\Sellfox;

use Exewen\Sellfox\Facade\ShopFacade;

class ShopTest extends Base
{

    /**
     * 测试订单信息
     * @return void
     */
    public function testShop()
    {
        $params   = [
            'pageNo'   => 1,
            'pageSize' => 30,
        ];
        $response = ShopFacade::getShop($params);
        var_dump($response);
        $this->assertNotEmpty($response);
    }


}