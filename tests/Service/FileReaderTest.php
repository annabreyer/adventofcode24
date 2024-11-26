<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\FileReader;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FileReaderTest extends KernelTestCase
{
    public function testReadCommaSeperatedFileThrowsExceptionWhenFileDoesNotExist(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $fileReader = $container->get(FileReader::class);

        self::expectException(\Exception::class);
        $fileReader->readCommaSeperatedFile('data/test.txt');
    }

    public function testReadCommaSeperatedFileReturnsArray(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $fileReader = $container->get(FileReader::class);

        $expectedData = ['qd-', 'gh-', 'dm-', 'hq-', 'xfzdq=5', 'pxtn-', 'cdvh-'];
        $input = $fileReader->readCommaSeperatedFile('data/tests/comma_seperated.txt');
        self::assertIsArray($input);

        foreach ($expectedData as $data) {
            self::assertContains($data, $input);
        }
    }

    public function testNewLineSeperatedFileThrowsExceptionWhenFileDoesNotExist(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $fileReader = $container->get(FileReader::class);

        self::expectException(\Exception::class);
        $fileReader->readNewLineSeperatedFile('data/test.txt');
    }

    public function testNewLineSeperatedFileReturnsArray(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $fileReader = $container->get(FileReader::class);

        $expectedContent = [
            'Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green',
            'Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue',
            'Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red',
            'Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red',
            'Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green',
        ];

        $input = $fileReader->readNewLineSeperatedFile('data/tests/new_line_seperated.txt');
        self::assertIsArray($input);

        foreach ($expectedContent as $content) {
            self::assertContains($content, $input);
        }
    }
}
