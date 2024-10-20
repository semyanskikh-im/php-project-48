<?php

Namespace GenerateDiff\Gendiff;


use function GenerateDiff\Functions\parse;
use function GenerateDiff\Functions\sortArrayKeys;
use function Functional\sort;

   
function genDiff($filename1, $filename2)
{
  $firstFilePath = __DIR__ . "/../files/{$filename1}"; // путь до первого файла
  $secondFilePath = __DIR__ . "/../files/{$filename2}"; // путь до второго файла

  echo $firstFilePath . PHP_EOL;
  echo $secondFilePath . PHP_EOL;
      
  $firstParserResult = sortArrayKeys(parse($firstFilePath), fn ($left, $right) => strcmp($left, $right), true); //содержимое парсинга первого файла
  $secondParserResult = sortArrayKeys(parse($secondFilePath), fn ($left, $right) => strcmp($left, $right), true); //содержиоме парсинга второго файла

  var_export($firstParserResult) . PHP_EOL;
  var_export($secondParserResult) . PHP_EOL;
    
}