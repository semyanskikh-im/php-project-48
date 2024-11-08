<?php

namespace GenerateDiff\Gendiff;

use function GenerateDiff\Parsers\parse;
use function GenerateDiff\Differ\differ;
use function GenerateDiff\Functions\setValueToString;
use function Functional\sort;

function genDiff($filename1, $filename2)
{
    $firstFilePath = __DIR__ . "/../{$filename1}"; // путь до первого файла
    $secondFilePath = __DIR__ . "/../{$filename2}"; // путь до второго файла

    //echo $firstFilePath . PHP_EOL;
    //echo $secondFilePath . PHP_EOL;

    $firstParserResult = parse($firstFilePath); //данные парсинга первого файла
    $secondParserResult = parse($secondFilePath);//данные парcинга второго файла

    // var_export($firstParserResult) . PHP_EOL;
    // var_export($secondParserResult) . PHP_EOL;

    //проходимся по данным первого массива(файла):
    // foreach ($firstParserResult as $k => $v) {
    //     if (array_key_exists($k, $secondParserResult)) {//если ключ есть в обоих массивах, то 2 варианта:
    //         if ($firstParserResult[$k] === $secondParserResult[$k]) {// 1. если зачение в обоих массивах одинаковое
    //             $difference[] = ['sign' => ' ', 'key' => $k, 'value' => setValueToString($v)];
    //         } else {// 2. если значение изменилось
    //             $difference[] = ['sign' => '-', 'key' => $k, 'value' => setValueToString($v)];
    //             $difference[] = ['sign' => '+', 'key' => $k, 'value' => setValueToString($secondParserResult[$k])];
    //         }
    //     } else {//если ключ есть только в первом массиве
    //         $difference[] = ['sign' => '-', 'key' => $k, 'value' => setValueToString($v)];
    //     }
    // }

    //проходим по данным второго массива:
    // foreach ($secondParserResult as $k => $v) {
    //     if (!array_key_exists($k, $firstParserResult)) {//если ключ-значение есть только во втором массиве
    //          $difference[] = ['sign' => '+', 'key' => $k, 'value' => setValueToString($v)];
    //     }
    // }

    //сортируем массив различий, чтобы значения по ключу 'key' были в алфавитном порядке:
    // $sortedDifference = sort(
    //     $difference,
    //     function ($a, $b) {
    //         return strcmp($a['key'], $b['key']);
    //     }
    // );

    //формируем массив из строк для финального вывода:
    // $stringDifference = array_map(
    //     function ($line) {
    //         return "  {$line['sign']} {$line['key']}: {$line['value']}\n";
    //     },
    //     $sortedDifference
    // );

    // $stringDifference = implode($stringDifference);// преобразуем массив в строку

    // $finalView = "{\n{$stringDifference}}\n";//финальный вид вывода различия двух файлов

    // echo($finalView);
    // return $finalView;

    $diff = differ($firstParserResult, $secondParserResult);

    var_export($diff);

    $jsonresult = json_encode($diff);
    file_put_contents('result.json', $jsonresult);




}
