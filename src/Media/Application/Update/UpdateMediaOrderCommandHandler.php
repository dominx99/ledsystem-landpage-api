<?php

declare(strict_types = 1);

namespace App\Media\Application\Update;

use App\Media\Domain\Repository\MediaRepository;

final class UpdateMediaOrderCommandHandler
{
    public function __construct(
        public MediaRepository $mediaRepository,
    ) {}

    public function handle(UpdateMediaOrderCommand $command): void
    {
        foreach ($command->medias as $media) {
            $this->mediaRepository->updateOrder($media['mediaId'], $media['order']);
        }
    }
}
