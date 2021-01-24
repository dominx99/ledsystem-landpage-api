<?php declare(strict_types=1);

namespace App\Realization\Domain\Resource;

final class Realization
{
    private string $id;
    private string $userId;
    private string $name;
    private string $description;

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

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
