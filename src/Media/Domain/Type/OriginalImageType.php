<?php

declare(strict_types = 1);

namespace App\Media\Domain\Type;

use App\Media\ValueObject\ImageCropPosition;

final class OriginalImageType implements ImageTypeInterface
{
    public function getSuffix(): string
    {
        return '';
    }

    public function getImageCropPosition(): ?ImageCropPosition
    {
        return null;
    }
}
