<?php

declare(strict_types=1);

namespace Exewen\Sellfox;

use Exewen\Http\Middleware\LogMiddleware;
use Exewen\Sellfox\Constants\SellfoxEnum;
use Exewen\Sellfox\Middleware\AuthMiddleware;

class ConfigRegister
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                Contract\AuthInterface::class      => Services\AuthService::class,
                Contract\ShopInterface::class      => Services\ShopService::class,
                Contract\OrderInterface::class     => Services\OrderService::class,
                Contract\FbaInterface::class       => Services\FbaService::class,
                Contract\ReportInterface::class    => Services\ReportService::class,
                Contract\FinancialInterface::class => Services\FinancialService::class,
            ],

            'sellfox' => [
                SellfoxEnum::CHANNEL_AUTH => SellfoxEnum::CHANNEL_AUTH,
                SellfoxEnum::CHANNEL_API  => SellfoxEnum::CHANNEL_API,
                SellfoxEnum::CHANNEL_DETAIL_API  => SellfoxEnum::CHANNEL_DETAIL_API,
            ],

            'http' => [
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
                    SellfoxEnum::CHANNEL_DETAIL_API  => [
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
            ]


        ];
    }
}
