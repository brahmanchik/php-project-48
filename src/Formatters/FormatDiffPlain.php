<?php

namespace Differ\Formatters\FormatDiffPlain;

use function Differ\Stringify\toString;

function formatValue(mixed $value): string
{
    if (is_array($value)) {
        return "[complex value]";
    }
    return toString($value, true);
}

function formatPlain(array $diff, string $parent = ""): string
{
    $lines = array_map(function ($node) use ($parent) {
            $key = $node['key'];
            $type = $node['type'];
            $fullPath = $parent === "" ? $key : "{$parent}.{$key}";
            return match ($type) {
                'nested' => formatPlain($node['children'], "$fullPath"),
                'added' => "Property '{$fullPath}' was added with value: " . formatValue($node['value']),
                'removed' => "Property '{$fullPath}' was removed",
                'changed' => "Property '{$fullPath}' was updated. From " .
                formatValue($node['oldValue']) . " to " . formatValue($node['newValue']),
                'unchanged' => "",
                default => throw new \Exception("Unknown type: $type"),
            };
    }, $diff);

    return implode("\n", array_filter($lines));
}
