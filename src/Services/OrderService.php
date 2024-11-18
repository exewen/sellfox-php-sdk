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

    public function __construct(HttpClientInterface $httpClient, ConfigInterface $config)
    {
        $this->httpClient = $httpClient;
        $this->driver     = $config->get('sellfox.' . SellfoxEnum::CHANNEL_API);
    }

    public function getOrder(array $params, array $header = []): string
    {
        $response = $this->httpClient->post($this->driver, '/api/order/pageList.json', $params, $header);
        $result   = json_decode($response);
        $this->checkResponse($result);
        return $result['data'];
    }

    public function getOrderDetail(string $shopId, string $amazonOrderId, array $header = []): string
    {
        $params   = [
            'shopId'        => $shopId,
            'amazonOrderId' => $amazonOrderId,
        ];
        $response = $this->httpClient->post($this->driver, '/api/order/detailByOrderId.json', $params, $header);
        $result   = json_decode($response);
        $this->checkResponse($result);
        return $result['data'];
    }

    public function orderMark(array $params, array $header = []): string
    {
        $response = $this->httpClient->post($this->driver, '/api/feed/submitFeed.json', $params, $header);
        $result   = json_decode($response);
        $this->checkResponse($result);
        return $result['data'];
    }

    public function getOrderMarkResult(array $params, array $header = []): string
    {
        $response = $this->httpClient->post($this->driver, '/api/feed/getFeedResponse.json', $params, $header);
        $result   = json_decode($response);
        $this->checkResponse($result);
        return $result['data'];
    }

    public function getFbaReturn(array $params, array $header = [])
    {
        $response = $this->httpClient->post($this->driver, '/api/order/api/report/fbaReturn/pageList.json', $params, $header);
        $result   = json_decode($response);
        $this->checkResponse($result);
        return $result['data'];
    }

}