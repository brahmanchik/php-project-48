<?php

namespace Differ\Tests;

use PhpParser\Node\Expr\Print_;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiff(): void
    {
        $pathFile1Json = __DIR__ . '/fixtures/file1.json';
        $pathFile2Json = __DIR__ . '/fixtures/file2.json';
        $pathFileExpected1 = __DIR__ . '/fixtures/expected1';
        $resultGenDiff = genDiff($pathFile1Json, $pathFile2Json);
        $expected1 = file_get_contents($pathFileExpected1);
        $this->assertEquals($expected1, $resultGenDiff);

        $pathFile1Yaml = __DIR__ . '/fixtures/file1.yaml';
        $pathFile2Yaml = __DIR__ . '/fixtures/file2.yaml';
        $pathFileExpected2 = __DIR__ . '/fixtures/expected1';
        $resultGenDiff = genDiff($pathFile1Yaml, $pathFile2Yaml);
        $expected2 = file_get_contents($pathFileExpected2);
        $this->assertEquals($expected2, $resultGenDiff);

        $pathFileExpected3 = __DIR__ . '/fixtures/expected2';
        $expectedPlain = file_get_contents($pathFileExpected3);
        $this->assertEquals($expectedPlain, genDiff($pathFile1Json, $pathFile2Json, 'plain'));

        $pathFileExpected4 = __DIR__ . '/fixtures/expected3';
        $expectedJson = file_get_contents($pathFileExpected4);
        $this->assertEquals($expectedJson, genDiff($pathFile1Json, $pathFile2Json, 'json'));
    }
}
