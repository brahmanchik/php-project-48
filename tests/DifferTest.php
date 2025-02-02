<?php

namespace Differ\Tests;

use PhpParser\Node\Expr\Print_;
use PHPUnit\Framework\TestCase;
use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiff(): void
    {
        $pathFile1 = __DIR__ . '/fixtures/file1.json';
        $pathFile2 = __DIR__ . '/fixtures/file2.json';
        $pathFileExpected1 = __DIR__ . '/fixtures/Expected1';
        $resultGenDiff = genDiff($pathFile1, $pathFile2);
        $expected1 = file_get_contents($pathFileExpected1);
        //dd($expected1, $resultGenDiff);
        $this->assertEquals("$expected1", $resultGenDiff);
    }
}