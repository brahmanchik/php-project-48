<?php

namespace Differ\Stringify;

function toString($value)
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if ($value === null) {
        return 'null';
    }
    return  (string) $value;
}