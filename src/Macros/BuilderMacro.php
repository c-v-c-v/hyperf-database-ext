<?php

declare(strict_types=1);

namespace Guiqibusixin\Hyperf\Database\Macros;

use Guiqibusixin\Hyperf\Database\Grammars\MysqlGrammar;
use Hyperf\Database\Query\Builder;
use Hyperf\Database\Query\Expression;
use Hyperf\Utils\Arr;

/**
 * @mixin Builder
 */
class BuilderMacro
{
    public function insertOnDuplicateKey(): \Closure
    {
        return function (array $insertValues, array $updateValues) {
            /** @var Builder $builder */
            $builder = $this;

            if (!$builder->grammar instanceof MysqlGrammar) {
                throw new \RuntimeException('The sql grammar is not support!!');
            }

            if (empty($insertValues)) {
                return true;
            }

            if (is_array(reset($insertValues))) {
                foreach ($insertValues as $key => $value) {
                    ksort($value);

                    $insertValues[$key] = $value;
                }
            }

            $sql = $builder->grammar->compileInsert($builder, $insertValues);
            $updateColumns = $builder->grammar->compileUpdateColumns($updateValues);
            $sql .= ' on duplicate key update ' . $updateColumns;

            $bindings = collect($insertValues)
                ->flatten(1)
                ->merge($updateValues)
                ->filter(fn ($binding) => !$binding instanceof Expression)
                ->values()
                ->toArray();

            return $builder->connection->affectingStatement($sql, $bindings);
        };
    }

    public function replace(): \Closure
    {
        return function (array $values) {
            /** @var Builder $this */
            if (!$this->grammar instanceof MysqlGrammar) {
                throw new \RuntimeException('The sql grammar is not support!!');
            }

            if (empty($values)) {
                return 0;
            }
            if (!is_array(reset($values))) {
                $values = [$values];
            } else {
                foreach ($values as $key => $value) {
                    ksort($value);
                    $values[$key] = $value;
                }
            }
            return $this->connection->affectingStatement(
                $this->grammar->compileReplace($this, $values),
                $this->cleanBindings(Arr::flatten($values, 1))
            );
        };
    }
}
