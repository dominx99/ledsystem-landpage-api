<?php

declare(strict_types = 1);

namespace App\Media\Infrastructure\Repository;

use App\Media\Domain\Repository\MediaRepository;
use Doctrine\DBAL\Connection;
use App\Media\Domain\Resource\Media;

final class MediaRepositoryDbal implements MediaRepository
{
    public function __construct(
        private Connection $connection,
    ) {}

    public function add(Media $media): void
    {
        $this
            ->connection
            ->createQueryBuilder()
            ->insert("medias")
            ->values([
                "id"            => ":id",
                "realizationId" => ":realizationId",
                "`order`"       => ":order",
            ])
            ->setParameters([
                "id"            => $media->id,
                "realizationId" => $media->realizationId,
                "order"         => $media->order,
            ])
            ->execute();
    }

    public function find(string $mediaId): array
    {
        return $this
            ->connection
            ->createQueryBuilder()
            ->select("*")
            ->from('medias', 'm')
            ->where('m.id = :mediaId')
            ->setParameter('mediaId', $mediaId)
            ->execute()
            ->fetchAssociative();
    }

    public function findByRealizationId(string $realizationId): array
    {
        return $this
            ->connection
            ->createQueryBuilder()
            ->select("*")
            ->from('medias', 'm')
            ->where('m.realizationId = :realizationId')
            ->setParameter('realizationId', $realizationId)
            ->orderBy('`order`')
            ->execute()
            ->fetchAllAssociative();
    }

    public function remove(string $mediaId): void
    {
        $this
            ->connection
            ->createQueryBuilder()
            ->delete("medias")
            ->where("medias.id = :mediaId")
            ->setParameter("mediaId", $mediaId)
            ->execute();
    }

    public function updateOrder(string $mediaId, int $order): void
    {
        $this
            ->connection
            ->createQueryBuilder()
            ->update("medias", "m")
            ->set("m.order", ":order")
            ->where("m.id = :id")
            ->setParameters([
                'id'    => $mediaId,
                'order' => $order,
            ])
            ->execute();
    }
}
