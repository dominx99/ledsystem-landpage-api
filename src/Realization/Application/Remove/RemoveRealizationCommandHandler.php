<?php

declare(strict_types = 1);

namespace App\Realization\Application\Remove;

use App\Media\Application\Remove\RemoveMediaCommand;
use App\Media\Application\Remove\RemoveMediaCommandHandler;
use App\Realization\Domain\Repository\RealizationRepository;
use App\Media\Domain\Repository\MediaRepository;

final class RemoveRealizationCommandHandler
{
    public function __construct (
        private RealizationRepository $realizationRepository,
        private MediaRepository $mediaRepository,
        private RemoveMediaCommandHandler $removeMedia,
    ) {}

    public function handle(RemoveRealizationCommand $command): void
    {
        $realization = $this->realizationRepository->find($command->realizationId);
        $medias = $this->mediaRepository->findByRealizationId($command->realizationId);

        foreach ($medias as $media) {
            $this->removeMedia->handle(new RemoveMediaCommand(
                $media['id'],
            ));
        }

        $this->removeMedia->handle(new RemoveMediaCommand(
            $realization['mainImageId'],
        ));

        $this->realizationRepository->remove($command->realizationId);
    }
}
