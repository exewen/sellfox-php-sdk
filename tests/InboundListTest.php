<?php
declare(strict_types=1);

namespace ExewenTest\Sellfox;

use Exewen\Sellfox\Facade\InboundFacade;

class InboundListTest extends Base
{

    /**
     * 入库计划列表
     * @return void
     */
    public function testCreateInboundPlan()
    {
        $params   = [
            'shopIdList' => [407598],
            'pageSize'   => 10,
            'pageNo'     => 1,
        ];
        $response = InboundFacade::getInboundPlanList($params);
        var_dump($response);
        $this->assertNotEmpty($response);
    }


    /**
     * 入库计划详情
     * @return void
     */
    public function testConfirmSkuPackage()
    {

        $params   = [
            'inboundPlanId' => getenv('SELLFOX_INBOUND_PLAN_ID'), // 入库计划ID
        ];
        $response = InboundFacade::getInboundPlanDetail($params);
        var_dump($response);
        $this->assertNotEmpty($response);
    }

    /**
     * 货件详情
     * @return void
     */
    public function testGetShipment()
    {

        $params   = [
            'inboundPlanId' => getenv('SELLFOX_INBOUND_PLAN_ID'), // 入库计划ID
            'shipmentId'    => getenv('SELLFOX_SHIPMENT_ID') // 货件ID
        ];
        $response = InboundFacade::getShipment($params);
        var_dump($response);
        $this->assertNotEmpty($response);
    }


}