<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Manager\DayFiveManager;
use App\Service\FileReader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class DayFiveManagerTest extends TestCase
{
    public const INPUT = [
        '47|53',
        '97|13',
        '97|61',
        '97|47',
        '75|29',
        '61|13',
        '75|53',
        '29|13',
        '97|29',
        '53|29',
        '61|53',
        '97|53',
        '61|29',
        '47|13',
        '75|47',
        '97|75',
        '47|61',
        '75|61',
        '47|29',
        '75|13',
        '53|13',

        '75,47,61,53,29',
        '97,61,53,29,13',
        '75,29,13',
        '75,97,47,61,53',
        '61,13,29',
        '97,13,75,29,47',
    ];

    public const RULES = [
        ['47', '53'],
        ['97', '13'],
        ['97', '61'],
        ['97', '47'],
        ['75', '29'],
        ['61', '13'],
        ['75', '53'],
        ['29', '13'],
        ['97', '29'],
        ['53', '29'],
        ['61', '53'],
        ['97', '53'],
        ['61', '29'],
        ['47', '13'],
        ['75', '47'],
        ['97', '75'],
        ['47', '61'],
        ['75', '61'],
        ['47', '29'],
        ['75', '13'],
        ['53', '13'],
    ];

    public const PAGES = [
        ['75', '47', '61', '53', '29'],
        ['97', '61', '53', '29', '13'],
        ['75', '29', '13'],
        ['75', '97', '47', '61', '53'],
        ['61', '13', '29'],
        ['97', '13', '75', '29', '47'],
    ];

    public function testGetOrderingRules(): void
    {
        $manager = new DayFiveManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $rules = $manager->getOrderingRulesFromInput(self::INPUT);

        self::assertIsArray($rules);
        self::assertSame(self::RULES, $rules);
    }

    public function testGetPagesFromInput(): void
    {
        $manager = new DayFiveManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $pages = $manager->getPagesFromInput(self::INPUT);

        self::assertIsArray($pages);
        self::assertSame(self::PAGES, $pages);
    }

    public function testArePagesCorrectlyOrderedReturnsTrue(): void
    {
        $manager = new DayFiveManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        self::assertTrue($manager->arePagesCorrectlyOrdered(self::PAGES[0], self::RULES));
        self::assertTrue($manager->arePagesCorrectlyOrdered(self::PAGES[1], self::RULES));
        self::assertTrue($manager->arePagesCorrectlyOrdered(self::PAGES[2], self::RULES));
    }

    public function testArePagesCorrectlyOrderedReturnsFalse(): void
    {
        $manager = new DayFiveManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        self::assertFalse($manager->arePagesCorrectlyOrdered(self::PAGES[3], self::RULES));
        self::assertFalse($manager->arePagesCorrectlyOrdered(self::PAGES[4], self::RULES));
        self::assertFalse($manager->arePagesCorrectlyOrdered(self::PAGES[5], self::RULES));

    }

    public function testGetMiddleNumber(): void
    {
        $manager = new DayFiveManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        self::assertSame(61, $manager->getMiddleNumber([75,47,61,53,29]));
        self::assertSame(53, $manager->getMiddleNumber([97,61,53,29,13]));
        self::assertSame(29, $manager->getMiddleNumber([75,29,13]));
    }

    public function testGetSumOfMiddleNumbersInCorrectlyOrderedUpdates(): void
    {
        $manager = new DayFiveManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        self::assertSame(143, $manager->getSumOfMiddleNumbersInCorrectlyOrderedUpdates(self::INPUT));
    }
}
