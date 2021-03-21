<?php declare(strict_types=1);

namespace App\Realization\Domain\Resource;

final class Realization
{
    public function __construct(
        private string $id,
        private string $userId,
        private string $name,
        private string $slug,
        private string $description,
    ) {}

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

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
