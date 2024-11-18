<?php
declare(strict_types=1);

namespace ExewenTest\Sellfox;

use Exewen\Sellfox\Facade\AuthFacade;
use Exewen\Sellfox\Facade\OrderFacade;

class OrderTest extends Base
{

    public function testOrder()
    {
        $params   = [
            'shopIdList' => [], // 可选
            'pageNo'     => 1,
            'pageSize'   => 5,
            'dateType'   => 'updateDateTime',
            'dateStart'  => date("Y-m-d H:i:s", time() - 3600 * 24),
            'dateEnd'    => date("Y-m-d H:i:s", time()),
        ];
        $response = OrderFacade::getOrder($params);
        var_dump($response);
        $this->assertNotEmpty($response);
    }

//    public function testOrderDetail()
//    {
//        $shopId        = '111';
//        $amazonOrderId = '111';
//        $response      = OrderFacade::getOrderDetail($shopId, $amazonOrderId);
//        var_dump($response);
//        $this->assertNotEmpty($response);
//    }


//    public function testOrderMark()
//    {
//        $params   = [];
//        $response = OrderFacade::orderMark($params);
//        var_dump($response);
//        $this->assertNotEmpty($response);
//    }
//
//
//    public function testOrderMarkResult()
//    {
//        $params   = [];
//        $response = OrderFacade::getOrderMarkResult($params);
//        var_dump($response);
//        $this->assertNotEmpty($response);
//    }


//    public function testFbaReturn()
//    {
//        $params   = [];
//        $response = OrderFacade::getFbaReturn($params);
//        var_dump($response);
//        $this->assertNotEmpty($response);
//    }


}