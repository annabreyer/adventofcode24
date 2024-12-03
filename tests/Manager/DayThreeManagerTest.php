<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Manager\DayThreeManager;
use App\Service\FileReader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class DayThreeManagerTest extends TestCase
{
    public function testCleanInstructions(): void
    {
        $input = 'xmul(2,4)%&mul[3,7]!@^do_not_mul(5,5)+mul(32,64]then(mul(11,8)mul(8,5))';
        $manager = new DayThreeManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $cleanInstructions = $manager->cleanInstructions($input);

        self::assertSame(['mul(2,4)', 'mul(5,5)',  'mul(11,8)',  'mul(8,5)'], $cleanInstructions);
    }

    public function testGetNumbersFromInstruction(): void
    {
        $manager = new DayThreeManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $input = 'mul(2,4)';
        $result = $manager->getNumbersFromInstruction($input);

        self::assertSame([2, 4], $result);
    }

    public function testGetProgramOutput(): void
    {
        $input = 'xmul(2,4)%&mul[3,7]!@^do_not_mul(5,5)+mul(32,64]then(mul(11,8)mul(8,5))';
        $manager = new DayThreeManager(new FileReader(new Filesystem()), 'kernelProjectDir');
        $result = $manager->getProgramOutput($input);

        self::assertSame(161, $result);
    }
}
