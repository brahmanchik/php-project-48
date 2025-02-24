<?php

namespace Differ\Differ;

use function Differ\GenerationDiff\generateDiff;
use function Differ\Formatters\Formatter\formatDifference;
use function Differ\Parsers\parseFile;

function getFileData(string $pathToFile): array {
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
    $decodeFile1 = parseFile(getFileData($pathToFile1));
    $decodeFile2 = parseFile(getFileData($pathToFile2));
    $differenceMap = generateDiff($decodeFile1, $decodeFile2); //вывод сравнения строк в двух файлах
    return formatDifference($differenceMap, $format);
}
