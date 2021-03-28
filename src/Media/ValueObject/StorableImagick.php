<?php

declare(strict_types = 1);

namespace App\Media\ValueObject;

use App\Media\Domain\Storable\StorableFileInterface;
use Imagick;

final class StorableImagick implements StorableFileInterface
{
    public function __construct(
        public Imagick $image
    ) {}

    public function saveTo(string $path): void
    {
        $this->image->writeImage($path);
    }
}
