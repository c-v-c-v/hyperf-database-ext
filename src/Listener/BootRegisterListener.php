<?php

declare(strict_types=1);

namespace Guiqibusixin\Hyperf\Database\Listener;

use Guiqibusixin\Hyperf\Database\Register;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\BootApplication;
use ReflectionException;

class BootRegisterListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            BootApplication::class,
        ];
    }

    /**
     * @throws ReflectionException
     */
    public function process(object $event)
    {
        (new Register())();
    }
}
