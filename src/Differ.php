<?php
namespace Differ\Differ;
function genDiff($pathToFile1, $pathToFile2)
{
    $decodeFiles = [
        'contentFile1' => readAndDecodeJson($pathToFile1),
        'contentFile2' => readAndDecodeJson($pathToFile2),
    ];
    return $decodeFiles;
}
function readAndDecodeJson($pathToFile)
{
    $absolutePath = realpath(__DIR__ . "/../tests/$pathToFile");
    if ($absolutePath === false) {
        throw new \Exception("Файл не найден: $pathToFile");
    }
    $content = file_get_contents($absolutePath);
    return json_decode($content, true); // возвращаю содержимое переданного файла в массива
}
