## 简介

这是一个关于hyperf框架ORM操作的扩展包，支持Transactional注解、replace和onDuplicateKey等操作。后面会支持 case when语法，比如case when语法批量更新操作。

## 运行环境

- php 8+
- hyperf 2.2.~

## 安装

```
composer require guiqibusixin/hyper-database-ext
```

在抽象数据库模型中 `use ModelBuilderExtensionTrait`，主要是替换原生的模型构造器。

```php
<?php

declare(strict_types=1);

namespace App\Model;

use Guiqibusixin\Hyperf\Database\Model\Traits\ModelBuilderExtensionTrait;
use Hyperf\DbConnection\Model\Model as BaseModel;

abstract class Model extends BaseModel
{
    use ModelBuilderExtensionTrait;
}
```

## 使用

### Transactional注解

#### 简介

使用注解来开启一个事务，自动回滚

#### 在非数据库模型类中（普通的类，一般是service层）
```php
<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\User;
use Guiqibusixin\Hyperf\Database\Annotation\Transactional;

class UserService
{
    #[Transactional(modelClass: User::class)] // 通过模型类
    // #[Transactional(connection: 'test')] // 通过数据库连接名
    // #[Transactional] //默认连接，连接名为default
    public function create()
    {
    }
}
```

#### 在数据库模型类中
和非数据库模型类中唯一的区别是：**数据库模型类中注解的默认连接是当前模型连接**
```php
<?php

declare (strict_types=1);

namespace App\Model;

use Guiqibusixin\Hyperf\Database\Annotation\Transactional;

class User extends Model
{
    protected $table = 'user';
    
    protected $connection = 'common';
    
    #[Transactional] //此时开启事务连接是本模型的连接(common)，而不是default
    public static function createUser(array $user)
    {
        //创建用户逻辑
    }
}
```

### replace

和insert语法一致

```php
User::replace($userInfo);
```

### insert on duplicate key

```php
User::insertOnDuplicateKey(
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
```





