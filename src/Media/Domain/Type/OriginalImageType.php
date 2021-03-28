<?php

declare(strict_types = 1);

namespace App\Media\Domain\Type;

use App\Media\ValueObject\ImageCropPosition;

final class OriginalImageType implements ImageTypeInterface
{
    const TYPE = 'original';

    private ImageCropPosition $cropPosition;

    public function __construct ()
    {
        $this->cropPosition = new ImageCropPosition(1920, 1080);
    }

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
        return $this->cropPosition;
    }
}
