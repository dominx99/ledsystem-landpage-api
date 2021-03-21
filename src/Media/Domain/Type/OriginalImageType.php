<?php

declare(strict_types = 1);

namespace App\Media\Domain\Type;

use App\Media\ValueObject\ImageCropPosition;

final class OriginalImageType implements ImageTypeInterface
{
    const TYPE = 'original';

    public function getType(): string
    {
        return self::TYPE;
    }

    public function getSuffix(): string
    {
        return '';
    }

    public function getImageCropPosition(): ?ImageCropPosition
    {
        return null;
    }
}
