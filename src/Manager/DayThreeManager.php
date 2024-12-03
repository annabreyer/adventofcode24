<?php declare(strict_types = 1);

namespace App\Manager;

use App\Service\FileReader;

class DayThreeManager
{
    public function __construct(private readonly FileReader $fileReader, private readonly string $kernelProjectDir)
    {
    }

    public function getResult(): array
    {
        $input     = $this->fileReader->readFile($this->kernelProjectDir . '/data/days/3/input.txt');
        $result[0] = $this->getProgramOutput($input);
        $result[1] = 0;

        return $result;
    }

    public function getProgramOutput(string $instructions): int
    {
        $multiplications = $this->cleanInstructions($instructions);
        $result = 0;
        foreach ($multiplications as $multiplication) {
            $numbers = $this->getNumbersFromInstruction($multiplication);
            $result += $numbers[0] * $numbers[1];
        }

        return $result;
    }

    public function cleanInstructions(string $instructions): array
    {
       // Match valid `mul(X,Y)` where X and Y are 1-3 digit numbers
        $pattern = '/mul\(\d{1,3},\d{1,3}\)/';

        // Find all matches
        preg_match_all($pattern, $instructions, $matches);

        // Join the valid instructions with a space (or other separator, if needed)
        return $matches[0];
    }

    public function getNumbersFromInstruction(string $multiplication): array
    {
        $pattern = '/mul\((\d+),(\d+)\)/';

        if (preg_match($pattern, $multiplication, $matches)) {
            // $matches[1] and $matches[2] contain the two numbers
            return [(int)$matches[1], (int)$matches[2]];
        }

        // Return an empty array if no match is found
        return [];

    }

}
