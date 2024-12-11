<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

/*
 * функция парсит содержиоме json или yaml файла и декодирует строку в массив
 */
function parse(string $fileContent, string $fileExtension): array
{
    return match ($fileExtension) {
        'json' => json_decode($fileContent, true),// декодируем из json в асс. массив

        'yaml' => Yaml::parse($fileContent),// декодирум из yaml в асс. массив

        'yml' =>  Yaml::parse($fileContent), // декодирум из yaml в асс. массив

        default => throw new \Exception("This utility can't work with .{$fileExtension} extension.")
    };
}
