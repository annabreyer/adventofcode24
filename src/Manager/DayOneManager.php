<?php

declare(strict_types=1);

namespace App\Manager;

use App\Service\FileReader;

class DayOneManager
{
    public function __construct(private readonly FileReader $fileReader, private readonly string $kernelProjectDir)
    {
    }

    public function getResult(): array
    {
        $input = $this->fileReader->readNewLineSeperatedFile($this->kernelProjectDir.'/data/days/1/input.txt');
        $result[0] = $this->getTotalDistance($input);
        $result[1] = $this->getSimilarityScore($input);

        return $result;
    }

    public function separateInTwoSortedLists(array $input): array
    {
        foreach ($input as $line) {
            $locations = explode(' ', $line);
            $locations = array_values(array_filter($locations));
            $firstList[] = $locations[0];
            $secondList[] = $locations[1];
        }

        sort($firstList, SORT_NUMERIC);
        sort($secondList, SORT_NUMERIC);

        return [$firstList, $secondList];
    }

    public function getDistance(string $locationOne, string $locationTwo): int
    {
        $difference = (int) bcsub($locationOne, $locationTwo);
        $distance = abs($difference);

        return $distance;
    }

    public function getTotalDistance(array $input): int
    {
        $locationLists = $this->separateInTwoSortedLists($input);
        $firstList = $locationLists[0];
        $secondList = $locationLists[1];
        $result = 0;

        foreach ($firstList as $key => $firstLocation) {
            $result += $this->getDistance($firstLocation, $secondList[$key]);
        }

        return $result;
    }

    public function getSimilarityScore($input): int
    {
        $locationLists = $this->separateInTwoSortedLists($input);
        $firstList = $locationLists[0];
        $secondList = $locationLists[1];
        $score = 0;

        $secondLocationCount = array_count_values($secondList);

        foreach ($firstList as $firstLocation) {
            if (!isset($secondLocationCount[$firstLocation])) {
                continue;
            }
            $count = $secondLocationCount[$firstLocation];
            $score += ($firstLocation * $count);
        }

        return $score;
    }
}
