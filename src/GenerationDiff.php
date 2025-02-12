<?php

namespace Differ\GenerationDiff;

$autoloadPath1 = __DIR__ . '/../../../autoload.php';
$autoloadPath2 = __DIR__ . '/../vendor/autoload.php';
if (file_exists($autoloadPath1)) {
    require_once $autoloadPath1;
} else {
    require_once $autoloadPath2;
}


use function Differ\Differ\formatValue;
use function Functional\sort;


function generateDiff($contentFile1, $contentFile2): array
{
    $keys = array_keys(array_merge($contentFile1, $contentFile2)); //получаю общий список ключей из 2 файлов
    // Сортируем ключи с помощью функциональной функции sort
    $keysSort = sort($keys, fn($left, $right) => strcmp($left, $right), true);
    $iter = function ($key, $contentFile1, $contentFile2) use (&$iter) {
        $value1 = $contentFile1[$key];
        $value2 = $contentFile2[$key];
        if (!array_key_exists($key, $contentFile2)) {
            return ['key' => $key, 'type' => 'removed', 'value' => $value1];
        }
        if (!array_key_exists($key, $contentFile1)) {
            return ['key' => $key, 'type' => 'added', 'value' => $value2];
        }
        if (is_array($value1) && is_array($value2)) {
            $keys = array_keys(array_merge($value1, $value2));
            $keysNestedSorted = sort($keys, fn($left, $right) => strcmp($left, $right), true);
            return ['key' => $key, 'type' => 'nested',
                'children' => array_map(fn($nestedKey) => $iter($nestedKey, $value1, $value2), $keysNestedSorted)];
        }
        if ($value1 !== $value2) {
            return ['key' => $key, 'type' => 'changed', 'oldValue' => $value1, 'newValue' => $value2];
        }
        return ['key' => $key, 'type' => 'unchanged', 'value' => $value1];
    };

    return array_map(fn($key) => $iter($key, $contentFile1, $contentFile2), $keysSort);
}

$file1 = [
    "common" => [
        "setting1" => "Value 1",
        "setting2" => 200,
        "setting3" => true,
        "setting6" => [
            "key" => "value",
            "doge" => [
                "wow" => ""
            ]
        ]
    ],
    "group1" => [
        "baz" => "bas",
        "foo" => "bar",
        "nest" => [
            "key" => "value"
        ]
    ],
    "group2" => [
        "abc" => 12345,
        "deep" => [
            "id" => 45
        ]
    ]
];

$file2 = [
    "common" => [
        "follow" => false,
        "setting1" => "Value 1",
        "setting3" => null,
        "setting4" => "blah blah",
        "setting5" => [
            "key5" => "value5"
        ],
        "setting6" => [
            "key" => "value",
            "ops" => "vops",
            "doge" => [
                "wow" => "so much"
            ]
        ]
    ],
    "group1" => [
        "foo" => "bar",
        "baz" => "bars",
        "nest" => "str"
    ],
    "group3" => [
        "deep" => [
            "id" => [
                "number" => 45
            ]
        ],
        "fee" => 100500
    ]
];

print_r(generateDiff($file1, $file2));