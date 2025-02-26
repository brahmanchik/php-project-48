<?php

namespace Differ\GenerationDiff;

use function Functional\sort;

function generateDiff(array $contentFile1, array $contentFile2): array
{
    $keys = array_keys(array_merge($contentFile1, $contentFile2)); //получаю общий список ключей из 2 файлов
    // Сортируем ключи с помощью функциональной функции sort
    $keysSort = sort($keys, fn($left, $right) => strcmp($left, $right), true);
    $iter = function ($key, $contentFile1, $contentFile2) use (&$iter) {
        $value1 = $contentFile1[$key] ?? null; // Если 'значения' нет, то будет null
        $value2 = $contentFile2[$key] ?? null; // Если 'значения' нет, то будет null

        if (is_array($value1) && is_array($value2)) {
            //если оба массивы, то проводим рекурсию
            $keys = array_keys(array_merge($value1, $value2));

            // получаем ключи этих масивов, на первом проходе там будут setting1 setting2 и так далее
            $keysNestedSorted = sort($keys, fn($left, $right) => strcmp($left, $right), true);
            // дальше возвращаем масив на первой итерации он будет равен key = common
            // type = nested означает вложенный
            // а children равны массиву который формируется вызовом рекурсии
            return ['key' => $key, 'type' => 'nested',
                'children' => array_map(fn($nestedKey) => $iter($nestedKey, $value1, $value2), $keysNestedSorted)];
        }
        if (!array_key_exists($key, $contentFile2)) {
            return ['key' => $key, 'type' => 'removed', 'value' => $value1];
        }
        if (!array_key_exists($key, $contentFile1)) {
            return ['key' => $key, 'type' => 'added', 'value' => $value2];
        }
        if ($value1 !== $value2) {
            return ['key' => $key, 'type' => 'changed', 'oldValue' => $value1, 'newValue' => $value2];
        }
        return ['key' => $key, 'type' => 'unchanged', 'value' => $value1];
    };

    return array_map(fn($key) => $iter($key, $contentFile1, $contentFile2), $keysSort);
}
