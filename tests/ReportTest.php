<?php
declare(strict_types=1);

namespace ExewenTest\Sellfox;

use Exewen\Sellfox\Facade\FinancialFacade;
use Exewen\Sellfox\Facade\ReportFacade;

class ReportTest extends Base
{

    /**
     * 测试订单信息
     * @return void
     */
    public function testShop()
    {
        $params   = [
        ];
        $response = ReportFacade::getFbaStorageFee($params);
        var_dump($response);
        $this->assertNotEmpty($response);
    }


}