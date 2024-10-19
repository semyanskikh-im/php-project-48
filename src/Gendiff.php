<?php

Namespace GenerateDiff\Gendiff;

use Docopt;
use function GenerateDiff\Parser\parse;

function run()
{
    $doc = <<<DOC
    Generate diff

    Usage:
      gendiff (-h|--help)
      gendiff (-v|--version)
      gendiff [--format <fmt>] <firstFile> <secondFile>

    Options:
      -h --help                     Show this screen
      -v --version                  Show version
      --format <fmt>                Report format [default: stylish]

    DOC;

    $params = [
        'version'=>'Generate Diff 1.0'
      ];

    $args = Docopt::handle($doc, $params);

    if (isset($args['<firstFile>']) && isset($args['<secondFile>'])) { //если заданы названия обоих файлов, то...

      $firstFilePath = __DIR__ . "/../files/{$args['<firstFile>']}"; // путь до первого файла
      $secondFilePath = __DIR__ . "/../files/{$args['<secondFile>']}"; // путь до второго файла

      echo $firstFilePath . PHP_EOL;
      echo $secondFilePath . PHP_EOL;
      
      $firstParserResult = parse($firstFilePath);
      $secondParserResult = parse($secondFilePath);

    print_r($firstParserResult) . PHP_EOL;
    print_r($secondParserResult) . PHP_EOL;
    }

  }