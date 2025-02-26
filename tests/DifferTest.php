<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    private function getFixturePath(string $filename): string
    {
        return __DIR__ . "/fixtures/{$filename}";
    }

    public function testGenDiff(): void
    {
        $formats = ['json', 'yaml', 'yml'];
        foreach ($formats as $format) {
            $file1 = $this->getFixturePath("file1.{$format}");
            $file2 = $this->getFixturePath("file2.{$format}");
            $expectedStylish = file_get_contents($this->getFixturePath('expected1'));

            $this->assertEquals($expectedStylish, genDiff($file1, $file2));
        }

        // Проверка JSON, YAML и yml в форматах stylish и plain и json
        $expectedStylish = file_get_contents($this->getFixturePath('expected1'));
        $this->assertEquals($expectedStylish, genDiff(
            $this->getFixturePath('file1.json'),
            $this->getFixturePath('file2.yaml')
        ));

        $expectedPlain = file_get_contents($this->getFixturePath('expected2'));
        $this->assertEquals($expectedPlain, genDiff(
            $this->getFixturePath('file1.json'),
            $this->getFixturePath('file2.yaml'), 'plain')
        );

        $expectedPlain = file_get_contents($this->getFixturePath('expected3'));
        $this->assertEquals($expectedPlain, genDiff(
                $this->getFixturePath('file1.json'),
                $this->getFixturePath('file2.yml'), 'json')
        );
    }
}