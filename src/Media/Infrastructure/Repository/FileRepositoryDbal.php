<?php

declare(strict_types = 1);

namespace App\Media\Infrastructure\Repository;

use App\Media\Domain\Repository\FileRepository;
use Doctrine\DBAL\Connection;
use App\Media\Domain\Resource\File;

final class FileRepositoryDbal implements FileRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function add(File $file): void
    {
        $this
            ->connection
            ->createQueryBuilder()
            ->insert("files")
            ->values([
                "id"       => ":id",
                "mediaId"  => ":mediaId",
                "type"     => ":type",
                "filename" => ":filename",
                "path"     => ":path",
                "fullPath" => ":fullPath",
                "url"      => ":url",
            ])
            ->setParameters([
                "id"       => $file->id,
                "mediaId"  => $file->mediaId,
                "type"     => $file->type,
                "filename" => $file->filename,
                "path"     => $file->path,
                "fullPath" => $file->fullPath,
                "url"      => $file->url,
            ])
            ->execute();
    }

    public function findByMediaId(string $mediaId): array
    {
        return $this
            ->connection
            ->createQueryBuilder()
            ->select("*")
            ->from('files', 'f')
            ->where('f.mediaId = :mediaId')
            ->setParameter('mediaId', $mediaId)
            ->execute()
            ->fetchAllAssociative();
    }

    public function findByRealizationId(string $realizationId): array
    {
        return $this
            ->connection
            ->createQueryBuilder()
            ->select("*")
            ->from('files', 'f')
            ->join('f', 'medias', 'm', 'f.mediaId = m.id')
            ->where('m.realizationId = :realizationId')
            ->setParameter('realizationId', $realizationId)
            ->execute()
            ->fetchAllAssociative();
    }

    public function removeByMediaId(string $mediaId): void
    {
        $this
            ->connection
            ->createQueryBuilder()
            ->delete("files")
            ->where("mediaId = :mediaId")
            ->setParameter("mediaId", $mediaId)
            ->execute();
    }
}
