<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

use function Differ\Gendiff\genDiff;

class GenDiffTest extends TestCase
{
    #[DataProvider('additionProvider')]
    public function testGenDiff($a, $b, $expected)
    {
        $format = 'stylish';
        $this->assertEquals($expected, genDiff($a, $b, $format));
    }

    public static function additionProvider(): array
    {
        $filename1 = '/tests/fixtures/testFile1.json';
        $filename2 = '/tests/fixtures/testFile2.json';
        $filename4 = '/tests/fixtures/testFile1.yml';
        $filename5 = '/tests/fixtures/testFile2.yaml';
        $expected = file_get_contents('tests/fixtures/expected.txt');

        return [
            [$filename1, $filename2, $expected],
            [$filename4, $filename5, $expected],
            [$filename1, $filename5, $expected]
        ];
    }

    public function testException1(): void // тест на наличие пустого содержимого
    {
        $this->expectException(\Exception::class);

        $filename2 = '/tests/fixtures/testFile2.json';
        $filename3 = '/tests/fixtures/testFile3.json';
        $format = 'stylish';

        genDiff($filename2, $filename3, $format);
    }

    public function testException2(): void //тест на существование файла
    {
        $this->expectException(\Exception::class);

        $filename2 = '/tests/fixtures/testFile2.json';
        $filename1 = '/tests/fixtures/testFile7.yml'; //этого файла не существует
        $format = 'stylish';
        
        genDiff($filename1, $filename2, $format);
    }
}
