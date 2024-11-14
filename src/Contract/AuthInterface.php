<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Contract;

interface AuthInterface
{
    public function getToken(string $clientId, string $clientSecret);

}