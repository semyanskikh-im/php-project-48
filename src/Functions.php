<?php

namespace GenerateDiff\Functions;

/*
 * функция для приведения числовых и булевых значений к строковым
 */
function formatData($value)
{
    if ($value === null) {
        return 'null';
    } elseif ($value === false) {
        return 'false';
    } elseif ($value === true) {
        return 'true';
    } elseif (is_int($value) || is_float($value)) {
        return (string) $value;
    } elseif (is_string($value)) {
        return $value;
    } elseif (is_array($value)) {
        foreach ($value as $k => $v) {
            if(is_array($v))
            return formatData($v);
        }
    // } elseif (is_array($value) && !array_is_list($value)) {
    // 	foreach ($value as $k => $v) {
    // 		$formattedKey = formatData($k);
    //         $formattedValue = formatData($v);
    //         $array[] = "\n{$formattedKey}: {$formattedValue}";
    //         $result = implode (' ', $array);
    // 	}
    // 	return $result;
    // }
}
}
