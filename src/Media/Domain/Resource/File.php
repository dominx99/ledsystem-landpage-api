<?php

declare(strict_types = 1);

namespace App\Media\Domain\Resource;

use App\Media\Domain\Storable\StorableFileInterface;

final class File
{
    public function __construct(
        public string $id,
        public string $mediaId,
        public string $path,
        public string $filename,
        public string $fullPath,
        public string $url,
        public StorableFileInterface $storableFile,
    ) {}
}
