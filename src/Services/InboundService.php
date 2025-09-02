<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Services;

use Exewen\Config\Contract\ConfigInterface;
use Exewen\Http\Contract\HttpClientInterface;
use Exewen\Sellfox\Constants\SellfoxEnum;
use Exewen\Sellfox\Contract\InboundInterface;

class InboundService extends BaseService implements InboundInterface
{
    private $httpClient;
    private $driver;

    public function __construct(HttpClientInterface $httpClient, ConfigInterface $config)
    {
        $this->httpClient = $httpClient;
        $this->driver     = $config->get('sellfox.' . SellfoxEnum::CHANNEL_API);
    }

    /**
     * 创建入库计划
     * @param array $params
     * @param array $header
     * @return array
     */
    public function createInboundPlan(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/inbound/createInboundPlan.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    /**
     * 查询异步任务状态
     * @param string $task_id
     * @param array $header
     * @return array
     */
    public function taskProcess(string $task_id, array $header = []): array
    {
        $params   = [
            'taskId' => $task_id
        ];
        $response = $this->httpClient->post($this->driver, '/api/inbound/taskProcess.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function generatePackingOptions(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/inbound/generatePackingOptions.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function listPackingOptions(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/inbound/listPackingOptions.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function listPackingGroupItems(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/inbound/listPackingGroupItems.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function confirmPackingOption(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/inbound/confirmPackingOption.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function setPackingInformation(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/inbound/setPackingInformation.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function generatePlacementOptions(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/inbound/generatePlacementOptions.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function generateTransportationOptions(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/inbound/generateTransportationOptions.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function generateDeliveryWindowOptions(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/inbound/generateDeliveryWindowOptions.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function listPlacementOptions(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/inbound/listPlacementOptions.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function listTransportationOptions(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/inbound/listTransportationOptions.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function listDeliveryWindowOptions(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/inbound/listDeliveryWindowOptions.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function confirmPlacementOption(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/inbound/confirmPlacementOption.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function confirmDeliveryWindowOptions(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/inbound/confirmDeliveryWindowOption.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function confirmTransportationOptions(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/inbound/confirmTransportOption.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function getLabels(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/inbound/getLabels.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function getBillOfLading(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/inbound/getBillOfLading.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function updateShipmentTrackingDetails(array $params, array $header = [])
    {
        $response = $this->httpClient->post($this->driver, '/api/inbound/putTrackingDetails.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function getShipment(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/inbound/shipment/detail.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }


    public function cancelInboundPlan(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/inbound/cancelInboundPlan.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function getInboundPlanList(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/inbound/plan/page.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function getInboundPlanDetail(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/inbound/getInboundPlan.json', $params, $header);
        $contents = $response->getBody()->getContents();
        $result   = json_decode($contents, true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }


}