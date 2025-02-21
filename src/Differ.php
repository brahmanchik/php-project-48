<?php

namespace Differ\Differ;

use function Differ\GenerationDiff\generateDiff;
use function Differ\Formatters\FormatDiffStylish\formatStylish;
use function Differ\Parsers\parseFile;

function genDiff($pathToFile1, $pathToFile2, $format = "stylish")
{
    $decodeFile1 = parseFile($pathToFile1);
    $decodeFile2 = parseFile($pathToFile2);
    $differenceMap = generateDiff($decodeFile1, $decodeFile2); //вывод сравнения строк в двух файлах
    //print_r($differenceMap);
    //die();
    return match ($format) {
        'stylish' => formatStylish($differenceMap) . PHP_EOL,
        default => throw new \Exception("Unknown format: $format"),
    };
}
