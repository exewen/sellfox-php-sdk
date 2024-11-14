<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Middleware;

use Psr\Http\Message\RequestInterface;

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
            $modifiedRequest = $request
                ->withHeader('x-api-key', $this->config['extra']['api_key'] ?? '')
                ->withHeader('x-thirdparty-name', $this->config['extra']['third_party_name'] ?? '');
            return $handler($modifiedRequest, $options);
        };
    }


}