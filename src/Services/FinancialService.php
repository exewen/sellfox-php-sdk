<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Services;

use Exewen\Config\Contract\ConfigInterface;
use Exewen\Http\Contract\HttpClientInterface;
use Exewen\Sellfox\Contract\AuthInterface;
use Exewen\Sellfox\Exception\SellfoxException;

class FinancialService implements AuthInterface
{
    private $httpClient;
    private $driver;
    private $tokenUrl = '/api/oauth/v2/token.json';

    public function __construct(HttpClientInterface $httpClient, ConfigInterface $config)
    {
        $this->httpClient = $httpClient;
        $this->driver     = $config->get('sellfox.channel_api');
    }

    public function getToken(string $clientId, string $clientSecret): string
    {
        $params   = [
            'client_id'     => $clientId,
            'client_secret' => $clientSecret,
            'grant_type'    => 'client_credentials',
        ];
        $response = $this->httpClient->get($this->driver, $this->tokenUrl, $params);
        $result   = json_decode($response);
        if (!isset($result['data']['access_token'])) {
            throw new SellfoxException('Sellfox:' . __FUNCTION__ . '异常');
        }
        return $result['data'];
    }


}