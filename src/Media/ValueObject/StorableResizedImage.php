<?php

declare(strict_types = 1);

namespace App\Media\ValueObject;

use Gumlet\ImageResize;
use App\Media\Domain\Storable\StorableFileInterface;

final class StorableResizedImage implements StorableFileInterface
{
    public function __construct(
        public ImageResize $image
    ) {}

    public function saveTo(string $path): void
    {
        $this->image->save($path);
    }
}
