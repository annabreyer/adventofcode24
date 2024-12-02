<?php

declare(strict_types = 1);

namespace App\Tests\Manager;

use App\Manager\DayTwoManager;
use App\Service\FileReader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class DayTwoManagerTest extends TestCase
{
    private const INPUT = [
        '7 6 4 2 1',
        '1 2 7 8 9',
        '9 7 6 2 1',
        '1 3 2 4 5',
        '8 6 4 4 1',
        '1 3 6 7 9',
    ];

    public function testGetReportEvaluation(): void
    {
        $manager = new DayTwoManager(new FileReader(new Filesystem()), 'kernelProjectDir');

        $safeInput  = explode(' ', self::INPUT[0]);
        $result     = $manager->getReportEvaluation($safeInput);
        $evaluation = [
            DayTwoManager::DECREASE,
            DayTwoManager::DECREASE,
            DayTwoManager::DECREASE,
            DayTwoManager::DECREASE,
        ];
        self::assertSame($evaluation, $result);

        $unsafeInput = explode(' ', self::INPUT[1]);
        $result      = $manager->getReportEvaluation($unsafeInput);
        $evaluation  = [
            DayTwoManager::INCREASE,
            DayTwoManager::DIFFERENCE,
            DayTwoManager::INCREASE,
            DayTwoManager::INCREASE,
        ];
        self::assertSame($evaluation, $result);

        $unsafeInput = explode(' ', self::INPUT[2]);
        $result      = $manager->getReportEvaluation($unsafeInput);
        $evaluation  = [
            DayTwoManager::DECREASE,
            DayTwoManager::DECREASE,
            DayTwoManager::DIFFERENCE,
            DayTwoManager::DECREASE,
        ];
        self::assertSame($evaluation, $result);

        $unsafeInput = explode(' ', self::INPUT[3]);
        $result      = $manager->getReportEvaluation($unsafeInput);
        $evaluation  = [
            DayTwoManager::INCREASE,
            DayTwoManager::DECREASE,
            DayTwoManager::INCREASE,
            DayTwoManager::INCREASE,
        ];
        self::assertSame($evaluation, $result);

        $unsafeInput = explode(' ', self::INPUT[4]);
        $result      = $manager->getReportEvaluation($unsafeInput);
        $evaluation  = [
            DayTwoManager::DECREASE,
            DayTwoManager::DECREASE,
            DayTwoManager::EQUAL,
            DayTwoManager::DECREASE,
        ];
        self::assertSame($evaluation, $result);

        $safeInput  = explode(' ', self::INPUT[5]);
        $evaluation = [
            DayTwoManager::INCREASE,
            DayTwoManager::INCREASE,
            DayTwoManager::INCREASE,
            DayTwoManager::INCREASE,
        ];
        $result     = $manager->getReportEvaluation($safeInput);
        self::assertSame($evaluation, $result);
    }

    public function testIsReportSafe(): void
    {
        $manager = new DayTwoManager(new FileReader(new Filesystem()), 'kernelProjectDir');

        $input  = explode(' ', self::INPUT[0]);
        self::assertTrue($manager->isReportSafe($input));

        $input  = explode(' ', self::INPUT[1]);
        self::assertFalse($manager->isReportSafe($input));

        $input  = explode(' ', self::INPUT[2]);
        self::assertFalse($manager->isReportSafe($input));

        $input  = explode(' ', self::INPUT[3]);
        self::assertFalse($manager->isReportSafe($input));

        $input  = explode(' ', self::INPUT[4]);
        self::assertFalse($manager->isReportSafe($input));

        $input  = explode(' ', self::INPUT[5]);
        self::assertTrue($manager->isReportSafe($input));
    }

    public function testGetNumberOfSafeReports(): void
    {
        $manager = new DayTwoManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $result  = $manager->getNumberOfSafeReports(self::INPUT);
        self::assertEquals(2, $result);
    }

    public function testGetNumberOfSafeReportsWithProblemDampener(): void
    {
        $manager = new DayTwoManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $result  = $manager->getNumberOfSafeReportsWithProblemDampener(self::INPUT);
        self::assertEquals(4, $result);
    }
}
