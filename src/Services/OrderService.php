<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Services;

use Exewen\Config\Contract\ConfigInterface;
use Exewen\Http\Contract\HttpClientInterface;
use Exewen\Sellfox\Constants\SellfoxEnum;
use Exewen\Sellfox\Contract\OrderInterface;

class OrderService extends BaseService implements OrderInterface
{
    private $httpClient;
    private $driver;
    private $detailDriver;

    public function __construct(HttpClientInterface $httpClient, ConfigInterface $config)
    {
        $this->httpClient   = $httpClient;
        $this->driver       = $config->get('sellfox.' . SellfoxEnum::CHANNEL_API);
        $this->detailDriver = $config->get('sellfox.' . SellfoxEnum::CHANNEL_DETAIL_API);
    }

    public function getOrder(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/order/pageList.json', $params, $header);
        $result   = json_decode($response->getBody()->getContents(), true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function getOrderDetail(string $shopId, string $amazonOrderId, array $header = []): array
    {
        $params   = [
            'shopId'        => $shopId,
            'amazonOrderId' => $amazonOrderId,
        ];
        $response = $this->httpClient->post($this->detailDriver, '/api/order/detailByOrderId.json', $params, $header);
        $result   = json_decode($response->getBody()->getContents(), true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function getFmbOrder(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/packageShip/getPackagePage.json', $params, $header);
        $result   = json_decode($response->getBody()->getContents(), true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function getFmbOrderDetail(string $packageSn, array $header = []): array
    {
        $params   = [
            'packageSn' => $packageSn,
        ];
        $response = $this->httpClient->post($this->detailDriver, '/api/packageShip/packageDetail.json', $params, $header);
        $result   = json_decode($response->getBody()->getContents(), true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function submitToPlatform(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/packageShip/submitToPlatform.json', $params, $header);
        return json_decode($response->getBody()->getContents(), true);
    }


    public function getFbaReturn(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/order/api/report/fbaReturn/pageList.json', $params, $header);
        $result   = json_decode($response->getBody()->getContents(), true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

}