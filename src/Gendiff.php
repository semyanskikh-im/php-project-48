<?php

namespace Differ\Gendiff;

use function Differ\Parsers\parse;
use function Differ\Differ\makeDiff;
use function Differ\Formatter\formatter;

function genDiff($filename1, $filename2, $format = 'stylish')
{
    $firstFilePath = __DIR__ . "/../{$filename1}"; // путь до первого файла
    $secondFilePath = __DIR__ . "/../{$filename2}"; // путь до второго файла

    //echo $firstFilePath . PHP_EOL;
    //echo $secondFilePath . PHP_EOL;

    $firstParserResult = parse($firstFilePath); //данные парсинга первого файла
    $secondParserResult = parse($secondFilePath); //данные парcинга второго файла

    //var_export($firstParserResult) . PHP_EOL;
    //var_export($secondParserResult) . PHP_EOL;


    $diff = makeDiff($firstParserResult, $secondParserResult);

    $result = formatter($diff, $format);

    return $result;
}
