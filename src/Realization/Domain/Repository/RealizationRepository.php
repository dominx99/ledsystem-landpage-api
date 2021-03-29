<?php declare(strict_types=1);

namespace App\Realization\Domain\Repository;

use App\Realization\Domain\Resource\Realization;

interface RealizationRepository
{
    public function findAll(): array;
    public function find(string $id): array;
    public function findOneBySlug(string $slug): array;
    public function add(Realization $realization): void;
    public function update(Realization $realization): void;
    public function existsBySlug(string $slug): bool;
    public function updateMainImageId(string $realizationId, string $mainImageId): void;
    public function remove(string $realizationId): void;
}
