<?php

declare(strict_types = 1);

namespace App\Realization\Application\Update;

final class ChangeRealizationVisibilityOnMainPageCommand
{
    public function __construct (
        public string $realizationId,
        public bool $isVisible,
    ) {}
}
