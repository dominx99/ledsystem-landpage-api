<?php declare(strict_types=1);

namespace App\Realization\Application\Create;

use App\Realization\Domain\Repository\RealizationRepository;
use App\Realization\Domain\Resource\Realization;

final class CreateRealizationCommandHandler
{
    private RealizationRepository $realizations;

    public function __construct(RealizationRepository $realizations)
    {
        $this->realizations = $realizations;
    }

    public function handle(CreateRealizationCommand $command): void
    {
        $realization = new Realization(
            $command->id,
            $command->userId,
            $command->name,
            $command->description,
        );

        $this->realizations->add($realization);
    }
}
