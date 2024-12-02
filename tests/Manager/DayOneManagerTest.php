<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Manager\DayOneManager;
use App\Service\FileReader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class DayOneManagerTest extends TestCase
{
    public function testSeparateInTwoSortedLists(): void
    {
        $input = [
            '3   4',
            '4   3',
            '2   5',
            '1   3',
            '3   9',
            '3   3',
        ];

        $manager = new DayOneManager(new FileReader(new Filesystem()));
        $result = $manager->separateInTwoSortedLists($input);
        $this->assertEquals($result, [
            ['1', '2', '3', '3', '3', '4'],
            ['3', '3', '3', '4', '5', '9'],
        ]);
    }

    public function testGetDistance(): void
    {
        $manager = new DayOneManager(new FileReader(new Filesystem()));
        $result = $manager->getDistance('1', '3');
        self::assertEquals('2', $result);
        $result = $manager->getDistance('2', '3');
        self::assertEquals('1', $result);
        $result = $manager->getDistance('3', '4');
        self::assertEquals('1', $result);
        $result = $manager->getDistance('3', '5');
        self::assertEquals('2', $result);
        $result = $manager->getDistance('4', '9');
        self::assertEquals('5', $result);
    }

    public function testGetTotalDistance(): void
    {
        $input = [
            '3   4',
            '4   3',
            '2   5',
            '1   3',
            '3   9',
            '3   3',
        ];
        $manager = new DayOneManager(new FileReader(new Filesystem()));
        $result = $manager->getTotalDistance($input);

        self::assertEquals(11, $result);
    }
}
