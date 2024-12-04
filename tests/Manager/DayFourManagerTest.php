<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Manager\DayFourManager;
use App\Service\FileReader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class DayFourManagerTest extends TestCase
{
    public const INPUT = [
        'MMMSXXMASM',
        'MSAMXMSMSA',
        'AMXSXMAAMM',
        'MSAMASMSMX',
        'XMASAMXAMM',
        'XXAMMXXAMA',
        'SMSMSASXSS',
        'SAXAMASAAA',
        'MAMMMXMMMM',
        'MXMXAXMASX',
    ];

    public const GRID = [
        ['M', 'M', 'M', 'S', 'X', 'X', 'M', 'A', 'S', 'M'], // 0
        ['M', 'S', 'A', 'M', 'X', 'M', 'S', 'M', 'S', 'A'], // 1
        ['A', 'M', 'X', 'S', 'X', 'M', 'A', 'A', 'M', 'M'], // 2
        ['M', 'S', 'A', 'M', 'A', 'S', 'M', 'S', 'M', 'X'], // 3
        ['X', 'M', 'A', 'S', 'A', 'M', 'X', 'A', 'M', 'M'], // 4
        ['X', 'X', 'A', 'M', 'M', 'X', 'X', 'A', 'M', 'A'], // 5
        ['S', 'M', 'S', 'M', 'S', 'A', 'S', 'X', 'S', 'S'], // 6
        ['S', 'A', 'X', 'A', 'M', 'A', 'S', 'A', 'A', 'A'], // 7
        ['M', 'A', 'M', 'M', 'M', 'X', 'M', 'M', 'M', 'M'], // 8
        ['M', 'X', 'M', 'X', 'A', 'X', 'M', 'A', 'S', 'X'], // 9
    ];  // 0,   1    2    3    4    5    6    7    8    9

    public function testTransformTextInGrid(): void
    {
        $manager = new DayFourManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $grid = $manager->transformInputInGrid(self::INPUT);

        self::assertIsArray($grid);
        self::assertSame(self::GRID, $grid);
    }

    public function testGetNextXCoordinatesFindsFirstX(): void
    {
        $manager = new DayFourManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $coordinates = $manager->getFirstXCoordinates(self::GRID);

        self::assertSame(['x' => 4, 'y' => 0], $coordinates);
    }

    public function testIsXmasWrittenLeftToRightReturnsTrue(): void
    {
        $manager = new DayFourManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $result = $manager->isXmasWrittenLeftToRight(self::GRID, ['x' => 5, 'y' => 0]);

        self::assertTrue($result);
    }

    public function testIsXmasWrittenLeftToRightReturnsFalseWhenItsTheLastLetter(): void
    {
        $manager = new DayFourManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $result = $manager->isXmasWrittenLeftToRight(self::GRID, ['x' => 0, 'y' => 9]);

        self::assertFalse($result);
    }

    public function testIsXmasWrittenRightToLeftReturnsTrue(): void
    {
        $manager = new DayFourManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $result = $manager->isXmasWrittenRightToLeft(self::GRID, ['x' => 4, 'y' => 1]);

        self::assertTrue($result);
    }

    public function testIsXmasWrittenRightToLeftReturnsFalseWhenItsTheFirstLetter(): void
    {
        $manager = new DayFourManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $result = $manager->isXmasWrittenRightToLeft(self::GRID, ['x' => 0, 'y' => 0]);

        self::assertFalse($result);
    }

    public function testIsXmasWrittenUpwardsReturnsTrue(): void
    {
        $manager = new DayFourManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $grid = [
            ['S', 'S', '.', 'S', '.'],
            ['A', '.', 'A', '.', '.'],
            ['M', 'M', '.', 'M', '.'],
            ['X', '.', '.', '.', 'X'],
        ];
        $result = $manager->isXmasWrittenUpwards($grid, ['x' => 0, 'y' => 3]);

        self::assertTrue($result);
    }

    public function testIsXmasWrittenUpwardsReturnsFalseWhenItsTheFirstLine(): void
    {
        $manager = new DayFourManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $result = $manager->isXmasWrittenUpwards(self::GRID, ['x' => 0, 'y' => 4]);

        self::assertFalse($result);
    }

    public function testIsXmasWrittenDownwardsReturnsTrue(): void
    {
        $manager = new DayFourManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $grid = [
            ['X', 'S', '.', 'S', '.'],
            ['M', '.', 'A', '.', '.'],
            ['A', 'M', '.', 'M', '.'],
            ['S', '.', '.', '.', 'X'],
        ];
        $result = $manager->isXmasWrittenDownwards($grid, ['x' => 0, 'y' => 0]);

        self::assertTrue($result);
    }

    public function testIsXmasWrittenDownwardsReturnsFalseWhenItsTheLastLine(): void
    {
        $manager = new DayFourManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $result = $manager->isXmasWrittenDownwards(self::GRID, ['x' => 0, 'y' => 9]);

        self::assertFalse($result);
    }

    public function testIsXmasWrittenDiagonallyUpwardsRightReturnsTrue(): void
    {
        $manager = new DayFourManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $grid = [
            ['.', 'X', '.', 'S', '.'],
            ['.', '.', 'A', '.', '.'],
            ['.', 'M', '.', 'A', '.'],
            ['X', '.', '.', '.', 'S'],
        ];
        $result = $manager->isXmasWrittenDiagonallyUpwardsRight($grid, ['x' => 0, 'y' => 3]);

        self::assertTrue($result);
    }

    public function testIsXmasWrittenDiagonallyUpwardsRightReturnsFalseWhenItsTheFirstLine(): void
    {
        $manager = new DayFourManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $result = $manager->isXmasWrittenDiagonallyUpwardsRight(self::GRID, ['x' => 0, 'y' => 0]);

        self::assertFalse($result);
    }

    public function testIsXmasWrittenDiagonallyUpwardsLeftReturnsTrue(): void
    {
        $manager = new DayFourManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $grid = [
            ['.', 'S', '.', 'S', '.'],
            ['.', '.', 'A', '.', '.'],
            ['.', 'M', '.', 'M', '.'],
            ['X', '.', '.', '.', 'X'],
        ];

        $result = $manager->isXmasWrittenDiagonallyUpwardsLeft($grid, ['x' => 4, 'y' => 3]);

        self::assertTrue($result);
    }

    public function testIsXmasWrittenDiagonallyUpwardsLeftReturnsFalse(): void
    {
        $manager = new DayFourManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $result = $manager->isXmasWrittenDiagonallyUpwardsLeft(self::GRID, ['x' => 0, 'y' => 4]);

        self::assertFalse($result);
    }

    public function testIsXmasWrittenDiagonallyDownwardsRightReturnsTrue(): void
    {
        $manager = new DayFourManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $grid = [
            ['.', 'X', '.', '.', '.'],
            ['.', '.', 'M', '.', '.'],
            ['.', '.', '.', 'A', '.'],
            ['.', '.', '.', '.', 'S'],
        ];
        $result = $manager->isXmasWrittenDiagonallyDownwardsRight($grid, ['x' => 1, 'y' => 0]);

        self::assertTrue($result);
    }

    public function testIsXmasWrittenDiagonallyDownwardsRightReturnsFalseWhenItsTheLastLetter(): void
    {
        $manager = new DayFourManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $result = $manager->isXmasWrittenDiagonallyDownwardsRight(self::GRID, ['x' => 9, 'y' => 9]);

        self::assertFalse($result);
    }

    public function testIsXmasWrittenDiagonallyDownwardsLeftReturnsTrue(): void
    {
        $manager = new DayFourManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $result = $manager->isXmasWrittenDiagonallyDownwardsLeft(self::GRID, ['x' => 9, 'y' => 3]);

        self::assertTrue($result);
    }

    public function testIsXmasWrittenDiagonallyDownwardsLeftReturnsFalseWhenItsTheLastLine(): void
    {
        $manager = new DayFourManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $result = $manager->isXmasWrittenDiagonallyDownwardsLeft(self::GRID, ['x' => 0, 'y' => 9]);

        self::assertFalse($result);
    }

    public function testGetXmasCount(): void
    {
        $manager = new DayFourManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $result = $manager->getXmasCount(self::INPUT);

        $this->assertSame(18, $result);
    }
}
