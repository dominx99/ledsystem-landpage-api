<?php

declare(strict_types = 1);

namespace App\Media\Domain\Repository;

use App\Media\Domain\Resource\Media;

interface MediaRepository
{
    public function add(Media $media): void;
    public function findByRealizationId(string $realizationId): array;
}
