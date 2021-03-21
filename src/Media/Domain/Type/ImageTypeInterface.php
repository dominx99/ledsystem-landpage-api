<?php

declare(strict_types = 1);

namespace App\Media\Domain\Type;

use App\Media\ValueObject\ImageCropPosition;

interface ImageTypeInterface
{
    public function getType(): string;
    public function getSuffix(): string;
    public function getImageCropPosition(): ?ImageCropPosition;
}
