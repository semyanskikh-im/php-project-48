<?php

namespace GenerateDiff\Functions;

use function Functional\sort;

function parse($path) 
{
    $fileContent = file_get_contents($path); // получаем содержимое файла по введенному пути
    if (empty($fileContent)) {
        throw new \Exception('Oops! File is empty!'); // если файл пустой  - выводим сообщение
    } else {
        return json_decode($fileContent, true); // если файл не пустой - декодируем из json в асс. массив
}
}


function sortArrayKeys($array): array //функция сортировки ассоциативного массива по ключу в алфавитном порядке. 
{
	$keys = array_keys($array); //получаем все ключи массива

    $sortedKeys = (sort($keys, fn ($left, $right) => strcmp($left, $right), true)); // сортируем их в алфавитном порядке

    foreach ($sortedKeys as $key => $value) {
        $sorted_array[$value] = $array[$value];
    }
    
    return $sorted_array; 
}