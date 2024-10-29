<?php

namespace GenerateDiff\Functions;

use function Functional\sort;

/**
* функция парсит содержиоме файла и декодирует строку JSON
*/

function parse($path) 
{
    if (!is_file($path)) {
        throw new \Exception('Oops! It is not a file!'); // если это не файл - выводим сообщение
    }

    $fileContent = file_get_contents($path); // получаем содержимое файла по введенному пути
    
    if (empty($fileContent)) {
        throw new \Exception("Oops! File {$path} is empty!"); // если файл пустой  - выводим сообщение
    }
    
    return json_decode($fileContent, true); // декодируем из json в асс. массив

}

/*
* функция сортировки ассоциативного массива по ключу в алфавитном порядке. 
* Используется функция sort из библиотеки Functional.
*/
// function sortArrayKeys($array): array
// {
// 	$keys = array_keys($array); //получаем все ключи массива
//     $sortedKeys = (sort($keys, fn ($left, $right) => strcmp($left, $right), true)); // сортируем их в алфавитном порядке

//     foreach ($sortedKeys as $key) {
//         $sorted_array[$key] = $array[$key]; //возращаем каждому ключу его значение
//     }
    
//     return $sorted_array;
// }   


/**
 * функция для приведения числовых и булевых значений к строковым
 */

function valueToString($value)
    {
        if ($value === null) {
            return 'null';
        } elseif ($value === false) {
            return 'false';
        } elseif ($value === true) {
            return 'true';
        } elseif (is_int($value) || is_float($value)) {
            return (string) $value;
        } else {
            return $value;
        }
    }