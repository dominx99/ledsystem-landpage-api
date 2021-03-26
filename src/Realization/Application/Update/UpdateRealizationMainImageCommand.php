<?php

declare(strict_types = 1);

namespace App\Realization\Application\Update;

final class UpdateRealizationMainImageCommand
{
    public function __construct (
        public string $realizationId,
        public string $mediaId,
    ) {}
}
