<?php

namespace GenerateDiff\Functions;

/*
 * функция для приведения числовых и булевых значений к строковым
 */
function setValueToString($value)
{
    if ($value === null) {
        return 'null';
    } elseif ($value === false) {
        return 'false';
    } elseif ($value === true) {
        return 'true';
    } elseif (is_int($value) || is_float($value)) {
        return (string) $value;
    } else {
        return $value;
    }
}
