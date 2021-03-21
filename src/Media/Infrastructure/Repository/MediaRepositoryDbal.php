<?php

declare(strict_types = 1);

namespace App\Media\Infrastructure\Repository;

use App\Media\Domain\Repository\MediaRepository;
use Doctrine\DBAL\Connection;
use App\Media\Domain\Resource\Media;

final class MediaRepositoryDbal implements MediaRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function add(Media $media): void
    {
        $this
            ->connection
            ->createQueryBuilder()
            ->insert("medias")
            ->values([
                "id" => ":id",
            ])
            ->setParameters([
                "id" => $media->id,
            ])
            ->execute();
    }
}
