<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Contract;

interface ReportInterface
{
    public function getFbaReturn(array $params, array $header = []);
    public function getFbaStorageFee(array $params, array $header = []);

}
