<?php
declare(strict_types=1);

namespace ExewenTest\Sellfox;

use Exewen\Sellfox\Facade\FinancialFacade;

class FinancialTest extends Base
{

    public function testSettlementDetail()
    {
        $params   = [
            'pageNo'        => 1,
            'pageSize'      => 20,
            'currency'      => 'EUR',
            'startTime'     => date("Y-m-d", time() - 3600 * 72),
            'endTime'       => date("Y-m-d", time()),
            'searchType'    => 'orderIds',
            'searchContent' => '302-3220140-9179547',
        ];
        $response = FinancialFacade::getSettlementDetail($params);
        $this->assertNotEmpty($response);
    }

//    public function testShippingSettlement()
//    {
//        $params   = [
//            'pageNo'    => 1,
//            'pageSize'  => 20,
//            'timeType'  => 'purchaseTime',
//            'startTime' => date("Y-m-d", time() - 3600 * 24),
//            'endTime'   => date("Y-m-d", time()),
//        ];
//        $response = FinancialFacade::getShippingSettlement($params);
//        $this->assertNotEmpty($response);
//    }


}