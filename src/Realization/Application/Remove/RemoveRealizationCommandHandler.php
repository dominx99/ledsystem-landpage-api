<?php

declare(strict_types = 1);

namespace App\Realization\Application\Remove;

use App\Media\Application\Remove\RemoveMediaCommand;
use App\Media\Application\Remove\RemoveMediaCommandHandler;
use App\Media\Domain\Remover\FileRemoverInterface;
use App\Realization\Domain\Repository\RealizationRepository;
use App\Media\Domain\Repository\MediaRepository;
use Psr\Container\ContainerInterface;

final class RemoveRealizationCommandHandler
{
    private string $realizationsDirectory;

    public function __construct (
        private RealizationRepository $realizationRepository,
        private MediaRepository $mediaRepository,
        private RemoveMediaCommandHandler $removeMedia,
        private FileRemoverInterface $fileRemover,
        ContainerInterface $container,
    ) {
        $this->realizationsDirectory = $container->get('realizationsDirectory');
    }

    public function handle(RemoveRealizationCommand $command): void
    {
        $realization = $this->realizationRepository->find($command->realizationId);
        $medias = $this->mediaRepository->findByRealizationId($command->realizationId);

        foreach ($medias as $media) {
            $this->removeMedia->handle(new RemoveMediaCommand(
                $media['id'],
            ));
        }

        $this->fileRemover->remove(
            ($this->realizationsDirectory . DIRECTORY_SEPARATOR . $realization['id']),
        );

        $this->removeMedia->handle(new RemoveMediaCommand(
            $realization['mainImageId'],
        ));

        $this->realizationRepository->remove($command->realizationId);
    }
}
