<?php

declare(strict_types = 1);

namespace App\Media\Application\Remove;

final class RemoveMediaCommand
{
    public function __construct (
        public string $mediaId,
    ) {}
}
