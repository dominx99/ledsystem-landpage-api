<?php

declare(strict_types = 1);

namespace App\Realization\Domain\Hydrator;

use App\Realization\Domain\Resource\Realization;

interface RealizationHydratorInterface
{
    public function hydrate(array $data): Realization;
}
