<?php

namespace GenerateDiff\Differ;

use function Functional\sort;

function differ($array1, $array2, $depth = 1)
{
    $keys = array_unique(array_merge(array_keys($array1), array_keys($array2)));//получаем все ключи 2 массивов на одной глубине

    $sortedKeys = sort($keys,//сортируем по алфавиту
        function ($a, $b) {
            return strcmp($a, $b);
        });

    print_r($sortedKeys);    

    $result = array_map(function($key) use ($array1, $array2, $depth) {
        //если ключ есть только в первом массиве
        if (array_key_exists($key, $array1) && (!array_key_exists($key, $array2))) {
            $diff[] = ['depth' => $depth, 'status' => '-', 'key' => $key, 'value' => $array1[$key]];
            return $diff;
        } 
        //если ключ есть только во втором массиве
        if (!array_key_exists($key, $array1) && (array_key_exists($key, $array2))) {
            $diff[] = ['depth' => $depth, 'status' => '+', 'key' => $key, 'value' => $array2[$key]];
            return $diff;
        } 
        
        //если ключ есть в обоих массивах:
        if (array_key_exists($key, $array1) && (array_key_exists($key, $array2))) {
        //1. значения одинаковы:
            if ($array1[$key] === $array2[$key]) {
                $diff[] = ['depth' => $depth, 'status' => ' ', 'key' => $key, 'value' => $array1[$key]];
                return $diff;
            }

        //2. значения разные: 
          // если одно или второе значение не является массивом, то просто записываем разность
            if ((!is_array($array1[$key])) || (!is_array($array2[$key]))) {

                $diff[] = ['depth' => $depth, 'status' => '-', 'key' => $key, 'value' => $array1[$key]];
                $diff[] = ['depth' => $depth, 'status' => '+', 'key' => $key, 'value' => $array2[$key]];
                
                return $diff;
            }

            //если оба массивы...
            if (is_array($array1[$key]) && is_array($array2[$key])) {
                // ... и оба ассоциативные, проверяем детей на уровень ниже
                if (!array_is_list($array1[$key]) && !array_is_list($array2[$key])) {
                        
                    return $diff[] = ['depth' => $depth, 'status' => ' ', 'key' => $key, 'value' => differ($array1[$key], $array2[$key], $depth + 1)];
                } else {//в противном случае, возвращаем как есть

                    $diff[] = ['depth' => $depth, 'status' => '-', 'key' => $key, 'value' => $array1[$key]];
                    $diff[] = ['depth' => $depth, 'status' => '+', 'key' => $key, 'value' => $array2[$key]];
                    return $diff;
                }
            }
        }
        }, $sortedKeys);

    return $result;

}