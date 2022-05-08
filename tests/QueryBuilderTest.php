<?php

declare(strict_types=1);

namespace Guiqibusixin\HyperfTest;

use Guiqibusixin\Hyperf\Database\Grammars\MysqlGrammar;
use Guiqibusixin\Hyperf\Database\Listener\BootRegisterListener;
use Hyperf\Database\ConnectionInterface;
use Hyperf\Database\Query\Builder;
use Hyperf\Database\Query\Expression;
use Hyperf\Database\Query\Processors\MySqlProcessor;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class QueryBuilderTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        make(BootRegisterListener::class)->process(new \stdClass());
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testReplace()
    {
        $builder = $this->getBuilder();
        /** @var \Mockery\LegacyMockInterface|\Mockery\MockInterface $connection */
        $connection = $builder->getConnection();
        $connection->shouldReceive('affectingStatement')
            ->once()
            ->with('replace into `` (`name`, `age`) values (?, ?)', ['张三', 18])
            ->andReturn(1);
        $rowNumber = $builder->replace([
            'name' => '张三',
            'age' => 18,
        ]);
        $this->assertIsNumeric($rowNumber);
    }

    public function testInsertOnDuplicate()
    {
        $builder = $this->getBuilder();
        /** @var \Mockery\LegacyMockInterface|\Mockery\MockInterface $connection */
        $connection = $builder->getConnection();
        $connection->shouldReceive('affectingStatement')
            ->once()
            ->with(
                'insert into `` (`age`, `name`) values (?, ?), (?, ?) on duplicate key update `name` = ?, `age` = values(age) + 1',
                [18, '张三', 19, '李四', '老王']
            )
            ->andReturn(2);
        $rowNumber = $builder->insertOnDuplicateKey(
            [
                [
                    'name' => '张三',
                    'age' => 18,
                ],
                [
                    'name' => '李四',
                    'age' => 19,
                ],
            ],
            [
                'name' => '老王',
                'age' => new Expression('values(age) + 1'),
            ]
        );
        $this->assertIsNumeric($rowNumber);
    }

    protected function getBuilder(): Builder
    {
        $connection = Mockery::mock(ConnectionInterface::class);
        return new Builder($connection, new MysqlGrammar(), new MySqlProcessor());
    }
}
