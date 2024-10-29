<?php

Namespace GenerateDiff\Gendiff;


use function GenerateDiff\Functions\parse;
use function GenerateDiff\Functions\valueToString;
use function Functional\sort;


   
function genDiff($filename1, $filename2)
{
  $firstFilePath = __DIR__ . "/../files/{$filename1}"; // путь до первого файла
  $secondFilePath = __DIR__ . "/../files/{$filename2}"; // путь до второго файла

  //echo $firstFilePath . PHP_EOL;
  //echo $secondFilePath . PHP_EOL;
      
  $firstParserResult = parse($firstFilePath);
  $secondParserResult = parse($secondFilePath);

  //var_export($firstParserResult) . PHP_EOL;
  //var_export($secondParserResult) . PHP_EOL;

  foreach ($firstParserResult as $k => $v) {//проходимсяя по данным первого массива(файла)
    if ((array_key_exists($k, $secondParserResult)) && ($firstParserResult[$k] === $secondParserResult[$k])) {
      //кесли ключ-зачение есть в обоих массивах и они одинаковые
      $difference[] = ['sign' => ' ', 'key' => $k, 'value' => valueToString($v)];
    }
    if ((array_key_exists($k, $secondParserResult)) && ($firstParserResult[$k] !== $secondParserResult[$k])) {
      //если ключи есть в обоих массивах, но значение поменялось
      $difference[] = ['sign' => '-', 'key' => $k, 'value' => valueToString($v)];
      $difference[] = ['sign' => '+', 'key' => $k, 'value' => valueToString($secondParserResult[$k])];
    }

    if (!array_key_exists($k, $secondParserResult)) {//если ключ-значение есть только в первом массиве
      $difference[] = ['sign' => '-', 'key' => $k, 'value' => valueToString($v)];
    }
  }

  foreach ($secondParserResult as $k => $v) {//проходим по данным второго массива
    if (!array_key_exists($k, $firstParserResult)) {//если ключ-значение есть только во втором массиве
         $difference[] = ['sign' => '+', 'key' => $k, 'value' => valueToString($v)];
    }
  }
    
  
  $sortedDifference = sort($difference, function ($a, $b) {//сортируем по алфавиту по значению 'key'
    return strcmp($a['key'], $b['key']); 
    });

  foreach ($sortedDifference as $line) {// приводим к строковому виду
    $stringDifference[] = "{$line['sign']} {$line['key']}: {$line['value']}\n";
  }

  $stringDifference = implode($stringDifference);// преобразуем массив в строку

  $finalView = "{\n{$stringDifference}}\n";//финальный вид вывода различия json-файлов

  echo ($finalView);
  
  
  
  







}