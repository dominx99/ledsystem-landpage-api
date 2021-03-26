<?php

declare(strict_types = 1);

namespace App\Realization\Application\Update;

use App\Realization\Domain\Repository\RealizationRepository;

final class UpdateRealizationMainImageCommandHandler
{
    public function __construct (
        private RealizationRepository $realizationRepository
    ) {}

    public function handle(UpdateRealizationMainImageCommand $command): void
    {
        $this->realizationRepository->updateMainImageId($command->realizationId, $command->mediaId);
    }
}
