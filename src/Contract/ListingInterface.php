<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Contract;

interface ListingInterface
{
    public function getListing(array $params, array $header = []);
}