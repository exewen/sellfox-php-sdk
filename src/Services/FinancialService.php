<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Services;

use Exewen\Config\Contract\ConfigInterface;
use Exewen\Http\Contract\HttpClientInterface;
use Exewen\Sellfox\Constants\SellfoxEnum;
use Exewen\Sellfox\Contract\FinancialInterface;

class FinancialService extends BaseService implements FinancialInterface
{
    private $httpClient;
    private $driver;

    public function __construct(HttpClientInterface $httpClient, ConfigInterface $config)
    {
        $this->httpClient = $httpClient;
        $this->driver     = $config->get('sellfox.' . SellfoxEnum::CHANNEL_API);
    }

    public function getShippingSettlement(array $params, array $header = []): array
    {
        $response = $this->httpClient->post($this->driver, '/api/financial/shippingSettlementPageList.json', $params);
        $result   = json_decode($response, true);
        $this->checkResponse($result);
        return $result['data'];
    }


}