<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Contract;

interface OrderInterface
{
    public function getOrder(string $clientId, string $clientSecret);
    public function getOrderDetail(string $clientId, string $clientSecret);
    public function getFbmOrder(string $clientId, string $clientSecret);
    public function getFbmOrderDetail(string $clientId, string $clientSecret);
    public function submitToPlatform(string $clientId, string $clientSecret);

}
