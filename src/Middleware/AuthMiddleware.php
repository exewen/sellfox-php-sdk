<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Middleware;

use Cassandra\Uuid;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Psr7\Uri;

class AuthMiddleware
{
//    private string $config;
    private $config;
    private $channel;

    public function __construct(string $channel, array $config)
    {
        $this->channel = $channel;
        $this->config  = $config;
    }

    public function __invoke(callable $handler): callable
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            $accessToken = $this->config['extra']['access_token'] ?? '';
            $clientId    = $this->config['extra']['client_id'] ?? '';
            $timestamp   = $this->getMillisTimestamp();
            $nonce       = $this->generateNonce();
            $method      = $request->getMethod();
            $uri         = $request->getUri()->getPath();
            $sign        = $this->getSign($accessToken, $clientId, $method, $nonce, $timestamp, $uri);
            $queryParams = [
                'access_token' => $accessToken,
                'client_id'    => $clientId,
                'timestamp'    => $timestamp,
                'nonce'        => $nonce,
                'sign'         => $sign,
            ];

            $uri                = $request->getUri();
            $currentQueryParams = [];
            parse_str($uri->getQuery(), $currentQueryParams);
            // 合并uri参数
            $newQueryParams  = array_merge($currentQueryParams, $queryParams);
            $modifiedRequest = $request->withUri($uri->withQuery(http_build_query($newQueryParams)));
            return $handler($modifiedRequest, $options);
        };
    }

    private function getMillisTimestamp(): int
    {
        // 获取当前时间戳（包括微秒）
        list($microSeconds, $seconds) = explode(' ', microtime());

        // 将秒和微秒部分合并成一个整数，表示毫秒时间戳
        return ($seconds * 1000) + (int)round($microSeconds * 1000);
    }

    private function getSign(string $accessToken, $clientId, string $method, int $nonce, int $timestamp, $uri): string
    {
        $clientSecret = $this->config['extra']['client_secret'] ?? '';
        $method       = strtolower($method);
        $nonce        = strval($nonce);
        $timestamp    = strval($timestamp);
        $method       = strtolower($method);

        // 签名测试数据 - 文档对应
//        $clientId     = '1111111';
//        $clientSecret = 'fde212ff-588a-11ef-b1d4-0c42a1eda3d9';
//        $accessToken  = 'd20d9d20-5db0-429a-8390-3694265e297c';
//        $timestamp    = '1668153260508';
//        $nonce        = '888';
//        $uri          = '/openapi/api/commodity/pageList.json';

        $params = [
            'access_token' => $accessToken,
            'client_id'    => $clientId,
            'method'       => $method,
            'nonce'        => $nonce,
            'timestamp'    => $timestamp,
        ];
        ksort($params);
        $query = http_build_query($params) . '&url=' . $uri;
        $sign  = $this->hmacSha256($query, $clientSecret);
        return $sign;
    }

    private function generateNonce($length = 10): int
    {
        $nonce      = '';
        $characters = '0123456789';
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = mt_rand(0, strlen($characters) - 1);
            $nonce       .= $characters[$randomIndex];
        }
        return intval($nonce);
    }

    private function hmacSha256($data, $key): string
    {
        $hash = hash_hmac('sha256', $data, $key, true); // 生成原始二进制数据
        return bin2hex($hash); // 将二进制数据转换为十六进制字符串
    }

}