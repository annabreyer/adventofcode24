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
        $result[1] = 0;

        return $result;
    }


    public function getXmasCount(array $input): int
    {
        $count = 0;
        $grid = $this->transformInputInGrid($input);

        foreach ($grid as $y => $line){
            foreach ($line as $x => $letter){
                if ('X' !== $letter){
                    continue;
                }

                $coordinates = ['x' => $x, 'y' => $y];
                if ($this->isXmasWrittenDiagonallyDownwardsLeft($grid, $coordinates)){
                    $count++;
                }

                if ($this->isXmasWrittenDiagonallyDownwardsRight($grid, $coordinates)){
                    $count++;
                }

                if ($this->isXmasWrittenDiagonallyUpwardsLeft($grid, $coordinates)){
                    $count++;
                }

                if ($this->isXmasWrittenDiagonallyUpwardsRight($grid, $coordinates)){
                    $count++;
                }

                if ($this->isXmasWrittenDownwards($grid, $coordinates)){
                    $count++;
                }

                if ($this->isXmasWrittenUpwards($grid, $coordinates)){
                    $count++;
                }

                if ($this->isXmasWrittenLeftToRight($grid, $coordinates)){
                    $count++;
                }

                if ($this->isXmasWrittenRightToLeft($grid, $coordinates)){
                    $count++;
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

    public function getFirstXCoordinates(array $grid): array
    {
        $coordinates = [
            'x' => null,
            'y' => null,
        ];

        foreach ($grid as $key => $line) {
            $xCoordinate = array_search('X', $line);
            if (false !== $xCoordinate) {
                $coordinates['x'] = $xCoordinate;
                $coordinates['y'] = $key;
                break;
            }
        }

        return $coordinates;
    }

    public function isXmasWrittenLeftToRight(array $grid, array $xCoordinates): bool
    {
        $line = $grid[$xCoordinates['y']];
        $x = $xCoordinates['x'];

        if (false === isset($line[$x+3])) {
            return false;
        }

        if (isset($line[$x+1]) && $line[$x+1] !== 'M') {
            return false;
        }

        if (isset($line[$x+2]) && $line[$x+2] !== 'A') {
            return false;
        }

        if (isset($line[$x+3]) && $line[$x+3] !== 'S') {
            return false;
        }

        return true;
    }

    public function isXmasWrittenRightToLeft(array $grid, array $xCoordinates): bool
    {
        $line = $grid[$xCoordinates['y']];
        $x = $xCoordinates['x'];

        if (false === isset($line[$x-3])) {
            return false;
        }

        if (isset($line[$x-1]) && $line[$x-1] !== 'M') {
            return false;
        }

        if (isset($line[$x-2]) && $line[$x-2] !== 'A') {
            return false;
        }

        if (isset($line[$x-3]) && $line[$x-3] !== 'S') {
            return false;
        }

        return true;
    }

    public function isXmasWrittenUpwards(array $grid, array $xCoordinates): bool
    {
        $x = $xCoordinates['x'];
        $y = $xCoordinates['y'];

        if (false === isset($grid[$y-3])) {
            return false;
        }

        if (isset($grid[$y-1][$x]) && $grid[$y-1][$x] !== 'M') {
            return false;
        }

        if (isset($grid[$y-2][$x]) && $grid[$y-2][$x] !== 'A') {
            return false;
        }

        if (isset($grid[$y-3][$x]) && $grid[$y-3][$x] !== 'S') {
            return false;
        }

        return true;
    }

    public function isXmasWrittenDownwards(array $grid, array $xCoordinates): bool
    {
        $x = $xCoordinates['x'];
        $y = $xCoordinates['y'];


        if (false === isset($grid[$y+3])) {
            return false;
        }

        if (isset($grid[$y+1][$x]) && $grid[$y+1][$x] !== 'M') {
            return false;
        }

        if (isset($grid[$y+2][$x]) && $grid[$y+2][$x] !== 'A') {
            return false;
        }

        if (isset($grid[$y+3][$x]) && $grid[$y+3][$x] !== 'S') {
            return false;
        }

        return true;
    }

    public function isXmasWrittenDiagonallyUpwardsRight(array $grid, array $xCoordinates): bool
    {
        $x = $xCoordinates['x'];
        $y = $xCoordinates['y'];

        if (false === isset($grid[$y-3][$x+3])) {
            return false;
        }

        if (isset($grid[$y-1][$x+1]) && $grid[$y-1][$x+1] !== 'M') {
            return false;
        }

        if (isset($grid[$y-2][$x+2]) && $grid[$y-2][$x+2] !== 'A') {
            return false;
        }

        if (isset($grid[$y-3][$x+3]) && $grid[$y-3][$x+3] !== 'S') {
            return false;
        }

        return true;
    }

    public function isXmasWrittenDiagonallyUpwardsLeft(array $grid, array $xCoordinates): bool
    {
        $x = $xCoordinates['x'];
        $y = $xCoordinates['y'];

        if (false === isset($grid[$y-3][$x-3])) {
            return false;
        }

        if (isset($grid[$y-1][$x-1]) && $grid[$y-1][$x-1] !== 'M') {
            return false;
        }

        if (isset($grid[$y-2][$x-2]) && $grid[$y-2][$x-2] !== 'A') {
            return false;
        }

        if (isset($grid[$y-3][$x-3]) && $grid[$y-3][$x-3] !== 'S') {
            return false;
        }

        return true;
    }

    public function isXmasWrittenDiagonallyDownwardsRight(array $grid, array $xCoordinates): bool
    {
        $x = $xCoordinates['x'];
        $y = $xCoordinates['y'];

        if (false === isset($grid[$y+3][$x+3])) {
            return false;
        }

        if (isset($grid[$y+1][$x+1]) && $grid[$y+1][$x+1] !== 'M') {
            return false;
        }

        if (isset($grid[$y+2][$x+2]) && $grid[$y+2][$x+2] !== 'A') {
            return false;
        }

        if (isset($grid[$y+3][$x+3]) && $grid[$y+3][$x+3] !== 'S') {
            return false;
        }

        return true;
    }

    public function isXmasWrittenDiagonallyDownwardsLeft(array $grid, array $xCoordinates): bool
    {
        $x = $xCoordinates['x'];
        $y = $xCoordinates['y'];

        if (false === isset($grid[$y+3][$x-3])) {
            return false;
        }

        if (isset($grid[$y+1][$x-1]) && $grid[$y+1][$x-1] !== 'M') {
            return false;
        }

        if (isset($grid[$y+2][$x-2]) && $grid[$y+2][$x-2] !== 'A') {
            return false;
        }

        if (isset($grid[$y+3][$x-3]) && $grid[$y+3][$x-3] !== 'S') {
            return false;
        }

        return true;
    }
}
