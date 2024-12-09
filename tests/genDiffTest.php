<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

use function Differ\Gendiff\genDiff;

class GenDiffTest extends TestCase
{
    #[DataProvider('additionProvider')]
    public function testGenDiff($a, $b, $format, $expected)
    {
        $this->assertEquals($expected, genDiff($a, $b, $format));
    }

    public static function additionProvider(): array
    {
        $filename1 = '/tests/fixtures/testFile1.json';
        $filename2 = '/tests/fixtures/testFile2.json';
        $filename4 = '/tests/fixtures/testFile1.yml';
        $filename5 = '/tests/fixtures/testFile2.yaml';
        $formatStylish = 'stylish';
        $formatPlain = 'plain';
        $formatJson = 'json';
        $expectedStylish = file_get_contents('tests/fixtures/stylishExpected.txt');
        $expectedPlain = file_get_contents('tests/fixtures/plainExpected.txt');
        $expectedJson = file_get_contents('tests/fixtures/jsonExpected.txt');

        return [
            'json to json. Format Stylish' => [$filename1, $filename2, $formatStylish, $expectedStylish],
            'yml to yaml. Format Stylish' => [$filename4, $filename5, $formatStylish, $expectedStylish],
            'json to yaml. Format Stylish' => [$filename1, $filename5, $formatStylish, $expectedStylish],
            'json to json. Format Plain' => [$filename1, $filename2, $formatPlain, $expectedPlain],
            'yml to yaml. Format Plain' => [$filename4, $filename5, $formatPlain, $expectedPlain],
            'json to yaml. Format Plain' => [$filename1, $filename5, $formatPlain, $expectedPlain],
            'json to json. Format Json' => [$filename1, $filename2, $formatJson, $expectedJson],
            'yml to yaml. Format Json' => [$filename4, $filename5, $formatJson, $expectedJson],
            'json to yaml. Format Json' => [$filename1, $filename5, $formatJson, $expectedJson]
        ];
    }

    // тест на наличие пустого содержимого
    public function testException1(): void
    {
        $this->expectException(\Exception::class);

        $filename2 = '/tests/fixtures/testFile2.json';
        $filename3 = '/tests/fixtures/testFile3.json'; //пустой файл
        $format = 'stylish';

        genDiff($filename2, $filename3, $format);
    }

    //тест на существование файла
    public function testException2(): void
    {
        $this->expectException(\Exception::class);

        $filename2 = '/tests/fixtures/testFile2.json';
        $filename1 = '/tests/fixtures/testFile7.yml'; //этого файла не существует
        $format = 'stylish';
        
        genDiff($filename1, $filename2, $format);
    }
}
