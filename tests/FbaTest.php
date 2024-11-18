<?php
declare(strict_types=1);

namespace ExewenTest\Sellfox;

use Exewen\Sellfox\Facade\FbaFacade;
use Exewen\Sellfox\Facade\ShopFacade;

class FbaTest extends Base
{


    public function testDeliveryPlanCreate()
    {
        $params   = [
            'shopId'        => 1,
            'warehouseId'   => 1,
            'marketplaceId' => 1,
            'shipmentDate'  => 1,
            'remark'        => 1,
            'isExpediting'  => 1,
            'items'         => [],
        ];
        $response = FbaFacade::deliveryPlanCreate($params);
        $this->assertNotEmpty($response);
    }

    public function testCreateShipment()
    {
        $params   = [
            'shopId'              => 1,
            'marketplaceId'       => 30,
            'labelPrepPreference' => 30,
            'areCasesRequired'    => 30,
            'fromAddress'         => 30,
            'mobile'              => 30,
            'shipmentPreviews'    => 30,
        ];
        $response = FbaFacade::createShipment($params);
        var_dump($response);
        $this->assertNotEmpty($response);
    }


}