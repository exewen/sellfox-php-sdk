<?php

declare(strict_types=1);

use Exewen\Http\Middleware\LogMiddleware;
use Exewen\Sellfox\Constants\SellfoxEnum;
use Exewen\Sellfox\Middleware\AuthMiddleware;

return [
    'channels' => [
        SellfoxEnum::CHANNEL_AUTH => [
            'verify'          => false,
            'ssl'             => true,
            'host'            => 'openapi.sellfox.com',
            'port'            => null,
            'prefix'          => null,
            'connect_timeout' => 3,
            'timeout'         => 20,
            'handler'         => [
                LogMiddleware::class,
            ],
            'extra'           => [],
            'proxy'           => [
                'switch' => false,
                'http'   => '127.0.0.1:8888',
                'https'  => '127.0.0.1:8888'
            ]
        ],
        SellfoxEnum::CHANNEL_API  => [
            'verify'          => false,
            'ssl'             => true,
            'host'            => 'openapi.sellfox.com',
            'port'            => null,
            'prefix'          => null,
            'connect_timeout' => 3,
            'timeout'         => 20,
            'handler'         => [
                AuthMiddleware::class,
                LogMiddleware::class,
            ],
            'extra'           => [],
            'proxy'           => [
                'switch' => false,
                'http'   => '127.0.0.1:8888',
                'https'  => '127.0.0.1:8888'
            ]
        ],
    ]
];