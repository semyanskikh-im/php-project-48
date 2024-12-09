<?php

namespace Differ\Gendiff;

use function Differ\Parsers\parse;
use function Differ\Differ\makeDiff;
use function Differ\Formatter\formatter;

function genDiff(string $filename1, string $filename2, string $format = 'stylish'): string
{
    $firstFilePath = __DIR__ . "/../{$filename1}"; // путь до первого файла
    $secondFilePath = __DIR__ . "/../{$filename2}"; // путь до второго файла

    $firstParserResult = parse($firstFilePath); //данные парсинга первого файла
    $secondParserResult = parse($secondFilePath); //данные парcинга второго файла

    $diff = makeDiff($firstParserResult, $secondParserResult);

    $result = formatter($diff, $format);

    return $result;
}
