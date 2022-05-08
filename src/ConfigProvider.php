<?php

declare(strict_types=1);

namespace Guiqibusixin\Hyperf\Database;

use Guiqibusixin\Hyperf\Database\Listener\BootRegisterListener;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'listeners' => [
                BootRegisterListener::class,
            ],
            'dependencies' => [
            ],
            'commands' => [
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
        ];
    }
}
