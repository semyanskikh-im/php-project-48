<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

/*
 * функция парсит содержиоме json или yaml файла и декодирует строку в объект
 */
function parse(string $fileContent, string $fileExtension): object
{
    return match ($fileExtension) {
        'json' => json_decode($fileContent),// декодируем из json в Std:Class Object

        'yaml' => Yaml::parse($fileContent, Yaml::PARSE_OBJECT_FOR_MAP),// декодирум из yaml Std:Class Object

        'yml' =>  Yaml::parse($fileContent, Yaml::PARSE_OBJECT_FOR_MAP), // декодирум из yaml в Std:Class Object

        default => throw new \Exception("This utility can't work with .{$fileExtension} extension.")
    };
}
