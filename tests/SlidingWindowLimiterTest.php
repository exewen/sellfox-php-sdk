<?php
declare(strict_types=1);

namespace ExewenTest\Sellfox;

use Exewen\Sellfox\Middleware\SlidingWindowLimiterMiddleware;

class SlidingWindowLimiterTest extends Base
{

    public function testSlidingWindowLimiter()
    {
        // 使用示例
        $windowSize = 1; // 窗口大小为 60 秒
        $limit      = 10; // 窗口内允许的最大请求数为 100
        $shards     = 10; // 区间分片数

        $bucket = new SlidingWindowLimiterMiddleware($windowSize, $limit, $shards);
        // 模拟 300 次请求 时间间隔 10ms 总耗时3s
        $start_time             = microtime(true);
        $countSuccess_financial = 0;
        $countSuccess_order     = 0;
        for ($i = 0; $i < 300; $i++) {
            $uri = '/api/settlementDetail/selectSettlementDetailPage.json';
            if ($bucket->requestWithLimiter($uri)) {
                $countSuccess_financial++;
                $start_at = round(microtime(true) - $start_time, 3);
                echo "请求 $i 被接受 Financial：$countSuccess_financial " . $start_at . PHP_EOL;
            } else {
                $start_at = round(microtime(true) - $start_time, 3);
                // 以下注释打开可以看到拒绝时序
                echo "          请求 $i 被拒绝 Financial" . $start_at . PHP_EOL;
            }

            $uri = '/api/order/pageList.json';
            if ($bucket->requestWithLimiter($uri)) {
                $countSuccess_order++;
                $start_at = round(microtime(true) - $start_time, 3);
                echo "请求 $i 被接受 Order：$countSuccess_order " . $start_at . PHP_EOL;
            } else {
                $start_at = round(microtime(true) - $start_time, 3);
                // 以下注释打开可以看到拒绝时序
                echo "          请求 $i 订单 Order " . $start_at . PHP_EOL;
            }
            // 模拟请求间隔 10ms
            usleep(10000);
        }
        $this->assertNotEmpty(true);
    }


}