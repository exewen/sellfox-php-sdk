<?php

namespace Exewen\Sellfox\Middleware;

use Psr\Http\Message\RequestInterface;

/**
 * 简单处理限流 复杂场景可切换为redis进行处理(todo)
 */
class RateLimiterMiddleware
{

    private static $lastRequestTimes;
    private $timeLimit = 1.1;

    public function __construct(string $channel, array $config)
    {
    }

    public function __invoke(callable $handler): callable
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            $path = $request->getUri()->getPath();
            // 限流策略 - 检测
            $this->requestWithLimiter($path);
            return $handler($request, $options);
        };
    }

    public function requestWithLimiter(string $uri): void
    {
        $currentTime = microtime(true);

        if ($this->hasLimiter($uri)) {
            $timeInterval = $this->getTimeInterval($uri, $currentTime);
            // 如果时间差小于 1 秒，使用微秒级的延迟进行等待
            while ($timeInterval <= $this->timeLimit) {
                // 休眠 10 毫秒（10000 微秒）
                usleep(10000);
                $currentTime  = microtime(true);
                $timeInterval = $this->getTimeInterval($uri, $currentTime);
            }
        }

        $this->setLimiter($uri, microtime(true));

    }

    private function hasLimiter(string $uri): bool
    {
        return isset(self::$lastRequestTimes[$uri]);
    }

    private function getLimiter(string $uri)
    {
        return self::$lastRequestTimes[$uri];
    }

    private function setLimiter(string $uri, $setMicroTime)
    {

        self::$lastRequestTimes[$uri] = $setMicroTime;
    }

    private function getTimeInterval(string $uri, $currentTime)
    {
        return $currentTime - $this->getLimiter($uri);
    }


}