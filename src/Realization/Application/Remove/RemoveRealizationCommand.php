<?php

declare(strict_types = 1);

namespace App\Realization\Application\Remove;

final class RemoveRealizationCommand
{
    public function __construct(
        public string $realizationId,
    ) {}
}
