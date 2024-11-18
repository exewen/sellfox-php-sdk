<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Contract;

interface FinancialInterface
{
    public function getShippingSettlement(array $params, array $header = []);

}
