<?php

declare(strict_types=1);

namespace Guiqibusixin\Hyperf\Database\Model;

use Hyperf\Database\Model\Builder;
use Hyperf\Database\Query\Builder as QueryBuilder;

class ModelBuilderExtension extends Builder
{
    protected array $passthruExtension = ['insertOnDuplicateKey', 'replace'];

    public function __construct(QueryBuilder $query)
    {
        parent::__construct($query);

        $this->passthru = array_merge($this->passthru, $this->passthruExtension);
    }
}
