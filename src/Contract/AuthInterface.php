<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Contract;

use Exewen\Sellfox\Constants\SellfoxEnum;

interface AuthInterface
{
    public function getToken(string $clientId, string $clientSecret);

    public function setAuth(string $clientId, string $clientSecret, string $accessToken, string $channel = SellfoxEnum::CHANNEL_API);

}