<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseFile($fileInfo): array
{
    return match ($fileInfo['extension']) {
        'json' => json_decode($fileInfo['content'], true),
        'yml', 'yaml' => Yaml::parse($fileInfo['content']),
        //'yml', 'yaml' => (array) Yaml::parse($content, Yaml::PARSE_OBJECT_FOR_MAP),
        default => throw new \Exception("Не предвиденный формат: " . $fileInfo['extension']),
    }; // возвращаю содержимое переданного файла в виде массиве
}
