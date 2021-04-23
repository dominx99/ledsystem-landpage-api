<?php

declare(strict_types = 1);

namespace App\Realization\Application\Update;

use App\Realization\Domain\Repository\RealizationRepository;
use App\Realization\Infrastructure\Hydrator\RealizationHydrator;

final class ChangeRealizationVisibilityOnMainPageCommandHandler
{
    public function __construct (
        private RealizationRepository $realizationRepository,
        private RealizationHydrator $realizationHydrator,
    ) {}

    public function handle(ChangeRealizationVisibilityOnMainPageCommand $command): void
    {
        $realization = $this->realizationRepository->find($command->realizationId);
        $realization = $this->realizationHydrator->hydrate($realization);

        $realization->setVisibleOnMainPage($command->isVisible);

        $this->realizationRepository->update($realization);
    }
}
