<?php

declare(strict_types = 1);

namespace App\Media\Application\Create;

use App\Media\Domain\Type\OriginalImageType;
use App\Media\Domain\Type\RealizationThumbnailImageType;
use App\Media\Domain\Uploader\MultipleFileUploaderInterface;
use Ramsey\Uuid\Uuid;
use App\Media\Domain\Builder\FileImageBuilderInterface;
use App\Media\Domain\Repository\FileRepository;
use App\Media\Domain\Repository\MediaRepository;
use App\Media\Domain\Resource\Media;
use App\Realization\Domain\Repository\RealizationRepository;

final class CreateMediaFromUploadedFilesCommandHandler
{
    public function __construct (
        public FileRepository $fileRepository,
        public MediaRepository $mediaRepository,
        public FileImageBuilderInterface $imageBuilder,
        public MultipleFileUploaderInterface $multipleFileUploader,
        public RealizationRepository $realizationRepository,
    ) {}

    public function handle(CreateMediaFromUploadedFilesCommand $command): void
    {
        $types = [
            new OriginalImageType(),
            new RealizationThumbnailImageType(),
        ];

        $files = [];
        $mediaIds = [];
        foreach ($command->images as $uploadedFileImage) {
            $mediaIds[] = $mediaId = (string) Uuid::uuid4();

            foreach ($types as $type) {
                $file = $this->imageBuilder->createFromUploadedFile(
                    $command->realizationId,
                    $mediaId,
                    $uploadedFileImage,
                    $type,
                );
                $files[] = $file;

                // TODO: Refactor: Single insert should not be inside foreach
                $this->fileRepository->add($file);
            }
        }

        $order = 1;
        foreach($mediaIds as $mediaId) {
            // TODO: Refactor: Single insert should not be inside foreach
            $this->mediaRepository->add(new Media(
                $mediaId,
                $command->realizationId,
                $order++,
            ));
        }

        $this->multipleFileUploader->upload($files);
    }
}
