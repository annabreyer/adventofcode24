<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

readonly class FileReader
{
    public function __construct(private Filesystem $fileSystem)
    {
    }

    public function readCommaSeperatedFile(string $filePath): array
    {
        if (!$this->fileSystem->exists($filePath)) {
            throw new \Exception('File not found');
        }

        return explode(',', file_get_contents($filePath));
    }

    public function readNewLineSeperatedFile(string $filePath): array
    {
        if (!$this->fileSystem->exists($filePath)) {
            throw new \Exception('File not found');
        }

        $content = file_get_contents($filePath);
        $normalizedContent = str_replace(["\r\n", "\r"], "\n", $content);

        return explode("\n", $normalizedContent);
    }
}
