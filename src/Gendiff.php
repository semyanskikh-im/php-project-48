<?php

namespace Differ\Gendiff;

use function Differ\Parsers\parse;
use function Differ\Differ\differ;
use function Differ\Formatters\Stylish\makeStylish;
use function Functional\sort;

function genDiff($filename1, $filename2)
{
    $firstFilePath = __DIR__ . "/../{$filename1}"; // путь до первого файла
    $secondFilePath = __DIR__ . "/../{$filename2}"; // путь до второго файла

    //echo $firstFilePath . PHP_EOL;
    //echo $secondFilePath . PHP_EOL;

    $firstParserResult = parse($firstFilePath); //данные парсинга первого файла
    $secondParserResult = parse($secondFilePath);//данные парcинга второго файла

    //var_export($firstParserResult) . PHP_EOL;
    //var_export($secondParserResult) . PHP_EOL;


    $diff = differ($firstParserResult, $secondParserResult);
    

    //var_export($diff);

    $final = makeStylish($diff);
    print_r($final);

    // $jsonresult = json_encode($diff);
    // file_put_contents('result.json', $jsonresult);




}
