<?php

declare(strict_types=1);

namespace Guiqibusixin\Hyperf\Database;

use Guiqibusixin\Hyperf\Database\Connection\MysqlConnection;
use Guiqibusixin\Hyperf\Database\Macros\BuilderMacro;
use Hyperf\Database\Connection;
use Hyperf\Database\Query\Builder;
use ReflectionException;

class Register
{
    /**
     * @throws ReflectionException
     */
    public function __invoke()
    {
        $this->registerConnection();

        $this->registerBuilder();
    }

    private function registerConnection()
    {
        Connection::resolverFor('mysql', function ($connection, $database, $prefix, $config) {
            return new MysqlConnection($connection, $database, $prefix, $config);
        });
    }

    /**
     * @throws ReflectionException
     */
    private function registerBuilder()
    {
        Builder::mixin(new BuilderMacro());
    }
}
