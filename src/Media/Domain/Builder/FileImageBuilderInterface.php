<?php

declare(strict_types = 1);

namespace App\Media\Domain\Builder;

use Slim\Psr7\UploadedFile;
use App\Media\Domain\Resource\File;
use App\Media\Domain\Type\ImageTypeInterface;

interface FileImageBuilderInterface
{
    public function createFromUploadedFile(
        string $realizationId,
        string $mediaId,
        UploadedFile $uploadedFile,
        ImageTypeInterface $type
    ): File;
}
