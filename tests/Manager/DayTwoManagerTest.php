<?php declare(strict_types = 1);

namespace App\Tests\Manager;

use App\Manager\DayTwoManager;
use App\Service\FileReader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class DayTwoManagerTest extends TestCase
{

    public function testGetReportEvaluation(): void
    {
        $manager = new DayTwoManager(new FileReader(new Filesystem()), 'kernelProjectDir');

        $safeInput = '7 6 4 2 1';
        $result = $manager->getReportEvaluation($safeInput);
        self::assertTrue($result);

        $unsafeInput = '1 2 7 8 9';
        $result = $manager->getReportEvaluation($unsafeInput);
        self::assertFalse($result);

        $unsafeInput = '9 7 6 2 1';
        $result = $manager->getReportEvaluation($unsafeInput);
        self::assertFalse($result);

        $unsafeInput = '1 3 2 4 5';
        $result = $manager->getReportEvaluation($unsafeInput);
        self::assertFalse($result);

        $unsafeInput = '8 6 4 4 1';
        $result = $manager->getReportEvaluation($unsafeInput);
        self::assertFalse($result);

        $safeInput = '1 3 6 7 9';
        $result = $manager->getReportEvaluation($safeInput);
        self::assertTrue($result);
    }


    public function testGetNumberOfSafeReports(): void
    {
        $manager = new DayTwoManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $input   = [
            '7 6 4 2 1',
            '1 2 7 8 9',
            '9 7 6 2 1',
            '1 3 2 4 5',
            '8 6 4 4 1',
            '1 3 6 7 9',
        ];
        $result = $manager->getNumberOfSafeReports($input);
        self::assertEquals(2, $result);
    }

}