<?php declare(strict_types=1);

namespace App\Realization\Infrastructure\Repository;

use App\Realization\Domain\Repository\RealizationRepository;
use App\Realization\Domain\Resource\Realization;
use Doctrine\DBAL\Connection;

final class RealizationRepositoryDbal implements RealizationRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
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
                "description" => ":description",
            ])
            ->setParameter("id", $realization->getId())
            ->setParameter("userId", $realization->getUserId())
            ->setParameter("name", $realization->getName())
            ->setParameter("description", $realization->getDescription())
            ->execute();
    }
}
