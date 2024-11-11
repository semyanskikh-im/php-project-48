<?php

namespace GenerateDiff\Formatters\Stylish;

function formatStylish($diff)
{
        $result = array_map(function($item) {
            $dip = $item['depth']; //текущая глубина
            $count = ($dip * ($dip * 4) - 2);//формула расчета отступа в зависимости от глубины
            $indent = str_repeat(".", $count);// сколько раз повторяем отступ
            $symbol = "{$item['status']} ";// знак перед строкой: + - или пробел
     
         
        if (!is_array($item['value'])) {//если не построены дети
            $lines[] = "{$indent}{$symbol}{$item['key']}: {$item['value']}\n";
            return $lines;
            } 
        if (is_array($item['value'])) {//если у значения есть дети
            $lines[] = "{$indent}{$symbol}{$item['key']}: {\n";
            formatStylish($item['value']);
            return $lines;
            }
        }, $diff);

    return $result;
}