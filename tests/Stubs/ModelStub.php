<?php

declare(strict_types=1);

namespace Guiqibusixin\HyperfTest\Stubs;

use Hyperf\Database\Model\Model;

class ModelStub extends Model
{
    protected $connection = 'test_stub';
}
