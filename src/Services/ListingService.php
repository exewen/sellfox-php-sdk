<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Services;

use Exewen\Config\Contract\ConfigInterface;
use Exewen\Http\Contract\HttpClientInterface;
use Exewen\Sellfox\Constants\SellfoxEnum;
use Exewen\Sellfox\Contract\ListingInterface;

class ListingService extends BaseService implements ListingInterface
{
    private $httpClient;
    private $driver;

    public function __construct(HttpClientInterface $httpClient, ConfigInterface $config)
    {
        $this->httpClient = $httpClient;
        $this->driver     = $config->get('sellfox.' . SellfoxEnum::CHANNEL_API);
    }

    public function getListing(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/order/api/product/pageList.json', $params, $header);
        $result   = json_decode($response->getBody()->getContents(), true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }
}