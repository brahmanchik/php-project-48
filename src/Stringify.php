<?php

namespace Differ\Stringify;

function toString(mixed $value, bool $quoteStrings = false): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if ($value === null) {
        return 'null';
    }
    if (is_string($value) && $quoteStrings) {
        return "'" . $value . "'";
    }
    return (string) $value;
}
