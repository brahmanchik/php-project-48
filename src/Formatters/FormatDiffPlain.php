<?php

namespace Differ\Formatters\FormatDiffPlain;
/*
$autoloadPath1 = __DIR__ . '/../../../autoload.php';
$autoloadPath2 = __DIR__ . '/../../vendor/autoload.php';
if (file_exists($autoloadPath1)) {
    require_once $autoloadPath1;
} else {
    require_once $autoloadPath2;
}
*/
use function Differ\Stringify\toString;

function formatValue($value, int $depth = 1)
{
    if (is_array($value)) {
       return "[complex value]";
    }
    return  toString($value, true);
}
function formatPlain(array $diff, $parent = ""): string
{
        $lines = array_map(function ($node) use ($parent){
        $key = $node['key'];
        $type = $node['type'];
        $fullPath = $parent === "" ? $key : "{$parent}.{$key}";
        return match ($type) {
            'nested' => formatPlain($node['children'], "$fullPath"),
            'added' => "Property '{$fullPath}' was added with value: " . formatValue($node['value']),
            'removed' => "Property '{$fullPath}' was removed",
            'changed' => "Property '{$fullPath}' was updated. From " .
                formatValue($node['oldValue']) . " to " . formatValue($node['newValue']),
           'unchanged' => "",
            default => throw new \Exception("Unknown type: $type"),
        };
    }, $diff);

    return implode("\n", array_filter($lines));
}

$array = [
    [
        'key' => 'common',
        'type' => 'nested',
        'children' => [
            4 => [
                'key' => 'follow',
                'type' => 'added',
                'value' => false,
            ],
            0 => [
                'key' => 'setting1',
                'type' => 'unchanged',
                'value' => 'Value 1',
            ],
            1 => [
                'key' => 'setting2',
                'type' => 'removed',
                'value' => 200,
            ],
            2 => [
                'key' => 'setting3',
                'type' => 'changed',
                'oldValue' => true,
                'newValue' => null,
            ],
            5 => [
                'key' => 'setting4',
                'type' => 'added',
                'value' => 'blah blah',
            ],
            6 => [
                'key' => 'setting5',
                'type' => 'added',
                'value' => [
                    'key5' => 'value5',
                ],
            ],
            3 => [
                'key' => 'setting6',
                'type' => 'nested',
                'children' => [
                    1 => [
                        'key' => 'doge',
                        'type' => 'nested',
                        'children' => [
                            0 => [
                                'key' => 'wow',
                                'type' => 'changed',
                                'oldValue' => "",
                                'newValue' => 'so much',
                            ],
                        ],
                    ],
                    0 => [
                        'key' => 'key',
                        'type' => 'unchanged',
                        'value' => 'value',
                    ],
                    2 => [
                        'key' => 'ops',
                        'type' => 'added',
                        'value' => 'vops',
                    ],
                ],
            ],
        ],
    ],
    [
        'key' => 'group1',
        'type' => 'nested',
        'children' => [
            0 => [
                'key' => 'baz',
                'type' => 'changed',
                'oldValue' => 'bas',
                'newValue' => 'bars',
            ],
            1 => [
                'key' => 'foo',
                'type' => 'unchanged',
                'value' => 'bar',
            ],
            2 => [
                'key' => 'nest',
                'type' => 'changed',
                'oldValue' => [
                    'key' => 'value',
                ],
                'newValue' => 'str',
            ],
        ],
    ],
    [
        'key' => 'group2',
        'type' => 'removed',
        'value' => [
            'abc' => 12345,
            'deep' => [
                'id' => 45,
            ],
        ],
    ],
    [
        'key' => 'group3',
        'type' => 'added',
        'value' => [
            'deep' => [
                'id' => [
                    'number' => 45,
                ],
            ],
            'fee' => 100500,
        ],
    ],
];
//print_r(formatPlain($array));