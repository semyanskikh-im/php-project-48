<?php

namespace Differ\Differ;

use function Functional\sort;

function differ(array $array1, array $array2): array
{
    //получаем все ключи 2 массивов на одной глубине
    $keys = array_unique(array_merge(array_keys($array1), array_keys($array2)));

    //сортируем ключи по алфавиту
    $sortedKeys = sort(
        $keys,
        function ($a, $b) {
            return strcmp($a, $b);
        }
    );

    $result = array_map(function ($key) use ($array1, $array2) {
        $value1 = $array1[$key] ?? null;
        $value2 = $array2[$key] ?? null;
        //если ключ есть только в первом массиве
        if (array_key_exists($key, $array1) && (!array_key_exists($key, $array2))) {
            return [
                'status' => 'removed',
                'key' => $key,
                'value' => $value1
            ];
        }
        //если ключ есть только во втором массиве
        if (!array_key_exists($key, $array1) && (array_key_exists($key, $array2))) {
            return [
                'status' => 'added',
                'key' => $key,
                'value' => $value2
            ];
        }

        //если ключ есть в обоих массивах:
        if (array_key_exists($key, $array1) && (array_key_exists($key, $array2))) {
            //1. значения одинаковы:
            if ($value1 === $value2) {
                return [
                    'status' => 'unchanged',
                    'key' => $key,
                    'value' => $value1
                ];
            }

            //2. значения разные:
            //2.1 если одно или второе значение не является массивом, то просто записываем разность
            if ((!is_array($value1)) || (!is_array($value2))) {
                return [
                    'status' => 'updated',
                    'key' => $key,
                    'value1' => $value1,
                    'value2' => $value2
                ];
            }

            //2.2 если оба значенияя массивы...
            if (is_array($value1) && is_array($value2)) {
                //2.2.1... и оба ассоциативные, проверяем детей на уровень ниже
                if (!array_is_list($value1) && !array_is_list($value2)) {
                    return [
                        'status' => 'have children',
                        'key' => $key,
                        'children' => differ($value1, $value2)
                    ];
                } else { //2.2.2 в противном случае, возвращаем как есть
                    return [
                        'status' => 'updated',
                        'key' => $key,
                        'value1' => $value1,
                        'value2' => $value2
                    ];
                }
            }
        }
    }, $sortedKeys);

    return $result;
}

function makeDiff(array $array1, array $array2): array
{
    return [
        'status' => 'root',
        'children' => differ($array1, $array2)
    ];
}
