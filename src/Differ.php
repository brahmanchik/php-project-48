<?php

namespace Differ\Differ;

use function Differ\GenerationDiff\generateDiff;
use function Differ\Formatters\Formatter\formatDifference;
use function Differ\Parsers\parseFile;

function genDiff($pathToFile1, $pathToFile2, $format = "stylish")
{
    $decodeFile1 = parseFile($pathToFile1);
    $decodeFile2 = parseFile($pathToFile2);
    $differenceMap = generateDiff($decodeFile1, $decodeFile2); //вывод сравнения строк в двух файлах
    return formatDifference($differenceMap, $format);
}
