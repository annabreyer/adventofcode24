<?php

declare(strict_types=1);

namespace App\Manager;

use App\Service\FileReader;

class DayFourManager
{
    public function __construct(private readonly FileReader $fileReader, private readonly string $kernelProjectDir)
    {
    }

    public function getResult(): array
    {
        $input = $this->fileReader->readNewLineSeperatedFile($this->kernelProjectDir.'/data/days/4/input.txt');
        $result[0] = $this->getXmasCount($input);
        $result[1] = $this->getCrossCount($input);

        return $result;
    }

    public function getXmasCount(array $input): int
    {
        $count = 0;
        $grid = $this->transformInputInGrid($input);

        foreach ($grid as $y => $line) {
            foreach ($line as $x => $letter) {
                if ('X' !== $letter) {
                    continue;
                }

                $coordinates = ['x' => $x, 'y' => $y];
                if ($this->isXmasWrittenDiagonallyDownwardsLeft($grid, $coordinates)) {
                    ++$count;
                }

                if ($this->isXmasWrittenDiagonallyDownwardsRight($grid, $coordinates)) {
                    ++$count;
                }

                if ($this->isXmasWrittenDiagonallyUpwardsLeft($grid, $coordinates)) {
                    ++$count;
                }

                if ($this->isXmasWrittenDiagonallyUpwardsRight($grid, $coordinates)) {
                    ++$count;
                }

                if ($this->isXmasWrittenDownwards($grid, $coordinates)) {
                    ++$count;
                }

                if ($this->isXmasWrittenUpwards($grid, $coordinates)) {
                    ++$count;
                }

                if ($this->isXmasWrittenLeftToRight($grid, $coordinates)) {
                    ++$count;
                }

                if ($this->isXmasWrittenRightToLeft($grid, $coordinates)) {
                    ++$count;
                }
            }
        }

        return $count;
    }

    public function getCrossCount(array $input): int
    {
        $grid = $this->transformInputInGrid($input);
        $count = 0;

        foreach ($grid as $y => $line) {
            foreach ($line as $x => $letter) {
                if ('A' !== $letter) {
                    continue;
                }

                if ($this->isCenterOfMasCross($grid, ['x' => $x, 'y' => $y])) {
                    ++$count;
                }
            }
        }

        return $count;
    }

    public function transformInputInGrid(array $input): array
    {
        $grid = [];
        foreach ($input as $key => $line) {
            $grid[$key] = str_split($line);
        }

        return $grid;
    }

    public function isXmasWrittenLeftToRight(array $grid, array $xCoordinates): bool
    {
        $line = $grid[$xCoordinates['y']];
        $x = $xCoordinates['x'];

        if (false === isset($line[$x + 3])) {
            return false;
        }

        if (isset($line[$x + 1]) && 'M' !== $line[$x + 1]) {
            return false;
        }

        if (isset($line[$x + 2]) && 'A' !== $line[$x + 2]) {
            return false;
        }

        if (isset($line[$x + 3]) && 'S' !== $line[$x + 3]) {
            return false;
        }

        return true;
    }

    public function isXmasWrittenRightToLeft(array $grid, array $xCoordinates): bool
    {
        $line = $grid[$xCoordinates['y']];
        $x = $xCoordinates['x'];

        if (false === isset($line[$x - 3])) {
            return false;
        }

        if (isset($line[$x - 1]) && 'M' !== $line[$x - 1]) {
            return false;
        }

        if (isset($line[$x - 2]) && 'A' !== $line[$x - 2]) {
            return false;
        }

        if (isset($line[$x - 3]) && 'S' !== $line[$x - 3]) {
            return false;
        }

        return true;
    }

    public function isXmasWrittenUpwards(array $grid, array $xCoordinates): bool
    {
        $x = $xCoordinates['x'];
        $y = $xCoordinates['y'];

        if (false === isset($grid[$y - 3])) {
            return false;
        }

        if (isset($grid[$y - 1][$x]) && 'M' !== $grid[$y - 1][$x]) {
            return false;
        }

        if (isset($grid[$y - 2][$x]) && 'A' !== $grid[$y - 2][$x]) {
            return false;
        }

        if (isset($grid[$y - 3][$x]) && 'S' !== $grid[$y - 3][$x]) {
            return false;
        }

        return true;
    }

    public function isXmasWrittenDownwards(array $grid, array $xCoordinates): bool
    {
        $x = $xCoordinates['x'];
        $y = $xCoordinates['y'];

        if (false === isset($grid[$y + 3])) {
            return false;
        }

        if (isset($grid[$y + 1][$x]) && 'M' !== $grid[$y + 1][$x]) {
            return false;
        }

        if (isset($grid[$y + 2][$x]) && 'A' !== $grid[$y + 2][$x]) {
            return false;
        }

        if (isset($grid[$y + 3][$x]) && 'S' !== $grid[$y + 3][$x]) {
            return false;
        }

        return true;
    }

    public function isXmasWrittenDiagonallyUpwardsRight(array $grid, array $xCoordinates): bool
    {
        $x = $xCoordinates['x'];
        $y = $xCoordinates['y'];

        if (false === isset($grid[$y - 3][$x + 3])) {
            return false;
        }

        if (isset($grid[$y - 1][$x + 1]) && 'M' !== $grid[$y - 1][$x + 1]) {
            return false;
        }

        if (isset($grid[$y - 2][$x + 2]) && 'A' !== $grid[$y - 2][$x + 2]) {
            return false;
        }

        if (isset($grid[$y - 3][$x + 3]) && 'S' !== $grid[$y - 3][$x + 3]) {
            return false;
        }

        return true;
    }

    public function isXmasWrittenDiagonallyUpwardsLeft(array $grid, array $xCoordinates): bool
    {
        $x = $xCoordinates['x'];
        $y = $xCoordinates['y'];

        if (false === isset($grid[$y - 3][$x - 3])) {
            return false;
        }

        if (isset($grid[$y - 1][$x - 1]) && 'M' !== $grid[$y - 1][$x - 1]) {
            return false;
        }

        if (isset($grid[$y - 2][$x - 2]) && 'A' !== $grid[$y - 2][$x - 2]) {
            return false;
        }

        if (isset($grid[$y - 3][$x - 3]) && 'S' !== $grid[$y - 3][$x - 3]) {
            return false;
        }

        return true;
    }

    public function isXmasWrittenDiagonallyDownwardsRight(array $grid, array $xCoordinates): bool
    {
        $x = $xCoordinates['x'];
        $y = $xCoordinates['y'];

        if (false === isset($grid[$y + 3][$x + 3])) {
            return false;
        }

        if (isset($grid[$y + 1][$x + 1]) && 'M' !== $grid[$y + 1][$x + 1]) {
            return false;
        }

        if (isset($grid[$y + 2][$x + 2]) && 'A' !== $grid[$y + 2][$x + 2]) {
            return false;
        }

        if (isset($grid[$y + 3][$x + 3]) && 'S' !== $grid[$y + 3][$x + 3]) {
            return false;
        }

        return true;
    }

    public function isXmasWrittenDiagonallyDownwardsLeft(array $grid, array $xCoordinates): bool
    {
        $x = $xCoordinates['x'];
        $y = $xCoordinates['y'];

        if (false === isset($grid[$y + 3][$x - 3])) {
            return false;
        }

        if (isset($grid[$y + 1][$x - 1]) && 'M' !== $grid[$y + 1][$x - 1]) {
            return false;
        }

        if (isset($grid[$y + 2][$x - 2]) && 'A' !== $grid[$y + 2][$x - 2]) {
            return false;
        }

        if (isset($grid[$y + 3][$x - 3]) && 'S' !== $grid[$y + 3][$x - 3]) {
            return false;
        }

        return true;
    }

    public function isCenterOfMasCross(array $grid, array $aCoordinates): bool
    {
        $x = $aCoordinates['x'];
        $y = $aCoordinates['y'];

        if (false === isset($grid[$y + 1][$x + 1]) || false === isset($grid[$y - 1][$x - 1])) {
            return false;
        }

        $leftToRight = false;
        $rightToLeft = false;

        if (
            ('M' === $grid[$y - 1][$x - 1] && 'S' === $grid[$y + 1][$x + 1]) // MAS
            || ('S' === $grid[$y - 1][$x - 1] && 'M' === $grid[$y + 1][$x + 1]) // SAM
        ) {
            $leftToRight = true;
        }

        if (
            ('S' === $grid[$y + 1][$x - 1] && 'M' === $grid[$y - 1][$x + 1])
            || ('M' === $grid[$y + 1][$x - 1] && 'S' === $grid[$y - 1][$x + 1])
        ) {
            $rightToLeft = true;
        }

        return $rightToLeft && $leftToRight;
    }
}
