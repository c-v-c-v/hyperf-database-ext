<?php

declare(strict_types=1);
$header = <<<'EOF'
EOF;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        '@Symfony' => true,
        '@DoctrineAnnotation' => true,
        '@PhpCsFixer' => true,
        'header_comment' => [ // 头注释
            'comment_type' => 'PHPDoc',
            'header' => $header,
            'separate' => 'none',
            'location' => 'after_declare_strict',
        ],
        'array_syntax' => [
            'syntax' => 'short', // 使用短数组语法，例如[]
        ],
        'list_syntax' => [
            'syntax' => 'short', // 使用[$sample] = $array
        ],
        'concat_space' => [
            'spacing' => 'one', // 连接符的间距
        ],
        'blank_line_before_statement' => [
            'statements' => [ // 必须以空行开头的语句列表,可选列表 ['break', 'case', 'continue', 'declare', 'default', 'phpdoc', 'do', 'exit', 'for', 'foreach', 'goto', 'if', 'include', 'include_once', 'require', 'require_once', 'return', 'switch', 'throw', 'try', 'while', 'yield', 'yield_from']
                'declare',
            ],
        ],
        'general_phpdoc_annotation_remove' => [
            'annotations' => [ // PHPDoc 中应省略配置的注释
                'author',
            ],
        ],
        'ordered_imports' => [ // 语句是否应该按字母顺序或长度排序，或者不排序
            'imports_order' => [  // 定义导入类型的顺序
                'class', 'function', 'const',
            ],
            'sort_algorithm' => 'alpha',  // 排序算法
        ],
        'single_line_comment_style' => [ // 单行注释注释风格
            'comment_types' => [
                'hash', // 用 // 代替 # 注释
            ],
        ],
        'phpdoc_summary' => false, // PHPDoc 摘要应该以句号、感叹号或问号结尾
        'single_line_comment_spacing' => true, // 单行注释必须有适当的间距
        'yoda_style' => [
            'always_move_variable' => false, // 变量应始终位于不可分配的一侧
            'equal' => false,  // 相等 ( ==, !=) 语句的样式
            'identical' => false, // 相同 ( ===, !==) 语句的样式
        ],
        'phpdoc_align' => [
            'align' => 'left', // 给定 phpdoc 标记的所有项目必须左对齐
        ],
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'no_multi_line', // 禁止在结束分号之前使用多行空格
        ],
        'constant_case' => [
            'case' => 'lower', // PHP 常量true、false和null必须使用正确的大小写。
        ],
        'class_attributes_separation' => true, // 类、特征和接口元素必须用一个或没有空行分隔
        'combine_consecutive_unsets' => true,  // 合并多个unset
        'declare_strict_types' => true, // 在所有文件中强制声明严格类型
        'linebreak_after_opening_tag' => true, // 确保没有代码与 PHP 打开标记在同一行
        'lowercase_static_reference' => true, // 类静态引用self，static并且parent必须小写
        'no_useless_else' => true, // 删除空else
        'no_unused_imports' => true, // 删除没有使用的导入
        'not_operator_with_successor_space' => false, // 逻辑非运算符 (! ) 应该有一个尾随空格
        'not_operator_with_space' => false, // 逻辑非运算符 ( ! ) 应该有前导和尾随空格
        'ordered_class_elements' => [
            'order' => ['use_trait'],
        ], // 对类/接口/特征/枚举的元素进行排序
        'php_unit_strict' => false, // PHPUnit 方法中类似于 assertSame 应该用来代替 assertEquals
        'phpdoc_separation' => false,  // PHPDoc 中的注解应该组合在一起，以便相同类型的注解紧跟其后，不同类型的注解用一个空行分隔
        'single_quote' => true, // 将简单字符串的双引号转换为单引号，简单字符串就是没用使用变量的字符串
        'standardize_not_equals' => true, // 使用 != 替换 <>
        'multiline_comment_opening_closing' => true, // DocBlocks 必须以两个星号开头，多行注释必须以一个星号开头，在斜杠之后。两者都必须在结束斜杠之前以单个星号结尾
    ])
    ->setFinder(  // 格式化的目录
        PhpCsFixer\Finder::create()
            ->exclude('vendor')
            ->name('*.php')
            ->in(__DIR__)
    )
    ->setUsingCache(false);
