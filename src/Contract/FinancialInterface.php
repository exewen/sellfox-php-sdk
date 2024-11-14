<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Contract;

interface FinancialInterface
{
    public function getShippingSettlement(string $clientId, string $clientSecret);

}
