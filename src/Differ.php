<?php

namespace Differ\Differ;

use function Functional\sort;

function genDiff($pathToFile1, $pathToFile2)
{
    $decodeFiles = [
        'contentFile1' => readAndDecodeJson($pathToFile1),
        'contentFile2' => readAndDecodeJson($pathToFile2),
    ];
    //return "hello world";
    return renderDiff($decodeFiles); //вывод сравнения строк в двух файлах
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
    $contentFile1 = $filesContent['contentFile1'];
    $contentFile2 = $filesContent['contentFile2'];
    $keys = array_keys(array_merge($contentFile1, $contentFile2));

    // Сортируем ключи с помощью функциональной функции sort
    $keysSort = sort($keys, fn($left, $right) => strcmp($left, $right), true);

    // Используем array_map для формирования diff для каждого ключа
    $diff = array_map(function ($key) use ($contentFile1, $contentFile2) {
        $value1 = $contentFile1[$key] ?? null;
        $value2 = $contentFile2[$key] ?? null;

        // Преобразование значений
        $value1Formatted = formatValue($value1);
        $value2Formatted = formatValue($value2);

        if (array_key_exists($key, $contentFile1) && !array_key_exists($key, $contentFile2)) {
            return "  - $key: $value1Formatted"; // эта строчка только в первом файле
        } elseif (array_key_exists($key, $contentFile2) && !array_key_exists($key, $contentFile1)) {
            return "  + $key: $value2Formatted"; // эта строчка только во втором файле
        } elseif ($contentFile1[$key] === $contentFile2[$key]) {
            return "    $key: $value1Formatted"; // эта строчка есть в обоих файлах
        } else {
            return [
                "  - $key: $value1Formatted", // эта строчка только в первом файле
                "  + $key: $value2Formatted"  // эта строчка только во втором файле
            ];
        }
    }, $keysSort);
    // Используем array_reduce, чтобы собрать все результаты в один строковый вывод
    $flattenedDiff = array_reduce($diff, function ($carry, $item) {
        // Если $item — массив, развертываем его элементы
        $carry = array_merge($carry, (array)$item);
        return $carry;
    }, []);

    // Возвращаем строку, объединяя все элементы с помощью новой строки
    return "{\n" . implode("\n", $flattenedDiff) . "\n}";
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
