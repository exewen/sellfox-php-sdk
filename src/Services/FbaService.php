<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Services;

use Exewen\Config\Contract\ConfigInterface;
use Exewen\Http\Contract\HttpClientInterface;
use Exewen\Sellfox\Constants\SellfoxEnum;
use Exewen\Sellfox\Contract\FbaInterface;

class FbaService extends BaseService implements FbaInterface
{
    private $httpClient;
    private $driver;
    private $setShipmentsUrl = '/v1/shipments';

    public function __construct(HttpClientInterface $httpClient, ConfigInterface $config)
    {
        $this->httpClient = $httpClient;
        $this->driver     = $config->get('sellfox.' . SellfoxEnum::CHANNEL_API);
    }


    public function deliveryPlanCreate(array $params, array $header = [])
    {
        $response = $this->httpClient->post($this->driver, '/api/fba/deliveryPlan/create.json', $params, $header);
        $result   = json_decode($response, true);
        $this->checkResponse($result);
        return $result['data'];
    }

    public function createShipment(array $params, array $header = [])
    {
        $response = $this->httpClient->post($this->driver, '/api/fbaShipment/createShipment.json', $params, $header);
        $result   = json_decode($response, true);
        $this->checkResponse($result);
        return $result['data'];
    }

}