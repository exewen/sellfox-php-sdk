<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Contract;

interface FbaInterface
{
    public function deliveryPlanCreate(string $clientId, string $clientSecret);

    public function createShipment(string $clientId, string $clientSecret);

    public function getShipment(string $clientId, string $clientSecret);

}
