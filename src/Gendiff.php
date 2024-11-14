<?php

namespace GenerateDiff\Gendiff;

use function GenerateDiff\Parsers\parse;
use function GenerateDiff\Differ\differ;
use function GenerateDiff\Functions\setValueToString;
use function GenerateDiff\Formatters\Stylish\formatStylish;
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

    // $stringDifference = implode($stringDifference);// преобразуем массив в строку

    // $finalView = "{\n{$stringDifference}}\n";//финальный вид вывода различия двух файлов

   

    $diff = differ($firstParserResult, $secondParserResult);

    var_export($diff);

    // $final = formatStylish($diff);
    // var_export($final);

    // $jsonresult = json_encode($diff);
    // file_put_contents('result.json', $jsonresult);




}
