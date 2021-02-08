<?php declare(strict_types=1);

namespace App\Realization\Application\Create;

use App\Realization\Domain\Repository\RealizationRepository;
use App\Realization\Domain\Resource\Realization;

final class CreateRealizationCommandHandler
{
    public function __construct (
        private RealizationRepository $realizations,
    )
    {}

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
