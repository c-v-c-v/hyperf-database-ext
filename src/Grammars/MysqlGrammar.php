<?php

declare(strict_types=1);

namespace Guiqibusixin\Hyperf\Database\Grammars;

use Hyperf\Database\Query\Builder;

class MysqlGrammar extends \Hyperf\Database\Query\Grammars\MySqlGrammar
{
    public function compileUpdateColumns($values): string
    {
        return parent::compileUpdateColumns($values);
    }

    /**
     * Compile an replace statement into SQL.
     */
    public function compileReplace(Builder $query, array $values): string
    {
        return substr_replace($this->compileInsert($query, $values), 'replace', 0, 6);
    }
}
