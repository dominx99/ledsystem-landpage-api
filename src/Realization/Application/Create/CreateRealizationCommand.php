<?php declare(strict_types=1);

namespace App\Realization\Application\Create;

final class CreateRealizationCommand
{
    public string $id;
    public string $userId;
    public string $name;
    public string $description;

    public function __construct(
        string $id,
        string $userId,
        string $name,
        string $description,
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->description = $description;
    }
}
