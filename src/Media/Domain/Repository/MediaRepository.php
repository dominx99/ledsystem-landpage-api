<?php

declare(strict_types = 1);

namespace App\Media\Domain\Repository;

use App\Media\Domain\Resource\Media;

interface MediaRepository
{
    public function add(Media $media): void;
    public function find(string $mediaId): array;
    public function findByRealizationId(string $realizationId): array;
    public function remove(string $mediaId): void;
    public function updateOrder(string $mediaId, int $order): void;
}
