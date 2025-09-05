<?php

namespace Exewen\Sellfox\Middleware;

use Exewen\Sellfox\Exception\SellfoxException;
use Psr\Http\Message\RequestInterface;

/**
 * 滑动窗口限流器
 */
class SlidingWindowLimiterMiddleware
{

    /**
     * 窗口大小（秒）
     * @var int
     */
    private $windowSize;

    /**
     * 窗口内允许的最大请求数
     * @var int
     */
    private $limit;

    /**
     * 存储请求时间戳的数组
     * @var array
     */
    private $requestTimestamps = [];

    // 测试用
    public function __construct($windowSize, $limit, $shards = 1)
    {
        if (!is_int($limit / $shards)) {
            throw new SellfoxException("最大请求数需要被区间分片数整除");
        }
        $this->windowSize = $windowSize / $shards;
        $this->limit      = $limit / $shards;
    }

//    public function __construct(string $channel, array $config)
//    {
//
//    }

    public function __invoke(callable $handler): callable
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            $path = $request->getUri()->getPath();
            // 1.0 独占锁
            // 2.0限流策略 - 检测
            $this->requestWithLimiter($path);
            return $handler($request, $options);
            // 3.0独占锁 解锁
        };
    }

    /**
     * API请求限流
     * @param string $uniqueKey
     * @return bool
     */
    public function requestWithLimiter(string $uniqueKey)
    {
        $now = microtime(true);
        // 移除窗口外的请求时间戳
        $requestTimestamps = $this->removeOldTimestamps($uniqueKey, $now);

        // 检查当前请求是否超过限制
        if (count($requestTimestamps) >= $this->limit) {
            return false;
        }

        // 记录当前请求时间戳
        $requestTimestamps[] = $now;
        $this->setRequestTimestamps($uniqueKey, $requestTimestamps);
        return true;
    }

    /**
     * 移除窗口外的请求时间戳
     * @param $uniqueKey
     * @param $now
     * @return mixed
     */
    private function removeOldTimestamps($uniqueKey, $now)
    {
        $threshold         = $now - $this->windowSize;
        $requestTimestamps = $this->getRequestTimestamps($uniqueKey);
        foreach ($requestTimestamps as $key => $timestamp) {
            if ($timestamp < $threshold) {
                unset($requestTimestamps[$key]);
            }
        }
        // 重新索引数组
        return $this->setRequestTimestamps($uniqueKey, array_values($requestTimestamps));
    }

    /**
     * 获取限流数据
     * @param string $uniqueKey
     * @return array|mixed
     */
    private function getRequestTimestamps(string $uniqueKey)
    {
        return $this->requestTimestamps[$uniqueKey] ?? [];
    }

    /**
     * 设置限流数据
     * @param string $uniqueKey
     * @param $requestTimestamps
     * @return mixed
     */
    private function setRequestTimestamps(string $uniqueKey, $requestTimestamps)
    {
        $this->requestTimestamps[$uniqueKey] = $requestTimestamps;
        return $requestTimestamps;
    }

}