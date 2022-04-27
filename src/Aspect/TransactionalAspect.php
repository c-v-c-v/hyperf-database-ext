<?php

declare(strict_types=1);

namespace Guiqibusixin\Hyperf\Database\Aspect;

use Guiqibusixin\Hyperf\Database\Annotation\Transactional;
use Hyperf\Database\ConnectionInterface;
use Hyperf\Database\Model\Model;
use Hyperf\Database\Model\Register;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;

#[Aspect]
class TransactionalAspect extends AbstractAspect
{
    public $annotations = [Transactional::class];

    /**
     * @throws \Hyperf\Di\Exception\Exception
     * @throws \Throwable
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        /** @var Transactional $transactional */
        $annotationMetadata = $proceedingJoinPoint->getAnnotationMetadata();
        $transactional = $annotationMetadata->method[Transactional::class] ?? $annotationMetadata->class[Transactional::class];

        if (!$transactional->enable) {
            return $proceedingJoinPoint->process();
        }

        $connection = $this->getConnection($transactional, $proceedingJoinPoint->className);

        return $connection->transaction(
            static function () use ($proceedingJoinPoint) {
                return $proceedingJoinPoint->process();
            },
            $transactional->attempts
        );
    }

    /**
     * 获取数据库连接.
     */
    public function getConnection(Transactional $transactional, string $className): ConnectionInterface
    {
        /* @var ConnectionInterface $connection */
        if (!empty($transactional->connection)) {
            $connection = Register::resolveConnection($transactional->connection);
        } elseif (!empty($transactional->modelClass)) {
            $connection = (new $transactional->modelClass())->getConnection();
        } elseif (is_subclass_of($className, Model::class)) {
            $connection = (new $className())->getConnection();
        } else {
            $connection = Register::resolveConnection();
        }

        return $connection;
    }
}
