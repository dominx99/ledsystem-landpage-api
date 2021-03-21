<?php

declare(strict_types = 1);

namespace App\Media\Domain\Type;

use App\Media\ValueObject\ImageCropPosition;

final class RealizationThumbnailImageType implements ImageTypeInterface
{
    public ImageCropPosition $cropPosition;

    public function __construct ()
    {
        $this->cropPosition = new ImageCropPosition(500, 500);
    }

    public function getSuffix(): string
    {
        return 'thumbnail';
    }

    public function getImageCropPosition(): ?ImageCropPosition
    {
        return $this->cropPosition;
    }
}
