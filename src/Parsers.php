<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseData($extension, $content): array
{
    return match ($extension) {
        'json' => json_decode($content, true),
        'yml', 'yaml' => Yaml::parse($content),
        default => throw new \Exception('Не предвиденный формат: ' . $extension),
    }; // возвращаю содержимое переданного файла в виде массиве
}
