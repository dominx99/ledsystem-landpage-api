<?php

declare(strict_types = 1);

namespace App\Realization\Infrastructure\Hydrator;

use App\Realization\Domain\Hydrator\RealizationHydratorInterface;
use App\Realization\Domain\Resource\Realization;

final class RealizationHydrator implements RealizationHydratorInterface
{
    public function hydrate(array $data): Realization
    {
        return new Realization(
            $data['id'],
            $data['userId'],
            $data['name'],
            $data['slug'],
            $data['description'],
            (bool) $data['visibleOnMainPage'] ?? false,
        );
    }
}
