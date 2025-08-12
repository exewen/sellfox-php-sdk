<?php
declare(strict_types=1);

namespace ExewenTest\Sellfox;

use Exewen\Sellfox\Facade\InboundFacade;

class InboundCreateTest extends Base
{

    /**
     * 1.1 创建入库计划
     * @return void
     */
    public function testCreateInboundPlan()
    {
        $params   = [
            'shopId' => 407598,
            'name'   => 'PL-CAKO102-42PCS-20250807-测试0811-3',  // 入库计划名称
            'source' => [
                'name'                => 'MEOWOW OÜ', // 收件人姓名
                'addressLine1'        => 'Narva mnt 7-634', // 地址第一行
                'addressLine2'        => '', // 地址第二行（可选）
                'city'                => 'Harju maakond', // 城市名称
                'stateOrProvinceCode' => 'Tallinn, Kesklinna linnaosa,', // 州或省份编码
                'countryCode'         => 'EE', // 国家ISO编码
                'postalCode'          => '10117', // 邮政编码
                'email'               => 'info@meowowglobal.com', // 电子邮箱地址（可选）
                'phoneNumber'         => '+447846911660', // 联系电话号码
                'companyName'         => 'MEOWOW OÜ', // 公司名称（可选）
            ],
            'items'  => [
                [
                    'msku'           => 'FBA-STAR#CAK0102', // 商品唯一标识MSKU
//                    'prepCategory'   => '', // 预处理分类（可选）
//                    'prepType'       => [], // 预处理类型列表（可选）
                    'labelOwner'     => 'NONE', // 贴标方，可取值：AMAZON、SELLER、NONE
                    'prepOwner'      => 'SELLER', // 预处理方，可取值：AMAZON、SELLER、NONE
                    'quantity'       => '42', // 申报数量，范围[1-999999999]
                    'expirationDate' => '', // 商品有效期，格式为YYYY-MM-DD（可选）
                ]
            ],
        ];
        $response = InboundFacade::createInboundPlan($params);
        // {"code":0,"msg":"success","data":{"taskId":"56ae4397a3d1421481a832fd88df3746"},"requestId":"97dfc40c-7b15-4090-8b52-1c2f7ca8c20d"}
        if ($taskId = $response['taskId'] ?? '') {
            echo date('Y-m-d H:i:s') . ' 创建成功 ' . $taskId . PHP_EOL;

            $response      = $this->getInboundTaskProcess($taskId);
            $inboundPlanId = $response['inboundPlanId'] ?? '';
            $taskStatus    = $response['taskStatus'] ?? '';
            $msg           = $response['msg'] ?? '';
            echo date('Y-m-d H:i:s') . " inboundPlanId:{$inboundPlanId} taskStatus:{$taskStatus} msg:{$msg}" . PHP_EOL;
            // test2 成功 {"code":0,"msg":"success","data":{"inboundPlanId":"wf23f189d6-9d2c-4707-8c53-6e5035f17865","taskId":"46498a8c915e4b109c6ea1e7c21c5194","taskStatus":"SUCCESS","msg":"入库计划创建成功","createDate":1754620435858},"requestId":"db8afad6-2d48-4f42-bc2f-4abea0c06199"}
            // 再次请求 任务不存在 {"code":0,"msg":"success","data":{"inboundPlanId":"","taskId":"46498a8c915e4b109c6ea1e7c21c5194","taskStatus":"FAILURE","msg":"任务不存在","createDate":1754620494606},"requestId":"3a68839c-4e15-42f9-a1a0-a06e5953ff68"}
            // test3 {"code":0,"msg":"success","data":{"inboundPlanId":"wf9fe352e3-b25d-494c-a375-c11b6a18c960","taskId":"ffd74d366b8943269cdb7ea0d415026c","taskStatus":"SUCCESS","msg":"入库计划创建成功","createDate":1754895778372},"requestId":"b965dc65-f238-4a46-ab08-aaebd1d44dbd"}
            $this->assertNotEmpty($response);
        } else {
            $this->fail('taskId未获取');
        }

    }

    /**
     * 2.1 生成装箱组选项
     * @return void
     */
    public function testPackageSetOptions()
    {
        /** 生成装箱组选项 **/
        $params   = [
            'inboundPlanId' => getenv('SELLFOX_INBOUND_PLAN_ID') // 入库计划ID
        ];
        $response = InboundFacade::generatePackingOptions($params);
        if ($taskId = $response['taskId'] ?? '') {
            echo date('Y-m-d H:i:s') . ' generatePackingOptions ' . $taskId . PHP_EOL;
            $response = $this->getInboundTaskProcess($taskId);
            // 生成装箱组选项成功
            $inboundPlanId = $response['inboundPlanId'] ?? '';
            $taskStatus    = $response['taskStatus'] ?? '';
            $msg           = $response['msg'] ?? '';
            echo date('Y-m-d H:i:s') . " inboundPlanId:{$inboundPlanId} taskStatus:{$taskStatus} msg:{$msg}" . PHP_EOL;
            $this->assertNotEmpty($response);
        } else {
            $this->fail('失败：generatePackingOptions');
        }
    }

    /**
     * 2.2 查询装箱组选项
     * @return void
     */
    public function testPackageGetOptions()
    {
        /** 查询装箱组选项 **/
        $params   = [
            'inboundPlanId' => getenv('SELLFOX_INBOUND_PLAN_ID') // 入库计划ID
        ];
        $response = InboundFacade::listPackingOptions($params);
        var_dump($response);
        // {"code":0,"msg":"","data":[{"discounts":[],"expiration":null,"fees":[],"packingGroups":["pgcaa79cbe-0f9b-413d-a96b-b0de2a19563c"],"packingOptionId":"pof7559dc8-c49a-4d82-9047-0e9dbb46f249","status":"OFFERED","supportedConfigurations":[{"boxRequirements":null,"boxPackingMethods":["BOX_CONTENT_PROVIDED","BARCODE_2D","MANUAL_PROCESS"],"shippingRequirements":[{"modes":["GROUND_SMALL_PARCEL"],"solution":"USE_YOUR_OWN_CARRIER"},{"modes":["FREIGHT_LTL"],"solution":"USE_YOUR_OWN_CARRIER"},{"modes":["FREIGHT_FTL_PALLET"],"solution":"USE_YOUR_OWN_CARRIER"},{"modes":["OCEAN_LCL"],"solution":"USE_YOUR_OWN_CARRIER"},{"modes":["OCEAN_FCL"],"solution":"USE_YOUR_OWN_CARRIER"},{"modes":["AIR_SMALL_PARCEL"],"solution":"USE_YOUR_OWN_CARRIER"},{"modes":["AIR_SMALL_PARCEL_EXPRESS"],"solution":"USE_YOUR_OWN_CARRIER"},{"modes":["GROUND_SMALL_PARCEL"],"solution":"AMAZON_PARTNERED_CARRIER"},{"modes":["FREIGHT_LTL"],"solution":"AMAZON_PARTNERED_CARRIER"},{"modes":["FREIGHT_FTL_PALLET"],"solution":"AMAZON_PARTNERED_CARRIER"},{"modes":["OCEAN_LCL"],"solution":"AMAZON_PARTNERED_CARRIER"},{"modes":["OCEAN_FCL"],"solution":"AMAZON_PARTNERED_CARRIER"},{"modes":["AIR_SMALL_PARCEL"],"solution":"AMAZON_PARTNERED_CARRIER"},{"modes":["AIR_SMALL_PARCEL_EXPRESS"],"solution":"AMAZON_PARTNERED_CARRIER"}]}]}],"requestId":"c2bfcc12-8fd9-4334-abec-fd027e1cee5d"}
        // 返回
        // packingOptionId  装箱选项ID
        // packingGroups    装箱组ID
        $this->assertNotEmpty($response);
    }

    /**
     * 2.2.1 查询装箱组商品(商品&费用确认)
     * @return void
     */
    public function testPackageGetItem()
    {
        /** 查询装箱组商品 **/
        $params   = [
            'inboundPlanId'  => getenv('SELLFOX_INBOUND_PLAN_ID'), // 入库计划ID
            'packingGroupId' => getenv('SELLFOX_PACKING_GROUP_ID') // 装箱组ID
        ];
        $response = InboundFacade::listPackingGroupItems($params);
        // {"code":0,"msg":"","data":[{"asin":"B09JGHWPPZ","expiration":null,"fnsku":"B09JGHWPPZ","labelOwner":"NONE","manufacturingLotCode":null,"msku":"FBA-STAR#CAK0102","prepInstructions":[{"fee":{"amount":0,"code":"EUR"},"prepOwner":"SELLER","prepType":"ITEM_NO_PREP"}],"quantity":42}],"requestId":"f8cdbd0f-ff3e-41a8-9289-8d2ab4e8b9b5"}
        // -3 {"code":0,"msg":"","data":[{"asin":"B09JGHWPPZ","expiration":null,"fnsku":"B09JGHWPPZ","labelOwner":"NONE","manufacturingLotCode":null,"msku":"FBA-STAR#CAK0102","prepInstructions":[{"fee":{"amount":0,"code":"EUR"},"prepOwner":"SELLER","prepType":"ITEM_NO_PREP"}],"quantity":42}],"requestId":"6ede7a48-17b7-46b4-a16c-955176c084c1"}
        // 返回 明细费用、数量、fnsku
        $this->assertNotEmpty($response);
    }

    /**
     * 2.3 确认装箱选项
     * @return void
     */
    public function testPackageConfirmOptions()
    {
        /** 确认装箱选项 **/
        $params   = [
            'inboundPlanId'   => getenv('SELLFOX_INBOUND_PLAN_ID'), // 入库计划ID
            'packingOptionId' => getenv('SELLFOX_PACKING_OPTION_ID') // 装箱选项ID
        ];
        $response = InboundFacade::confirmPackingOption($params);
        if ($taskId = $response['taskId'] ?? '') {
            echo date('Y-m-d H:i:s') . ' confirmPackingOption ' . $taskId . PHP_EOL;
            $response = $this->getInboundTaskProcess($taskId);
            // 确认装箱组选项成功
            $inboundPlanId = $response['inboundPlanId'] ?? '';
            $taskStatus    = $response['taskStatus'] ?? '';
            $msg           = $response['msg'] ?? '';
            echo date('Y-m-d H:i:s') . " inboundPlanId:{$inboundPlanId} taskStatus:{$taskStatus} msg:{$msg}" . PHP_EOL;
            $this->assertNotEmpty($response);
        } else {
            $this->fail('失败：confirmPackingOption');
        }
    }

    /**
     * 2.4 提交装箱
     * @return void
     */
    public function testPackageSubmit()
    {
        /** 提交装箱信息 **/
        // 按箱拆分
        $boxItem  = [
            'dimensions' => ['length' => 60.00, 'width' => 38.00, 'height' => 27.00, 'unitOfMeasurement' => 'CM',],
            'quantity'   => 1, // 参数无效 需要拆分box明细
            'weight'     => ['value' => 18.040, 'unit' => 'KG',],
            'items'      => [
                ['msku' => 'FBA-STAR#CAK0102', 'quantity' => 14, 'labelOwner' => 'NONE', 'prepOwner' => 'SELLER',]
            ]
        ];
        $params   = [
            'inboundPlanId'    => getenv('SELLFOX_INBOUND_PLAN_ID'), // 入库计划ID
            'packageGroupings' => [
                [
                    'packingGroupId' => getenv('SELLFOX_PACKING_GROUP_ID'), // 装箱组ID：先装箱后分仓方式时必填
                    'boxes'          => [
                        $boxItem,
                        $boxItem,
                        $boxItem
                    ],
                ]
            ]
        ];
        $response = InboundFacade::setPackingInformation($params);
        if ($taskId = $response['taskId'] ?? '') {
            echo date('Y-m-d H:i:s') . ' setPackingInformation ' . $taskId . PHP_EOL;
            $response      = $this->getInboundTaskProcess($taskId);
            $inboundPlanId = $response['inboundPlanId'] ?? '';
            $taskStatus    = $response['taskStatus'] ?? '';
            $msg           = $response['msg'] ?? '';
            echo date('Y-m-d H:i:s') . " inboundPlanId:{$inboundPlanId} taskStatus:{$taskStatus} msg:{$msg}" . PHP_EOL;
            $this->assertNotEmpty($response);
        } else {
            $this->fail('失败：setPackingInformation');
        }
    }

    /**
     * 3.1 生成入库配置项
     * @return void
     */
    public function testPlacementSetOptions()
    {
        /** 生成入库配置项 **/
        $params   = [
            'inboundPlanId' => getenv('SELLFOX_INBOUND_PLAN_ID'), // 入库计划ID
        ];
        $response = InboundFacade::generatePlacementOptions($params);
        if ($taskId = $response['taskId'] ?? '') {
            echo date('Y-m-d H:i:s') . ' generatePlacementOptions ' . $taskId . PHP_EOL;
            $response      = $this->getInboundTaskProcess($taskId);
            $inboundPlanId = $response['inboundPlanId'] ?? '';
            $taskStatus    = $response['taskStatus'] ?? '';
            $msg           = $response['msg'] ?? '';
            echo date('Y-m-d H:i:s') . " inboundPlanId:{$inboundPlanId} taskStatus:{$taskStatus} msg:{$msg}" . PHP_EOL;
            $this->assertNotEmpty($response);
        } else {
            $this->fail('失败：generatePlacementOptions');
        }
    }

    /**
     * 3.2 查询入库配置项
     * @return void
     */
    public function testPlacementGetOptions()
    {
        /** 查询入库配置项  返回配置选项ID **/
        $params   = [
            'inboundPlanId' => getenv('SELLFOX_INBOUND_PLAN_ID'), // 入库计划ID
        ];
        $response = InboundFacade::listPlacementOptions($params);
        foreach ($response ?? [] as $item) {
            $fees = $item['fees'] ?? [];
            foreach ($fees as $fee) {
                echo "费用 " . $fee['type'] . ":" . $fee['value']['amount'] . PHP_EOL;
            }
        }
        echo "放置配置 placementOptionId:" . $item['placementOptionId'] . PHP_EOL;
        $shipmentIds = $item['shipmentIds'] ?? [];
        echo "shipmentIds:" . json_encode($shipmentIds) . PHP_EOL;
        // {"code":0,"msg":"","data":[{"discounts":[],"expiration":"2025-08-11T04:17:38.990Z","fees":[{"description":"Placement service fee represents service to inbound with minimal shipment splits and destinations of skus","target":"Placement Services","type":"FEE","value":{"amount":0,"code":"PLN"}}],"placementOptionId":"pla976576d-2001-4451-88ca-447982bb5f7c","shipmentIds":["shab88530d-ff44-4f7a-a914-813a6dd9fbd2"],"status":"OFFERED"}],"requestId":"87d826d3-fd6c-48cb-abe8-c6c8e4b48bb1"}
        // 返回
        //  放置选项超时时间
        //  费用
        //  放置配置ID
        //  shipmentIds
        //  配置状态
        $this->assertNotEmpty($response);
    }

    /**
     * 3.3 生成运输承运人选项(设定预计发货时间)
     * @return void
     */
    public function testTransportationSetOptions()
    {
        /** 生成运输承运人选项 **/
        $currentTime = date('Y-m-d\TH:i:s\Z', time() - 3600 * 6);
        $params      = [
            'inboundPlanId'                        => getenv('SELLFOX_INBOUND_PLAN_ID'), // 入库计划ID
            'placementOptionId'                    => getenv('SELLFOX_PLACEMENT_OPTION_ID'), // 配置选项ID
            'shipmentTransportationConfigurations' => [
                [
                    'readyToShipWindow' => [
                        'start' => $currentTime // 预计发货时间窗
                    ],
                    'shipmentId'        => getenv('SELLFOX_SHIPMENT_ID') // 货件ID
                ]
            ]
        ];
        $response    = InboundFacade::generateTransportationOptions($params);
        if ($taskId = $response['taskId'] ?? '') {
            echo date('Y-m-d H:i:s') . ' generateTransportationOptions ' . $taskId . PHP_EOL;
            $response = $this->getInboundTaskProcess($taskId);
            // 生成运输承运人选项成功
            $inboundPlanId = $response['inboundPlanId'] ?? '';
            $taskStatus    = $response['taskStatus'] ?? '';
            $msg           = $response['msg'] ?? '';
            echo date('Y-m-d H:i:s') . " inboundPlanId:{$inboundPlanId} taskStatus:{$taskStatus} msg:{$msg}" . PHP_EOL;
            $this->assertNotEmpty($response);
        } else {
            $this->fail('失败：generateTransportationOptions');
        }
    }

    /**
     * 3.4 生成预计送达时间窗口
     * @return void
     */
    public function testDeliverySetOptions()
    {
        /** 生成预计送达时间窗口 **/
        $params   = [
            'inboundPlanId' => getenv('SELLFOX_INBOUND_PLAN_ID'), // 入库计划ID
            'shipmentId'    => getenv('SELLFOX_SHIPMENT_ID') // 货件ID
        ];
        $response = InboundFacade::generateDeliveryWindowOptions($params);
        if ($taskId = $response['taskId'] ?? '') {
            echo date('Y-m-d H:i:s') . ' generateDeliveryWindowOptions ' . $taskId . PHP_EOL;
            $response = $this->getInboundTaskProcess($taskId);
            // 生成预计送达时间窗口成功
            $inboundPlanId = $response['inboundPlanId'] ?? '';
            $taskStatus    = $response['taskStatus'] ?? '';
            $msg           = $response['msg'] ?? '';
            echo date('Y-m-d H:i:s') . " inboundPlanId:{$inboundPlanId} taskStatus:{$taskStatus} msg:{$msg}" . PHP_EOL;
            $this->assertNotEmpty($response);
        } else {
            $this->fail('失败：generateDeliveryWindowOptions');
        }
    }

    /**
     * 3.5 查询运输承运人选项
     * @return void
     */
    public function testTransportationGetOptions()
    {
        /** 查询运输承运人选项 **/
        $params   = [
            'inboundPlanId' => getenv('SELLFOX_INBOUND_PLAN_ID'), // 入库计划ID
            'shipmentId'    => getenv('SELLFOX_SHIPMENT_ID') // 货件ID
        ];
        $response = InboundFacade::listTransportationOptions($params);
        var_dump($response);
        // {"code":0,"msg":"","data":[{"carrier":{"alphaCode":null,"name":"Other"},"carrierAppointment":null,"preconditions":["CONFIRMED_DELIVERY_WINDOW"],"quote":null,"shipmentId":"shab88530d-ff44-4f7a-a914-813a6dd9fbd2","shippingMode":"FREIGHT_LTL","shippingSolution":"USE_YOUR_OWN_CARRIER","transportationOptionId":"to8f776eac-8b9a-46c2-b71c-55085579791a"},{"carrier":{"alphaCode":null,"name":"Other"},"carrierAppointment":null,"preconditions":["CONFIRMED_DELIVERY_WINDOW"],"quote":null,"shipmentId":"shab88530d-ff44-4f7a-a914-813a6dd9fbd2","shippingMode":"GROUND_SMALL_PARCEL","shippingSolution":"USE_YOUR_OWN_CARRIER","transportationOptionId":"to9d9febb0-f4df-4ff3-93f4-29e6b5e9fba0"},{"carrier":{"alphaCode":"UPSN","name":"UNITED PARCEL SERVICE INC"},"carrierAppointment":null,"preconditions":["CONFIRMED_DELIVERY_WINDOW"],"quote":null,"shipmentId":"shab88530d-ff44-4f7a-a914-813a6dd9fbd2","shippingMode":"GROUND_SMALL_PARCEL","shippingSolution":"USE_YOUR_OWN_CARRIER","transportationOptionId":"toe2a58c1a-3f6c-47d5-9e26-9a6422107192"}],"requestId":"1568335d-3219-475f-8e69-37b4fd42dad7"}
        // {"code":0,"msg":"","data":[{"carrier":{"alphaCode":"UPSN","name":"UNITED PARCEL SERVICE INC"},"carrierAppointment":null,"preconditions":["CONFIRMED_DELIVERY_WINDOW"],"quote":null,"shipmentId":"sh199038e4-e7d4-48ba-b4a1-bcd8b3b08634","shippingMode":"GROUND_SMALL_PARCEL","shippingSolution":"USE_YOUR_OWN_CARRIER","transportationOptionId":"to6041dda9-9db7-41c9-ac2d-7a0cbdeae5d7"},{"carrier":{"alphaCode":null,"name":"Other"},"carrierAppointment":null,"preconditions":["CONFIRMED_DELIVERY_WINDOW"],"quote":null,"shipmentId":"sh199038e4-e7d4-48ba-b4a1-bcd8b3b08634","shippingMode":"FREIGHT_LTL","shippingSolution":"USE_YOUR_OWN_CARRIER","transportationOptionId":"to6e6ca646-af29-4caa-89c7-9abbdba7c6e9"},{"carrier":{"alphaCode":null,"name":"Other"},"carrierAppointment":null,"preconditions":["CONFIRMED_DELIVERY_WINDOW"],"quote":null,"shipmentId":"sh199038e4-e7d4-48ba-b4a1-bcd8b3b08634","shippingMode":"GROUND_SMALL_PARCEL","shippingSolution":"USE_YOUR_OWN_CARRIER","transportationOptionId":"toaab6f831-fe1f-4090-b4a9-684589ad49ca"}],"requestId":"fb01842a-41a8-4af7-938f-b9fde124833c"}
        // 返回
        //  transportationOptionId 运输方案ID   (需要匹配 shippingMode->GROUND_SMALL_PARCEL carrier->name->Other preconditions->CONFIRMED_DELIVERY_WINDOW)
        $this->assertNotEmpty($response);
    }

    /**
     * 3.6 获取预计送达时间窗口
     * @return void
     */
    public function testDeliveryGetOptions()
    {
        /** 查询预计送达时间窗口 **/
        $params   = [
            'inboundPlanId' => getenv('SELLFOX_INBOUND_PLAN_ID'), // 入库计划ID
            'shipmentId'    => getenv('SELLFOX_SHIPMENT_ID') // 货件ID
        ];
        $response = InboundFacade::listDeliveryWindowOptions($params);
        var_dump($response);
        // {"code":0,"msg":"","data":[{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw8139f8c9-4bbd-474f-a99b-1853c77d6f95","endDate":"2025-08-25T00:00Z","startDate":"2025-08-11T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwfa080c42-0c4c-423e-846b-2cbd94d09b28","endDate":"2025-08-26T00:00Z","startDate":"2025-08-12T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw663df476-9e3f-4022-8805-0228e2523726","endDate":"2025-08-27T00:00Z","startDate":"2025-08-13T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwdf72db6d-0814-4d99-8fb4-aaba99ff8b78","endDate":"2025-08-28T00:00Z","startDate":"2025-08-14T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwa48483f2-fcaa-4ad6-bfcd-904d431eb40e","endDate":"2025-08-29T00:00Z","startDate":"2025-08-15T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw0ff3f87a-d569-45b0-a1da-eac6139fcf53","endDate":"2025-08-30T00:00Z","startDate":"2025-08-16T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw124e97bd-f454-45e7-b0f7-fa7443aab01d","endDate":"2025-08-31T00:00Z","startDate":"2025-08-17T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw4233e73e-a9a0-4066-b27f-fab4821bebf9","endDate":"2025-09-01T00:00Z","startDate":"2025-08-18T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw3cc4b433-0a8a-42db-b195-bf2e03c8fb39","endDate":"2025-09-02T00:00Z","startDate":"2025-08-19T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw8a06ac6a-447c-4403-84cc-c8a51f394036","endDate":"2025-09-03T00:00Z","startDate":"2025-08-20T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwaf2efc56-dd88-4432-b5b8-11b3c9190c07","endDate":"2025-09-04T00:00Z","startDate":"2025-08-21T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwceba9b91-e7ac-402b-bb2f-7a6b7d12fe21","endDate":"2025-09-05T00:00Z","startDate":"2025-08-22T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw5d37441f-91a6-4f93-8c48-f742cf2bd544","endDate":"2025-09-06T00:00Z","startDate":"2025-08-23T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwa35f228c-60f4-41ab-8eee-26db0e781230","endDate":"2025-09-07T00:00Z","startDate":"2025-08-24T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwb0273743-5d35-4bf2-b0f1-d054db758dd0","endDate":"2025-09-08T00:00Z","startDate":"2025-08-25T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwebbc0abb-487d-4631-8e0b-c885a106c21d","endDate":"2025-09-09T00:00Z","startDate":"2025-08-26T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw5f825dad-6e47-4d81-8379-d1a3b85cb934","endDate":"2025-09-10T00:00Z","startDate":"2025-08-27T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw1f7a33ef-ab42-42df-9520-14b130ccf4be","endDate":"2025-09-11T00:00Z","startDate":"2025-08-28T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw1e0824b6-10af-4563-9730-3e5e5b832ebb","endDate":"2025-09-12T00:00Z","startDate":"2025-08-29T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw8da9e7af-b035-454f-bfbb-b153041db3ab","endDate":"2025-09-13T00:00Z","startDate":"2025-08-30T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw1040c1d2-ff9a-4301-89f8-d5d4b8af20f6","endDate":"2025-09-14T00:00Z","startDate":"2025-08-31T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw27005681-a881-46f1-9348-5b9bd9722fc5","endDate":"2025-09-15T00:00Z","startDate":"2025-09-01T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw35695336-4a9c-4e3d-a260-05200b692351","endDate":"2025-09-16T00:00Z","startDate":"2025-09-02T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw94fde444-358b-462f-949c-f7daa997b80c","endDate":"2025-09-17T00:00Z","startDate":"2025-09-03T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw167aa00f-ab2d-4882-920d-49645ea9ee98","endDate":"2025-09-18T00:00Z","startDate":"2025-09-04T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwf7fb9a0e-91e5-40b9-9e3f-89aa01458308","endDate":"2025-09-19T00:00Z","startDate":"2025-09-05T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwbb556365-dac2-4791-8527-94c52974b03d","endDate":"2025-09-20T00:00Z","startDate":"2025-09-06T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw51691ded-96bd-4ff7-8015-ea87fdff26b7","endDate":"2025-09-21T00:00Z","startDate":"2025-09-07T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw9a6ce41f-645a-4192-8b33-151ab1722102","endDate":"2025-09-22T00:00Z","startDate":"2025-09-08T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwd483913a-e786-4cc8-a226-ebec6ca5d2d2","endDate":"2025-09-23T00:00Z","startDate":"2025-09-09T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw6827866e-c0ae-4d0b-a7cc-e203cb5d0611","endDate":"2025-09-24T00:00Z","startDate":"2025-09-10T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw77e37c20-544f-4825-9992-0d6b05fc34db","endDate":"2025-09-25T00:00Z","startDate":"2025-09-11T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw6f69e898-e068-4b9c-99b3-7aab53a7951f","endDate":"2025-09-26T00:00Z","startDate":"2025-09-12T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwc8e58a49-3f0e-49b2-8575-697cf7f8d30e","endDate":"2025-09-27T00:00Z","startDate":"2025-09-13T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw3f597613-ac6e-4696-b63a-df1c59894c4b","endDate":"2025-09-28T00:00Z","startDate":"2025-09-14T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwaabf1702-100b-4e41-bfa9-e5ba1e3bc7fb","endDate":"2025-09-29T00:00Z","startDate":"2025-09-15T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw501b11e7-700b-4bb8-9dcb-8102185a7f5a","endDate":"2025-09-30T00:00Z","startDate":"2025-09-16T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwc1171657-0e83-4aff-af51-344fd62e4a74","endDate":"2025-10-01T00:00Z","startDate":"2025-09-17T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwd3b8b3ee-73fa-4107-a580-d000b3b2ca2b","endDate":"2025-10-02T00:00Z","startDate":"2025-09-18T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwf9cd38b7-7fc8-471a-9ce2-806eb2953b07","endDate":"2025-10-03T00:00Z","startDate":"2025-09-19T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwc839712c-96e9-4c99-bfb5-2c6c29ecef45","endDate":"2025-10-04T00:00Z","startDate":"2025-09-20T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwbca19edf-9532-47ae-8e85-286f0d3a9706","endDate":"2025-10-05T00:00Z","startDate":"2025-09-21T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw359ecfd6-ef8f-48e8-b131-a680fd87479b","endDate":"2025-10-06T00:00Z","startDate":"2025-09-22T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw82c48230-5f76-4b52-b586-55286e3eab16","endDate":"2025-10-07T00:00Z","startDate":"2025-09-23T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw69123e0a-019a-4e66-bca6-009552f0693a","endDate":"2025-10-08T00:00Z","startDate":"2025-09-24T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwcfa6f1ef-5cb1-4d63-bc33-a4d38c9524a9","endDate":"2025-10-09T00:00Z","startDate":"2025-09-25T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw1b11981f-f5c5-4635-ad53-9ae33d365986","endDate":"2025-10-10T00:00Z","startDate":"2025-09-26T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw0673e871-a406-4f1c-903a-affd62f0559d","endDate":"2025-10-11T00:00Z","startDate":"2025-09-27T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw180f36ff-c6fb-4206-a041-97296e98f3d9","endDate":"2025-10-12T00:00Z","startDate":"2025-09-28T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwf8234f5f-4b6e-44ba-af5c-1feb13b5b43c","endDate":"2025-10-13T00:00Z","startDate":"2025-09-29T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwa23c04f1-fa8c-47d6-b276-304635c4c6fd","endDate":"2025-10-14T00:00Z","startDate":"2025-09-30T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwc6a32b93-9372-4873-a1bc-67d1b7a88503","endDate":"2025-10-15T00:00Z","startDate":"2025-10-01T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw6f045d30-8343-40f9-8ec8-a474c5b111ae","endDate":"2025-10-16T00:00Z","startDate":"2025-10-02T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw8f0116f0-6ca3-4df2-858c-74cef3059848","endDate":"2025-10-17T00:00Z","startDate":"2025-10-03T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwd1650982-a4c8-4e78-82bf-8b1b3b4601d5","endDate":"2025-10-18T00:00Z","startDate":"2025-10-04T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw25d05a89-5d6f-45d9-866c-76e9637b186a","endDate":"2025-10-19T00:00Z","startDate":"2025-10-05T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw0779da07-5c03-4d65-8741-6c92d8e1e32a","endDate":"2025-10-20T00:00Z","startDate":"2025-10-06T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw5e2f97bc-d7df-46fe-8b55-ffa0e9ca3eb0","endDate":"2025-10-21T00:00Z","startDate":"2025-10-07T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw67a05321-bf6e-4e0d-97b8-c66f96cb79d2","endDate":"2025-10-22T00:00Z","startDate":"2025-10-08T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwef2d8e71-bdde-4427-a03e-f7a6504dfbcf","endDate":"2025-10-23T00:00Z","startDate":"2025-10-09T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw11116f9b-476d-493f-a4f6-903879aaf80c","endDate":"2025-10-24T00:00Z","startDate":"2025-10-10T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw7b66f992-72b0-454d-b3b0-787d99329ad5","endDate":"2025-10-25T00:00Z","startDate":"2025-10-11T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw59121135-c8f1-4aee-a868-6439f22be954","endDate":"2025-10-26T00:00Z","startDate":"2025-10-12T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dw23fa3e71-5be8-4fd8-8526-5fe3fe80d4f5","endDate":"2025-10-27T00:00Z","startDate":"2025-10-13T00:00Z","validUntil":"2025-08-11T03:57Z"},{"availabilityType":"AVAILABLE","deliveryWindowOptionId":"dwf5380d76-2b63-418a-8f62-597596a09cbd","endDate":"2025-10-28T00:00Z","startDate":"2025-10-14T00:00Z","validUntil":"2025-08-11T03:57Z"}],"requestId":"4e635034-5ea6-4f77-b010-c9f4737b88f5"}
        // 返回
        //  deliveryWindowOptionId 预计送达时间窗口ID (匹配选择最近区间)
        $this->assertNotEmpty($response);
    }


    /**
     * 4.1 确认入库配置选项(订单创建)
     * @return void
     */
    public function testConfirmPlacement()
    {
        /** 确认入库配置选项 亚马逊生成完成**/
        $params   = [
            'inboundPlanId'     => getenv('SELLFOX_INBOUND_PLAN_ID'), // 入库计划ID
            'placementOptionId' => getenv('SELLFOX_PLACEMENT_OPTION_ID'), // 配置选项ID
        ];
        $response = InboundFacade::confirmPlacementOption($params);
        if ($taskId = $response['taskId'] ?? '') {
            echo date('Y-m-d H:i:s') . ' confirmPlacementOption ' . $taskId . PHP_EOL;
            $response = $this->getInboundTaskProcess($taskId);
            // 确认入库配置选项成功
            $inboundPlanId = $response['inboundPlanId'] ?? '';
            $taskStatus    = $response['taskStatus'] ?? '';
            $msg           = $response['msg'] ?? '';
            echo date('Y-m-d H:i:s') . " inboundPlanId:{$inboundPlanId} taskStatus:{$taskStatus} msg:{$msg}" . PHP_EOL;
            $this->assertNotEmpty($response);
        } else {
            $this->fail('失败：confirmPlacementOption');
        }
    }

    /**
     * 4.2 确认预计送达时间窗口
     * @return void
     */
    public function testConfirmDeliveryWindow()
    {
        /** 确认预计送达时间窗口 **/
        $params   = [
            'inboundPlanId'          => getenv('SELLFOX_INBOUND_PLAN_ID'), // 入库计划ID
            'shipmentId'             => getenv('SELLFOX_SHIPMENT_ID'), // 货件ID
            'deliveryWindowOptionId' => getenv('SELLFOX_DELIVERY_WINDOW_OPTION_ID') // 配送时间窗口选项ID
        ];
        $response = InboundFacade::confirmDeliveryWindowOptions($params);
        if ($taskId = $response['taskId'] ?? '') {
            echo date('Y-m-d H:i:s') . ' confirmDeliveryWindowOptions ' . $taskId . PHP_EOL;
            $response = $this->getInboundTaskProcess($taskId);
            // 确认预计送达时间窗口成功
            $inboundPlanId = $response['inboundPlanId'] ?? '';
            $taskStatus    = $response['taskStatus'] ?? '';
            $msg           = $response['msg'] ?? '';
            echo date('Y-m-d H:i:s') . " inboundPlanId:{$inboundPlanId} taskStatus:{$taskStatus} msg:{$msg}" . PHP_EOL;
            $this->assertNotEmpty($response);
        } else {
            $this->fail('失败：confirmDeliveryWindowOptions');
        }
    }

    /**
     * 4.3 确认运输承运人选项
     * @return void
     */
    public function testConfirmTransportation()
    {
        /** 确认运输承运人选项 **/
        $params   = [
            'inboundPlanId'            => getenv('SELLFOX_INBOUND_PLAN_ID'), // 入库计划ID
            'transportationSelections' => [
                [
                    'shipmentId'             => getenv('SELLFOX_SHIPMENT_ID'), // 货件ID
                    'transportationOptionId' => getenv('SELLFOX_TRANSPORTATION_OPTION_ID') // 运输方案ID
                ]
            ],
        ];
        $response = InboundFacade::confirmTransportationOptions($params);
        if ($taskId = $response['taskId'] ?? '') {
            echo date('Y-m-d H:i:s') . ' confirmTransportationOptions ' . $taskId . PHP_EOL;
            $response = $this->getInboundTaskProcess($taskId);
            // 确认运输承运人选项成功
            $inboundPlanId = $response['inboundPlanId'] ?? '';
            $taskStatus    = $response['taskStatus'] ?? '';
            $msg           = $response['msg'] ?? '';
            echo date('Y-m-d H:i:s') . " inboundPlanId:{$inboundPlanId} taskStatus:{$taskStatus} msg:{$msg}" . PHP_EOL;
            $this->assertNotEmpty($response);
        } else {
            $this->fail('失败：confirmTransportationOptions');
        }
    }

    /**
     * 5.1 查询地址 为查询到地址信息
     * @return void
     */
    public function testGetAddress()
    {
        /** 查询地址 **/
        $params   = [
            'inboundPlanId' => getenv('SELLFOX_INBOUND_PLAN_ID'), // 入库计划ID
            'shipmentId'    => getenv('SELLFOX_SHIPMENT_ID') // 货件ID
        ];
        $response = InboundFacade::getShipment($params);
        var_dump($response);
        // {"code":0,"msg":"success","data":{"inboundPlanId":"wf23f189d6-9d2c-4707-8c53-6e5035f17865","marketplaceId":"A1C3SOZRARQ6R3","shopId":407598,"amazonShipmentId":"FBA15KPQNL8Z","shipmentId":"shab88530d-ff44-4f7a-a914-813a6dd9fbd2","name":"FBA STA (11/08/2025 03:25)-WRO5","status":"WORKING","referenceId":"","contactInformation":{"email":"","name":"MEOWOW OÜ","phoneNumber":"+447846911660"},"shipmentDestination":{"destination":{"name":"Amazon Fulfillment Poland sp. z o.o.","addressLine1":"Okmiany","addressLine2":"Chojnow","city":"Okmiany","districtOrCounty":null,"stateOrProvinceCode":"Dolnoslaskie voivodeship","countryCode":"PL","postalCode":"59-225","email":null,"phoneNumber":null,"companyName":null},"fulfillmentCenterId":"WRO5"},"source":{"name":"MEOWOW OÜ","addressLine1":"Narva mnt 7-634","addressLine2":null,"city":"Harju maakond","districtOrCounty":null,"stateOrProvinceCode":"Tallinn, Kesklinna linnaosa,","countryCode":"EE","postalCode":"10117","email":null,"phoneNumber":"+447846911660","companyName":"MEOWOW OÜ"},"shippedDate":null,"createTime":"2025-08-11 11:25:40","updateTime":"2025-08-11 11:28:51"},"requestId":"93fb6758-fa2a-4120-8fd4-bb06d036cf24"}
        // shipmentDestination 亚马逊地址
        $this->assertNotEmpty($response);
    }

    /**
     * 取消计划
     * @return void
     */
    public function testCancelInboundPlan()
    {
        /** 取消入库计划 **/
        $params   = [
            'inboundPlanId' => getenv('SELLFOX_INBOUND_PLAN_ID'), // 入库计划ID
        ];
        $response = InboundFacade::cancelInboundPlan($params);
        if ($taskId = $response['taskId'] ?? '') {
            echo date('Y-m-d H:i:s') . ' cancelInboundPlan ' . $taskId . PHP_EOL;
            $response = $this->getInboundTaskProcess($taskId);
            // {"code":0,"msg":"success","data":{"inboundPlanId":"wf23f189d6-9d2c-4707-8c53-6e5035f17865","taskId":"0cbd144af2554538805e9e559dcfd0b0","taskStatus":"SUCCESS","msg":"入库计划取消成功","createDate":1754884168641},"requestId":"b07c6746-a4dd-4946-b5c8-9c3dddb1074b"}
            $inboundPlanId = $response['inboundPlanId'] ?? '';
            $taskStatus    = $response['taskStatus'] ?? '';
            $msg           = $response['msg'] ?? '';
            echo date('Y-m-d H:i:s') . " inboundPlanId:{$inboundPlanId} taskStatus:{$taskStatus} msg:{$msg}" . PHP_EOL;
            $this->assertNotEmpty($response);
        } else {
            $this->fail('失败：cancelInboundPlan');
        }
    }


}