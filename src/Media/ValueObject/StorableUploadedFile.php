<?php

declare(strict_types = 1);

namespace App\Media\ValueObject;

use App\Media\Domain\Storable\StorableFileInterface;
use Slim\Psr7\UploadedFile;

final class StorableUploadedFile implements StorableFileInterface
{
    public function __construct(
        public UploadedFile $uploadedFile
    ) {}

    public function saveTo(string $path): void
    {
        $this->uploadedFile->moveTo($path);
    }
}
