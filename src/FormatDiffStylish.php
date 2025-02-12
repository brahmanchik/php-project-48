<?php

namespace Differ\FormatDiffStylish;

$autoloadPath1 = __DIR__ . '/../../../autoload.php';
$autoloadPath2 = __DIR__ . '/../vendor/autoload.php';
if (file_exists($autoloadPath1)) {
    require_once $autoloadPath1;
} else {
    require_once $autoloadPath2;
}
//use function Differ\Differ\formatValue;
/*function toString($value)
{
    // Если это массив, формируем вывод с фигурными скобками
    if (is_array($value)) {
        $result = "{\n";
        foreach ($value as $key => $val) {
            $result .= "        {$key}: " . toString($val) . "\n"; // добавляем отступ
        }
        $result .= "    }";
        return $result;
    }
    // Если не массив, выводим значение как есть
    return var_export($value, true);
}
function formatStylish($diff, string $replacer = ' ', int $spacesCount = 2): string
{
    $iter = function ($currentValue, $depth) use (&$iter, $replacer, $spacesCount) {
        if (!is_array($currentValue)) {
            return toString($currentValue);
        }

        $indentSize = $depth * $spacesCount;
        $currentIndent = str_repeat($replacer, $indentSize);
        $bracketIndent = str_repeat($replacer, $indentSize - $spacesCount);

        $lines = array_map(function($node) use ($iter, $currentIndent, $bracketIndent, $depth)
            {
                $key = $node['key'];
                $type = $node['type'];

                return match($type) {
                    'nested' => "{$currentIndent}{$key}: " . $iter($node['children'], $depth + 1) . "  {$bracketIndent}",
                    'added' => "{$currentIndent}+ {$key}: " . toString($node['value']),
                    'removed' => "{$currentIndent}- {$key}: " . toString($node['value']),
                    'changed' => "{$currentIndent}- {$key}: " . toString($node['oldValue']) . "\n"
                                . "{$currentIndent}+ {$key}: " . toString($node['newValue']),
                    'unchanged' => "{$currentIndent}  {$key}: " . toString($node['value']),
                    default => throw new Exception("Unknown type: $type"),
                };
            },
            $currentValue
        );
        $result = ['{', ...$lines, "{$bracketIndent}}"];
        return implode("\n", $result);
    };

    return $iter($diff, 1);
}*/
function toString($value)
{
    return trim(var_export($value, true), "'");
}

// BEGIN
function stringify($value, string $replacer = ' ', int $spacesCount = 4): string
{
    $iter = function ($currentValue, $depth) use (&$iter, $replacer, $spacesCount) {
    /*    if (!array_key_exists("children", $currentValue)) {
            return toString($currentValue['value']); //если эта хуета несодержит подмасивы, то переводим это дело в строку
        }*/

        $indentSize = $depth * $spacesCount; //на первой итерации эта хуета будет равна 4 * 1
        $currentIndent = str_repeat($replacer, $indentSize); //выводим отсуп столько раз чему равна хуета выше
        $bracketIndent = str_repeat($replacer, $indentSize - $spacesCount); // отступ для } который меньше верхнего отсупа, всегда на 4

        $lines = array_map(
            function($val) {
                if ($val['type'] === 'nested') {

                    return null;
                }
                return $val['value'];
            },
            $currentValue
        );
        dd($lines);

        $result = ['{', ...$lines, "{$bracketIndent}}"];

        return implode("\n", $result);
    };

    return $iter($value, 1);
}


$diff = [
    [
        "key" => "common",
        "type" => "nested",
        "children" => [
            [
                "key" => "follow",
                "type" => "added",
                "value" => false
            ],
            [
                "key" => "setting1",
                "type" => "unchanged",
                "value" => "Value 1"
            ],
            [
                "key" => "setting2",
                "type" => "removed",
                "value" => 200
            ],
            [
                "key" => "setting3",
                "type" => "changed",
                "oldValue" => true,
                "newValue" => null
            ],
            [
                "key" => "setting4",
                "type" => "added",
                "value" => "blah blah"
            ],
            [
                "key" => "setting5",
                "type" => "added",
                "value" => [
                    "key5" => "value5"
                ]
            ],
            [
                "key" => "setting6",
                "type" => "nested",
                "children" => [
                    [
                        "key" => "doge",
                        "type" => "nested",
                        "children" => [
                            [
                                "key" => "wow",
                                "type" => "changed",
                                "oldValue" => "",
                                "newValue" => "so much"
                            ]
                        ]
                    ],
                    [
                        "key" => "key",
                        "type" => "unchanged",
                        "value" => "value"
                    ],
                    [
                        "key" => "ops",
                        "type" => "added",
                        "value" => "vops"
                    ]
                ]
            ]
        ]
    ],
    [
        "key" => "group1",
        "type" => "nested",
        "children" => [
            [
                "key" => "baz",
                "type" => "changed",
                "oldValue" => "bas",
                "newValue" => "bars"
            ],
            [
                "key" => "foo",
                "type" => "unchanged",
                "value" => "bar"
            ],
            [
                "key" => "nest",
                "type" => "changed",
                "oldValue" => [
                    "key" => "value"
                ],
                "newValue" => "str"
            ]
        ]
    ],
    [
        "key" => "group2",
        "type" => "removed",
        "value" => [
            "abc" => 12345,
            "deep" => [
                "id" => 45
            ]
        ]
    ],
    [
        "key" => "group3",
        "type" => "added",
        "value" => [
            "deep" => [
                "id" => [
                    "number" => 45
                ]
            ],
            "fee" => 100500
        ]
    ]
];

//print_r(formatStylish($diff));
print_r(stringify($diff));