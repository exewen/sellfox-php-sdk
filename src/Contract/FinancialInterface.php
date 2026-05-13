<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Contract;

interface FinancialInterface
{
    public function getSettlementDetail(array $params, array $header = []);
    public function getShippingSettlement(array $params, array $header = []);
    public function getAccountProfit(array $params, array $header = []);
    public function getSkuProfit(array $params, array $header = []);
    public function getDeferredAmountList(array $params, array $header = []);
    public function getDeferredOrderList(array $params, array $header = []);
    public function getRenderMonthEndDelayList(array $params, array $header = []);
}
