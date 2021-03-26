<?php declare(strict_types=1);

namespace App\Realization\Infrastructure\Repository;

use App\Realization\Domain\Repository\RealizationRepository;
use App\Realization\Domain\Resource\Realization;
use Doctrine\DBAL\Connection;
use App\Realization\Domain\Exception\RealizationNotFoundException;

final class RealizationRepositoryDbal implements RealizationRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findAll(): array
    {
        return $this
            ->connection
            ->createQueryBuilder()
            ->select("*")
            ->from('realizations', 'r')
            ->execute()
            ->fetchAllAssociative();
    }

    public function find(string $id): array
    {
        $realization = $this
            ->connection
            ->createQueryBuilder()
            ->select("*")
            ->from('realizations', 'r')
            ->where('r.id = :id')
            ->setParameter('id', $id)
            ->execute()
            ->fetchAssociative();

        if (! $realization) {
            throw new RealizationNotFoundException();
        }

        return $realization;
    }

    public function findOneBySlug(string $slug): array
    {
        return $this
            ->connection
            ->createQueryBuilder()
            ->select("*")
            ->from('realizations', 'r')
            ->where('r.slug = :slug')
            ->setParameter('slug', $slug)
            ->execute()
            ->fetchAssociative();
    }

    public function add(Realization $realization): void
    {
        $this
            ->connection
            ->createQueryBuilder()
            ->insert("realizations")
            ->values([
                "id"          => ":id",
                "userId"      => ":userId",
                "name"        => ":name",
                "slug"        => ":slug",
                "description" => ":description",
            ])
            ->setParameters([
                "id"          => $realization->getId(),
                "userId"      => $realization->getUserId(),
                "name"        => $realization->getName(),
                "slug"        => $realization->getSlug(),
                "description" => $realization->getDescription(),
            ])
            ->execute();
    }

    public function update(Realization $realization): void
    {
        $this
            ->connection
            ->createQueryBuilder()
            ->update('realizations', 'r')
            ->set('r.userId', ':userId')
            ->set('r.name', ':name')
            ->set('r.slug', ':slug')
            ->set('r.description', ':description')
            ->where('id = :id')
            ->setParameters([
                "id"          => $realization->getId(),
                "userId"      => $realization->getUserId(),
                "name"        => $realization->getName(),
                "slug"        => $realization->getSlug(),
                "description" => $realization->getDescription(),
            ])
            ->execute();
    }

    public function existsBySlug(string $slug): bool
    {
        return (bool) $this
            ->connection
            ->createQueryBuilder()
            ->select(true)
            ->from("realizations", "r")
            ->where("r.slug = :slug")
            ->setParameter('slug', $slug)
            ->execute()
            ->fetchOne();
    }

    public function updateMainImageId(string $realizationId, string $mainImageId): void
    {
        $this
            ->connection
            ->createQueryBuilder()
            ->update("realizations", "r")
            ->set("r.mainImageId", ":mainImageId")
            ->where("r.id = :id")
            ->setParameters([
                'id'          => $realizationId,
                'mainImageId' => $mainImageId,
            ])
            ->execute();
    }
}
