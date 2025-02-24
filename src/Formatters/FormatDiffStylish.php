<?php

namespace Differ\Formatters\FormatDiffStylish;

use function Differ\Stringify\toString;

const INDENT_SYMBOL = ' ';
const INDENT_REPEAT = 4;
const NESTED = 'nested';
const ADDED = 'added';
const REMOVED = 'removed';
const CHANGED = 'changed';
const UNCHANGED = 'unchanged';
function formatValue($value, int $depth = 1)
{
    if (is_array($value)) {
        $indentSize = $depth * INDENT_REPEAT;
        $currentIndent = str_repeat(INDENT_SYMBOL, $indentSize);
        $bracketIndent = str_repeat(INDENT_SYMBOL, $indentSize - INDENT_REPEAT);
        $result = array_map(fn($k, $v) => "{$currentIndent}{$k}: " . formatValue($v, $depth + 1),
            array_keys($value),$value);
        return "{\n" . implode("\n", $result) . "\n{$bracketIndent}}";
    }
    return  toString($value);
}

function formatStylish(array $diff, int $depth = 1): string
{
    $indentSize = $depth * INDENT_REPEAT;
    $currentIndent = str_repeat(INDENT_SYMBOL, $indentSize - 2);
    $bracketIndent = str_repeat(INDENT_SYMBOL, $indentSize - INDENT_REPEAT);

    $lines = array_map(function ($node) use ($currentIndent, $depth) {
        $key = $node['key'];
        $type = $node['type'];
        return match ($type) {
            NESTED => "{$currentIndent}  {$key}: " . formatStylish($node['children'], $depth + 1),
            ADDED => "{$currentIndent}+ {$key}: " . formatValue($node['value'], $depth + 1),
            REMOVED => "{$currentIndent}- {$key}: " . formatValue($node['value'], $depth + 1),
            CHANGED => "{$currentIndent}- {$key}: " . formatValue($node['oldValue'], $depth + 1) . "\n"
                . "{$currentIndent}+ {$key}: " . formatValue($node['newValue'], $depth + 1),
            UNCHANGED => "{$currentIndent}  {$key}: " . formatValue($node['value']),
            default => throw new \Exception("Unknown type: $type"),
        };
    }, $diff);

    return "{\n" . implode("\n", $lines) . "\n{$bracketIndent}}";
}
