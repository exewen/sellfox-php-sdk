<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Contract;

interface ReportInterface
{
    public function getFbaReturn(string $clientId, string $clientSecret);
    public function getFbmReturn(string $clientId, string $clientSecret);
    public function getFbaStorageFeePage(string $clientId, string $clientSecret);

}
