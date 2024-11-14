<?php
declare(strict_types=1);

namespace ExewenTest\Sellfox;

use PHPUnit\Framework\TestCase;

class Base extends TestCase
{
    public function __construct()
    {
        parent::__construct();
        !defined('BASE_PATH_PKG') && define('BASE_PATH_PKG', dirname(__DIR__, 1));
    }

}