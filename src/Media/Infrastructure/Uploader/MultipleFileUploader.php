<?php

declare(strict_types = 1);

namespace App\Media\Infrastructure\Uploader;

use App\Media\Domain\Uploader\MultipleFileUploaderInterface;
use Psr\Log\LoggerInterface;
use App\Media\Domain\Resource\File;

final class MultipleFileUploader implements MultipleFileUploaderInterface
{
    public function __construct (
        private LoggerInterface $logger,
    ) {}

    public function upload(array $files): void
    {
        array_walk($files, function (File $file) {
            if (! file_exists($file->path)) {
                /* mkdir($file->path); */
            }

            $file->storableFile->saveTo($file->fullPath);
        });
    }
}
