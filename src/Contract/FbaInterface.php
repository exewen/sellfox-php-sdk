<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Contract;

interface FbaInterface
{
    public function deliveryPlanCreate(array $params, array $header = []);

    public function createShipment(array $params, array $header = []);


}
