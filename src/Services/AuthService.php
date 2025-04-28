<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Services;

use Exewen\Config\Contract\ConfigInterface;
use Exewen\Http\Contract\HttpClientInterface;
use Exewen\Sellfox\Constants\SellfoxEnum;
use Exewen\Sellfox\Contract\AuthInterface;
use Exewen\Sellfox\Exception\SellfoxException;

class AuthService implements AuthInterface
{
    private $httpClient;
    private $driver;
    private $config;

    public function __construct(HttpClientInterface $httpClient, ConfigInterface $config)
    {
        $this->httpClient = $httpClient;
        $this->driver     = $config->get('sellfox.' . SellfoxEnum::CHANNEL_AUTH);
        $this->config     = $config;
    }

    public function getToken(string $clientId, string $clientSecret): array
    {
        $params   = [
            'client_id'     => $clientId,
            'client_secret' => $clientSecret,
            'grant_type'    => 'client_credentials',
        ];
        $response = $this->httpClient->get($this->driver, '/api/oauth/v2/token.json', $params);
        $result   = json_decode($response->getBody()->getContents(), true);
        if (!isset($result['data']['access_token'])) {
            throw new SellfoxException('Sellfox:' . __FUNCTION__ . '异常');
        }
        return $result['data'] ?? [];
    }


    public function setAuth(string $clientId, string $clientSecret, string $accessToken, string $channel = SellfoxEnum::CHANNEL_API)
    {
        $this->config->set('http.channels.' . $channel . '.extra.client_id', $clientId);
        $this->config->set('http.channels.' . $channel . '.extra.client_secret', $clientSecret);
        $this->config->set('http.channels.' . $channel . '.extra.access_token', $accessToken);
    }

}