<?php

namespace GenerateDiff\Functions;

use function Functional\sort;

/*
 * функция парсит содержиоме json-файла и декодирует строку JSON
 */
function parse($path)
{
    if (!is_file($path)) {
        throw new \Exception('Oops! No file!'); // если это не файл - выводим сообщение
    }

    $fileContent = file_get_contents($path); // получаем содержимое файла по введенному пути

    if (empty($fileContent)) {
        throw new \Exception("Oops! File {$path} is empty!"); // если файл пустой  - выводим сообщение
    }

    return json_decode($fileContent, true); // декодируем из json в асс. массив
}

/*
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
