<?php
declare(strict_types=1);

namespace ExewenTest\Sellfox;

use Exewen\Sellfox\Facade\ListingFacade;

class ListingTest extends Base
{
    
    public function testListing()
    {
        $params   = [
            'pageNo'            => 1,
            'pageSize'          => 5,
            'modifiedTimeStart' => date("Y-m-d H:i:s", time() - 3600 * 24),
            'modifiedTimeEnd'   => date("Y-m-d H:i:s", time()),
        ];
        $response  = ListingFacade::getListing($params);
        $this->assertNotEmpty($response);
    }
    
}