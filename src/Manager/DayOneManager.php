<?php declare(strict_types = 1);

namespace App\Manager;

use App\Service\FileReader;

class DayOneManager
{
    public function __construct(private readonly FileReader $fileReader)
    {

    }

    public function getResult(): int
    {
        $input = $this->fileReader->readCommaSeperatedFile('data/days/1/input.txt');

        return 1;
    }
}
