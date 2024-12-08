<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

/*
 * функция проверяет существует ли файл, не пустой ли он,
 * парсит содержиоме json или yaml файла и декодирует строку в массив
 */
function parse(string $path): array
{
    if (!file_exists($path)) {
        throw new \Exception("Oops! No file {$path}!"); // если такого файла не существует - выводим сообщение
    }

    $fileContent = file_get_contents($path); // получаем содержимое файла по введенному пути

    if (empty($fileContent)) {
        throw new \Exception("Oops! File {$path} is empty!"); // если файл пустой  - выводим сообщение
    }

    $fileExtension = pathinfo($path, PATHINFO_EXTENSION);//получаем инфу о расширении файла: json или yaml(yml)

    if ($fileExtension === 'json') {
        return json_decode($fileContent, true);// декодируем из json в асс. массив
    }

    if ($fileExtension === 'yaml' || $fileExtension === 'yml') {
        return Yaml::parse($fileContent); // декодирум из yaml в асс. массив
    }
}
