<?php declare(strict_types=1);

namespace App\Realization\Domain\Repository;

use App\Realization\Domain\Resource\Realization;

interface RealizationRepository
{
    public function findAll(): array;
    public function add(Realization $realization): void;
    public function existsBySlug(string $slug): bool;
    public function updateMainImageId(string $realizationId, string $mainImageId): void;
}
