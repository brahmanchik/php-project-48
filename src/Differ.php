<?php

namespace Differ\Differ;

use function Functional\sort;

function genDiff($pathToFile1, $pathToFile2)
{
    $decodeFiles = [
        'contentFile1' => readAndDecodeJson($pathToFile1),
        'contentFile2' => readAndDecodeJson($pathToFile2),
    ];
    return "hello world";
    //return renderDiff($decodeFiles); //вывод сравнения строк в двух файлах
}

function readAndDecodeJson($pathToFile)
{
    $absolutePath = realpath($pathToFile); // нужен ли тут __DIR__ ?
    if ($absolutePath === false) {
        throw new \Exception("Файл не найден: $pathToFile");
    }

    $content = file_get_contents($absolutePath);
    return json_decode($content, true); // возвращаю содержимое переданного файла в массива
}

function renderDiff($filesContent)
{
    $diff = [];
    $contentFile1 = $filesContent['contentFile1'];
    $contentFile2 = $filesContent['contentFile2'];
    $keys = array_keys(array_merge($contentFile1, $contentFile2));
    $keysSort = sort($keys, fn($left, $right) => strcmp($left, $right), true);
    foreach ($keysSort as $key) {
        $value1 = $contentFile1[$key] ?? null;
        $value2 = $contentFile2[$key] ?? null;
        // Преобразование значений true и false в строковый тип
        $value1Formatted = formatValue($value1);
        $value2Formatted = formatValue($value2);
        if (array_key_exists($key, $contentFile1) && !array_key_exists($key, $contentFile2)) {
            $diff[] = "- $key: $value1Formatted"; //эта строчка только в первом файле
        } elseif (array_key_exists($key, $contentFile2) && !array_key_exists($key, $contentFile1)) {
            $diff[] = "+ $key: $value2Formatted"; //эта строчка только в втором файле
        } elseif ($contentFile1[$key] === $contentFile2[$key]) {
            $diff[] = "  $key: $value1Formatted"; //эта строчка есть в обоих файлах
        } else {
            $diff[] = "- $key: $value1Formatted"; //эта строчка только в первом файле
            $diff[] = "+ $key: $value2Formatted"; //эта строчка только в втором файле
        }
    }
    return implode("\n", $diff);
}

function formatValue($value)
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false'; // Преобразование булевых значений в строки
    }
    if (is_null($value)) {
        return 'null'; // Преобразование null
    }
    return $value; // Остальные значения возвращаются как есть
}
