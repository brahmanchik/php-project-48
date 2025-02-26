<?php

namespace Differ\Differ;

use function Differ\GenerationDiff\generateDiff;
use function Differ\Formatter\formatDifference;
use function Differ\Parsers\parseData;

function getFileData(string $pathToFile): array
{
    $absolutePath = realpath($pathToFile);

    if ($absolutePath === false || !file_exists($absolutePath)) {
        throw new \Exception("Файл не найден: $pathToFile");
    }

    return [
        "extension" => pathinfo($absolutePath, PATHINFO_EXTENSION),
        "content" => file_get_contents($absolutePath),
    ];
}
function genDiff($pathToFile1, $pathToFile2, $format = "stylish")
{
    $fileInfo1 = getFileData($pathToFile1);
    $fileInfo2 = getFileData($pathToFile2);
    $decodeFile1 = parseData($fileInfo1['extension'], $fileInfo1['content']); //parseData назови
    $decodeFile2 = parseData($fileInfo2['extension'], $fileInfo2['content']);
    $differenceMap = generateDiff($decodeFile1, $decodeFile2); //вывод сравнения строк в двух файлах
    return formatDifference($differenceMap, $format);
}
