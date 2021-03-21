<?php

declare(strict_types = 1);

namespace App\Media\Domain\Repository;

use App\Media\Domain\Resource\File;

interface FileRepository
{
    public function add(File $file): void;
    public function findByMediaId(string $mediaId): array;
}
