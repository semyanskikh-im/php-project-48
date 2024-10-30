<?php

namespace GenerateDiff\Tests;

use PHPUnit\Framework\TestCase;
use function GenerateDiff\Gendiff\genDiff;

class genDiffTest extends TestCase
{
    public function testGenDiff(): void
    {
        $filename1 = '/tests/fixtures/testFile1.json';
        $filename2 = '/tests/fixtures/testFile2.json';

        $expected = <<<ROF
        {
          - follow: false
          + homepage: null
            host: hexlet.io
          - proxy: 123.234.53.22
          - timeout: 10
          + timeout: 20
          + verbose: true
          - vpn: not use
          + vpn: use
        }
        
        ROF;

        $this->assertEquals($expected, genDiff($filename1, $filename2));

    }
}