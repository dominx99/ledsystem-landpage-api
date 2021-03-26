<?php declare(strict_types=1);

namespace App\Realization\Application\Update;

use App\Realization\Domain\Repository\RealizationRepository;
use App\Realization\Domain\Hydrator\RealizationHydratorInterface;

final class UpdateRealizationCommandHandler
{
    public function __construct (
        private RealizationRepository $realizationRepository,
        private RealizationHydratorInterface $realizationHydrator,
    ) {}

    public function handle(UpdateRealizationCommand $command): void
    {
        $realization = $this->realizationHydrator->hydrate($command->toArray());

        $this->realizationRepository->update($realization);
    }
}
