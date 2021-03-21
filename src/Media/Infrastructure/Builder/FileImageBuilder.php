<?php

declare(strict_types = 1);

namespace App\Media\Infrastructure\Builder;

use Slim\Psr7\UploadedFile;
use Psr\Container\ContainerInterface;
use App\Media\Domain\Resource\File;
use Gumlet\ImageResize;
use App\Media\Domain\Builder\FileImageBuilderInterface;
use App\Media\Domain\Type\ImageTypeInterface;
use App\Media\ValueObject\StorableResizedImage;
use Ramsey\Uuid\Uuid;

final class FileImageBuilder implements FileImageBuilderInterface
{
    private string $realizationsDirectory;
    private string $baseUrl;

    public function __construct (
        private ContainerInterface $container,
    )
    {
        $this->realizationsDirectory = $container->get('realizationsDirectory');
        $this->baseUrl = $container->get('baseUrl');
    }

    public function createFromUploadedFile(
        string $realizationId,
        string $mediaId,
        UploadedFile $uploadedFile,
        ImageTypeInterface $type
    ): File {
        $filename = $this->buildFilename($uploadedFile, $type->getSuffix());
        $path = $this->buildPath($realizationId);

        $image = new ImageResize($uploadedFile->getFilePath());
        if ($cropPosition = $type->getImageCropPosition()) {
            $image->crop($cropPosition->width, $cropPosition->height);
        };

        return new File(
            (string) Uuid::uuid4(),
            $mediaId,
            $path,
            $filename,
            $this->buildFullPath($path, $filename),
            $this->buildUrl($realizationId, $filename),
            new StorableResizedImage($image),
        );
    }

    public function buildUrl(string $realizationId, string $filename): string
    {
        return
            $this->baseUrl . '/storage/' .
            $realizationId . '/' .
            $filename;
    }

    public function buildPath(string $realizationId): string
    {
        return $this->realizationsDirectory . DIRECTORY_SEPARATOR . $realizationId;
    }

    public function buildFullPath(string $path, string $filename): string
    {
        return $path . DIRECTORY_SEPARATOR . $filename;
    }

    private function buildFilename(UploadedFile $file, string $suffix = ''): string
    {
        $base = bin2hex(random_bytes(10));

        return $base . '_' . $suffix . '_' . $file->getClientFilename();
    }
}
