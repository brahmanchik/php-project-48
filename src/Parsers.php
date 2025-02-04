<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseFile($pathToFile): array
{
    $absolutePath = realpath($pathToFile); // нужен ли тут __DIR__ ?
    if ($absolutePath === false) {
        throw new \Exception("Файл не найден: $pathToFile");
    }
    $extension = pathinfo($pathToFile, PATHINFO_EXTENSION);
    $content = file_get_contents($absolutePath);
    return match ($extension) {
        'json' => json_decode($content, true),
        'yml', 'yaml' => (array) Yaml::parse($content, Yaml::PARSE_OBJECT_FOR_MAP),
        default => throw new \Exception("Не предвиденный формат: $extension"),
    }; // возвращаю содержимое переданного файла в виде массиве
}