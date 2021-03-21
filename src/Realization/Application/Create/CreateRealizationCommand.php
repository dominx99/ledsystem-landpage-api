<?php declare(strict_types=1);

namespace App\Realization\Application\Create;

final class CreateRealizationCommand
{
    public function __construct(
        public string $id,
        public string $userId,
        public string $name,
        public string $slug,
        public string $description,
    ) {}
}
