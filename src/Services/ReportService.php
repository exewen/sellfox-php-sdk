<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Services;

use Exewen\Config\Contract\ConfigInterface;
use Exewen\Http\Contract\HttpClientInterface;
use Exewen\Sellfox\Constants\SellfoxEnum;
use Exewen\Sellfox\Contract\ReportInterface;

class ReportService extends BaseService implements ReportInterface
{
    private $httpClient;
    private $driver;

    public function __construct(HttpClientInterface $httpClient, ConfigInterface $config)
    {
        $this->httpClient = $httpClient;
        $this->driver     = $config->get('sellfox.' . SellfoxEnum::CHANNEL_API);
    }

    public function getFbaReturn(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/order/api/report/fbaReturn/pageList.json', $params);
        $result   = json_decode($response->getBody()->getContents(), true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }

    public function getFbaStorageFee(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/report/getFbaStorageFeePage.json', $params);
        $result   = json_decode($response->getBody()->getContents(), true);
        $this->checkResponse($result);
        return $result['data'] ?? [];
    }


}