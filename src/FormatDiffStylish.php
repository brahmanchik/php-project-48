<?php

namespace Differ\FormatDiffStylish;

$autoloadPath1 = __DIR__ . '/../../../autoload.php';
$autoloadPath2 = __DIR__ . '/../vendor/autoload.php';
if (file_exists($autoloadPath1)) {
    require_once $autoloadPath1;
} else {
    require_once $autoloadPath2;
}

use function Differ\Differ\formatValue;

function toString($value, int $depth = 1)
{

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if ($value === null) {
        return 'null';
    }
    if (is_array($value)) {
        $indentSize = $depth * 4;
        $currentIndent = str_repeat(' ', $indentSize);
        $bracketIndent = str_repeat(' ', $indentSize - 4);

        $result = array_map(fn($k, $v) => "{$currentIndent}{$k}: " . toString($v, $depth + 1), array_keys($value), $value);
        return "{\n" . implode("\n", $result) . "\n{$bracketIndent}}";
    }
    return  (string) $value;

}

function formatStylish(array $diff, int $depth = 1): string
{
    $indentSize = $depth * 4;
    $currentIndent = str_repeat(' ', $indentSize - 2);
    $bracketIndent = str_repeat(' ', $indentSize - 4);

    $lines = array_map(function ($node) use ($currentIndent, $depth) {
        $key = $node['key'];
        $type = $node['type'];

        return match ($type) {
            'nested' => "{$currentIndent}  {$key}: " . formatStylish($node['children'], $depth + 1),
            'added' => "{$currentIndent}+ {$key}: " . toString($node['value'], $depth + 1),
            'removed' => "{$currentIndent}- {$key}: " . toString($node['value'], $depth + 1),
            'changed' => "{$currentIndent}- {$key}: " . toString($node['oldValue'], $depth + 1) . "\n"
                . "{$currentIndent}+ {$key}: " . toString($node['newValue'], $depth + 1),
            'unchanged' => "{$currentIndent}  {$key}: " . toString($node['value']),
            default => throw new \Exception("Unknown type: $type"),
        };
    }, $diff);

    return "{\n" . implode("\n", $lines) . "\n{$bracketIndent}}";
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

