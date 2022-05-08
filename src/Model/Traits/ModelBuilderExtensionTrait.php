<?php

declare(strict_types=1);

namespace Guiqibusixin\Hyperf\Database\Model\Traits;

use Guiqibusixin\Hyperf\Database\Model\ModelBuilderExtension;
use Hyperf\Database\Model\Model;

/**
 * @mixin Model
 * @method static int insertOnDuplicateKey(array $insertValues, array $updateValues)
 * @method static int replace(array $values)
 */
trait ModelBuilderExtensionTrait
{
    public function newModelBuilder($query): ModelBuilderExtension
    {
        return new ModelBuilderExtension($query);
    }
}
