<?php declare(strict_types=1);

namespace App\Realization\Domain\Repository;

use App\Realization\Domain\Resource\Realization;

interface RealizationRepository
{
    public function add(Realization $realization): void;
}
