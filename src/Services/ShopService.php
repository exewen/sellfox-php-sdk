<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Services;

use Exewen\Config\Contract\ConfigInterface;
use Exewen\Http\Contract\HttpClientInterface;
use Exewen\Sellfox\Constants\SellfoxEnum;
use Exewen\Sellfox\Contract\ShopInterface;

class ShopService extends BaseService implements ShopInterface
{
    private $httpClient;
    private $driver;

    public function __construct(HttpClientInterface $httpClient, ConfigInterface $config)
    {
        $this->httpClient = $httpClient;
        $this->driver     = $config->get('sellfox.' . SellfoxEnum::CHANNEL_API);
    }

    public function getShop(array $params): array
    {
        $response = $this->httpClient->post($this->driver, '/api/shop/pageList.json', $params);
        $result   = json_decode($response, true);
        $this->checkResponse($result);
        return $result['data'];
    }


}