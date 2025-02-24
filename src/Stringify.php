<?php

namespace Differ\Stringify;

function toString($value, bool $quoteStrings = false)
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
