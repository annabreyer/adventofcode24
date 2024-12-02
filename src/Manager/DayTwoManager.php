<?php

declare(strict_types=1);

namespace App\Manager;

use App\Service\FileReader;

class DayTwoManager
{
    public const INCREASE = 'increase';
    public const DECREASE = 'decrease';

    public const EQUAL = 'equal';

    public function __construct(private readonly FileReader $fileReader, private readonly string $kernelProjectDir)
    {
    }

    public function getResult(): array
    {
        $input = $this->fileReader->readNewLineSeperatedFile($this->kernelProjectDir.'/data/days/2/input.txt');
        $result[0] = $this->getNumberOfSafeReports($input);
        $result[1] = 0;

        return $result;
    }

    public function getNumberOfSafeReports(array $input): int
    {
        $number = 0;
        foreach ($input as $line) {
            if ($this->getReportEvaluation($line)) {
                ++$number;
            }
        }

        return $number;
    }

    public function getReportEvaluation(string $line): bool
    {
        $values = explode(' ', $line);
        $evaluation = [];

        foreach ($values as $key => $value) {
            if (false === isset($values[$key + 1])) {
                break;
            }

            if ($value === $values[$key + 1]) {
                $evaluation[$key] = self::EQUAL;
                continue;
            }

            $difference = abs($value - (int) $values[$key + 1]);
            if ($value < $values[$key + 1] && $difference <= 3) {
                $evaluation[$key] = self::INCREASE;
                continue;
            }

            if ($value > $values[$key + 1] && $difference <= 3) {
                $evaluation[$key] = self::DECREASE;
                continue;
            }

            $evaluation[$key] = false;
        }

        if (in_array(false, $evaluation)) {
            return false;
        }

        if (in_array(self::EQUAL, $evaluation)) {
            return false;
        }

        if (in_array(self::INCREASE, $evaluation) && in_array(self::DECREASE, $evaluation)) {
            return false;
        }

        return true;
    }
}
