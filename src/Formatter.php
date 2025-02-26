<?php

namespace Differ\Formatter;

use function Differ\Formatters\FormatDiffStylish\formatStylish;
use function Differ\Formatters\FormatDiffPlain\formatPlain;
use function Differ\Formatters\FormatDiffJson\formatJson;

function formatDifference(array $differenceMap, string $format): string
{
    return match ($format) {
        'stylish' => formatStylish($differenceMap) . PHP_EOL,
        'plain' => formatPlain($differenceMap) . PHP_EOL,
        'json' => formatJson($differenceMap) . PHP_EOL,
        default => throw new \Exception("Unknown format: $format"),
    };
}
