<?php

declare(strict_types=1);

namespace Exewen\Sellfox;

use Exewen\Sellfox\Constants\SellfoxEnum;

class ConfigRegister
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                Contract\AuthInterface::class      => Services\AuthService::class,
                Contract\OrderInterface::class     => Services\OrderService::class,
                Contract\FbaInterface::class       => Services\FbaService::class,
                Contract\ReportInterface::class    => Services\ReportService::class,
                Contract\FinancialInterface::class => Services\FinancialService::class,
            ],

            'sellfox' => [
                'channel_api' => SellfoxEnum::CHANNEL,
            ],

            'http' => [
                'channels' => [
                    SellfoxEnum::CHANNEL => [
                        'verify'          => false,
                        'ssl'             => true,
                        'host'            => 'openapi.sellfox.com',
                        'port'            => null,
                        'prefix'          => null,
                        'connect_timeout' => 3,
                        'timeout'         => 20,
                        'handler'         => [],
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
