<?php

declare(strict_types = 1);

namespace App\Media\Application\Remove;

use App\Media\Domain\Repository\FileRepository;
use App\Media\Domain\Repository\MediaRepository;
use App\Media\Domain\Remover\FileRemoverInterface;

final class RemoveMediaCommandHandler
{
    public function __construct (
        public MediaRepository $mediaRepository,
        public FileRepository $fileRepository,
        public FileRemoverInterface $fileRemover,
    ) {}

    public function handle(RemoveMediaCommand $command): void
    {
        $files = $this->fileRepository->findByMediaId($command->mediaId);

        $this->mediaRepository->remove($command->mediaId);
        $this->fileRepository->removeByMediaId($command->mediaId);

        foreach ($files as $file) {
            $this->fileRemover->remove($file['fullPath']);
        }
    }
}
