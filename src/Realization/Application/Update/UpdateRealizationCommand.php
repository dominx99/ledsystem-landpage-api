<?php declare(strict_types=1);

namespace App\Realization\Application\Update;

final class UpdateRealizationCommand
{
    public function __construct(
        public string $id,
        public string $userId,
        public string $name,
        public string $slug,
        public string $description,
    ) {}

    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'userId'      => $this->userId,
            'name'        => $this->name,
            'slug'        => $this->slug,
            'description' => $this->description,
        ];
    }
}
