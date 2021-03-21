<?php

declare(strict_types = 1);

namespace App\Media\Domain\Storable;

interface StorableFileInterface
{
    public function saveTo(string $path): void;
}
