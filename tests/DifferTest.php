<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiff(): void
    {
        $pathFile1 = __DIR__ . '/fixtures/file1.json';
        $pathFile2 = __DIR__ . '/fixtures/file2.json';
        $pathFileExpected1 = __DIR__ . '/fixtures/Expected1';
        $resultGenDiff = genDiff($pathFile2, $pathFile1);
        $expected1 = file_get_contents($pathFileExpected1);
        $this->assertEquals($expected1, $resultGenDiff);
    }
}