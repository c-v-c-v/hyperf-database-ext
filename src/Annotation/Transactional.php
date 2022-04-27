<?php

declare(strict_types=1);

namespace Guiqibusixin\Hyperf\Database\Annotation;

use Attribute;

/**
 * 优先等级: $connection > $modelClass
 * 如果方法和类上同时存在，优先级：方法 > 类
 * 在模型中使用默认为当前模型对应的连接，否则为默认连接.
 */
#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
class Transactional extends \Hyperf\Di\Annotation\AbstractAnnotation
{
    /**
     * Transactional constructor.
     * @param string $modelClass 模型类名
     * @param string $connection 连接名
     * @param int $attempts 尝试次数
     * @param bool $enable 是否开启事务
     */
    public function __construct(
        public string $modelClass = '',
        public string $connection = '',
        public int $attempts = 1,
        public bool $enable = true,
    ) {
    }
}
