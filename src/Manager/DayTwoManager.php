<?php

declare(strict_types=1);

namespace App\Manager;

use App\Service\FileReader;

class DayTwoManager
{
    public const INCREASE = 'increase';
    public const DECREASE = 'decrease';
    public const EQUAL = 'equal';
    public const DIFFERENCE = 'difference';

    public function __construct(private readonly FileReader $fileReader, private readonly string $kernelProjectDir)
    {
    }

    public function getResult(): array
    {
        $input = $this->fileReader->readNewLineSeperatedFile($this->kernelProjectDir.'/data/days/2/input.txt');
        $result[0] = $this->getNumberOfSafeReports($input);
        $result[1] = $this->getNumberOfSafeReportsWithProblemDampener($input);

        return $result;
    }

    public function getNumberOfSafeReports(array $input): int
    {
        $number = 0;
        foreach ($input as $line) {
            $values = explode(' ', $line);
            if ($this->isReportSafe($values)) {
                ++$number;
            }
        }

        return $number;
    }

    public function getNumberOfSafeReportsWithProblemDampener(array $input): int
    {
        $number = 0;
        foreach ($input as $line) {
            $values = explode(' ', $line);
            $modifiedReport = $this->getReportEvaluationWithDampener($values);
            if ($this->isReportSafeWithDampener($modifiedReport)) {
                ++$number;
            }
        }

        return $number;
    }

    public function getReportEvaluation(array $line): array
    {
        $evaluation = [];

        foreach ($line as $key => $value) {
            if (false === isset($line[$key + 1])) {
                break;
            }

            if ($value === $line[$key + 1]) {
                $evaluation[$key] = self::EQUAL;
                continue;
            }

            $difference = abs((int) $value - (int) $line[$key + 1]);
            if ($difference > 3) {
                $evaluation[$key] = self::DIFFERENCE;
                continue;
            }

            if ($value < $line[$key + 1]) {
                $evaluation[$key] = self::INCREASE;
                continue;
            }

            if ($value > $line[$key + 1]) {
                $evaluation[$key] = self::DECREASE;
            }
        }

        return $evaluation;
    }

    public function isReportSafe(array $line): bool
    {
        $evaluation = $this->getReportEvaluation($line);

        if (in_array(self::DIFFERENCE, $evaluation)) {
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

    public function isReportSafeWithDampener(array $line): bool
    {
        if ($this->isReportSafe($line)) {
            return true;
        }

        $dampenerEvaluation = $this->getReportEvaluationWithDampener($line);

        return $this->isReportSafe($dampenerEvaluation);
    }

    public function getReportEvaluationWithDampener(array $line): array
    {
        $reportLength = count($line);

        for ($i = 0; $i <= $reportLength; ++$i) {
            $modifiedReport = $line;
            unset($modifiedReport[$i]);
            $modifiedReport = array_values($modifiedReport);

            if ($this->isReportSafe($modifiedReport)) {
                return $modifiedReport;
            }
        }

        return $line;
    }
}
