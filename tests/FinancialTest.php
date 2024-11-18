<?php
declare(strict_types=1);

namespace ExewenTest\Sellfox;

use Exewen\Sellfox\Facade\FinancialFacade;

class FinancialTest extends Base
{

    /**
     * 测试订单信息
     * @return void
     */
    public function testShop()
    {
        $params   = [
//            'pageNo'   => 1,
            'pageSize'  => 20,
            'timeType'  => 'purchaseTime',
            'startTime' => date("Y-m-d H:i:s", time() - 3600 * 24),
            'endTime'   => date("Y-m-d H:i:s", time()),
        ];
        $response = FinancialFacade::getShippingSettlement($params);
        var_dump($response);
        $this->assertNotEmpty($response);
    }


}