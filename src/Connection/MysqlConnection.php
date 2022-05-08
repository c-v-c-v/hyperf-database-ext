<?php

declare(strict_types=1);

namespace Guiqibusixin\Hyperf\Database\Connection;

use Guiqibusixin\Hyperf\Database\Grammars\MysqlGrammar;

class MysqlConnection extends \Hyperf\Database\MySqlConnection
{
    protected function getDefaultQueryGrammar(): MysqlGrammar
    {
        return $this->withTablePrefix(new MysqlGrammar());
    }
}
