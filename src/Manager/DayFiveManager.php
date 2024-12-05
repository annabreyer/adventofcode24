<?php

declare(strict_types=1);

namespace App\Manager;

use App\Service\FileReader;

class DayFiveManager
{
    public function __construct(private readonly FileReader $fileReader, private readonly string $kernelProjectDir)
    {
    }

    public function getResult(): array
    {
        $input = $this->fileReader->readNewLineSeperatedFile($this->kernelProjectDir.'/data/days/5/input.txt');
        $result[0] = $this->getSumOfMiddleNumbersInCorrectlyOrderedUpdates($input);
        $result[1] = 0;;
        return $result;
    }

    public function getSumOfMiddleNumbersInCorrectlyOrderedUpdates(array $input): int
    {
        $rules   = $this->getOrderingRulesFromInput($input);
        $updates = $this->getPagesFromInput($input);
        $sum     = 0;

        foreach ($updates as $update) {
            if ($this->arePagesCorrectlyOrdered($update, $rules)) {
                $sum += $this->getMiddleNumber($update);
            }

        }

        return $sum;
    }


    public function getOrderingRulesFromInput(array $input): array
    {
        $rules = [];

        foreach ($input as $line){
            if (false !== strpos($line, '|')){
                $rules[] = explode('|', $line);
            }
        }

        return $rules;
    }

    public function getPagesFromInput(array $input): array
    {
        $pages = [];

        foreach ($input as $line){
            if (false === strpos($line, '|')){
                $pages[] = explode(',', $line);
            }
        }

        return $pages;
    }

    public function arePagesCorrectlyOrdered(array $pageNumbers, array $rules): bool
    {
        $positions = array_flip($pageNumbers);

        foreach ($rules as [$first, $second]) {
            // Check if both pages exist in the update
            if (isset($positions[$first], $positions[$second])) {
                // Validate the order
                if ($positions[$first] > $positions[$second]) {
                    return false;
                }
            }
        }

        return true;
    }

    public function getMiddleNumber(array $pageNumbers): int
    {
        $length = count($pageNumbers);
        $middleKey = intdiv($length, 2);

        return (int)$pageNumbers[$middleKey];
    }
}
