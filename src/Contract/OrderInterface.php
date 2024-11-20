<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Contract;

interface OrderInterface
{
    public function getOrder(array $params, array $header = []);

    public function getOrderDetail(string $shopId, string $amazonOrderId, array $header = []);
    public function getFmbOrder(array $params, array $header = []);

    public function getFmbOrderDetail(string $packageSn, array $header = []);

    public function orderMark(array $params, array $header = []);

    public function getOrderMarkResult(array $params, array $header = []);

    public function getFbaReturn(array $params, array $header = []);

}
