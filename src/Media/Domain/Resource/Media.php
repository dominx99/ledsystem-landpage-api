<?php

declare(strict_types = 1);

namespace App\Media\Domain\Resource;

final class Media
{
    public function __construct (
        public string $id,
    ) {}
}
