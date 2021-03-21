<?php

declare(strict_types = 1);

namespace App\Media\ValueObject;

final class ImageCropPosition
{
    public function __construct (
        public int $width,
        public int $height,
    ) {}
}
