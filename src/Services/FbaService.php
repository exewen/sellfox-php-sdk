<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Services;

use Exewen\Config\Contract\ConfigInterface;
use Exewen\Http\Contract\HttpClientInterface;

class FbaService
{
    private $httpClient;
    private $driver;
    private $setShipmentsUrl = '/v1/shipments';

    public function __construct(HttpClientInterface $httpClient, ConfigInterface $config)
    {
        $this->httpClient = $httpClient;
        $this->driver     = $config->get('sellfox.channel_api');
    }


    public function setShipments(array $params, array $header)
    {
        $result = $this->httpClient->post($this->driver, $this->setShipmentsUrl, $params, $header);
        return json_decode($result, true);
    }

}