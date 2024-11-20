<?php
declare(strict_types=1);

namespace ExewenTest\Sellfox;

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
        $this->assertNotEmpty($response);
    }

    public function testOrderDetail()
    {
        $shopId        = '309113';
        $amazonOrderId = '302-1734531-6885123';
        $response      = OrderFacade::getOrderDetail($shopId, $amazonOrderId);
        $this->assertNotEmpty($response);
    }

    public function testFmbOrder()
    {
        $params   = [
            'shopIdList'        => [], // 可选
            'pageNo'            => 1,
            'pageSize'          => 5,
            'purchaseDateStart' => date("Y-m-d", time() - 3600 * 24),
            'purchaseDateEnd'   => date("Y-m-d", time()),
        ];
        $response = OrderFacade::getFmbOrder($params);
        $this->assertNotEmpty($response);
    }

    public function testFmbOrderDetail()
    {
        $packageSn = 'P1PS4XGT00095';
        $response  = OrderFacade::getFmbOrderDetail($packageSn);
        $this->assertNotEmpty($response);
    }

//    public function testFbaReturn()
//    {
//        $params   = [
////            'shopIdList' => [], // 可选
//            'pageNo'          => 1,
//            'pageSize'        => 5,
//            'returnStartDate' => date("Y-m-d", time() - 3600 * 24),
//            'returnEndDate'   => date("Y-m-d", time()),
//        ];
//        $response = OrderFacade::getFbaReturn($params);
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


}